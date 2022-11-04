<?php
namespace Webmascot\ApiHelper\Communicator;

use Webmascot\ApiHelper\ProvisioningApiResponseUtil;
use Webmascot\ApiHelper\Communicator\Data\ProvisioningAuthCredentialData;
use Webmascot\AppService\ProvisioningApiException;
use Webmascot\AppService\ProvisioningUtil;
use Webmascot\ApiHelper\Constant\ProvisioningConstant;
use stdClass;

class ProvisioningOAuth2ApiCaller
{

    private $httpCommunicator;
    private $authCredentialData;
    private $authenticationHeader = [];
    private $jsonDecodeArray;
    const REQUEST_AGAIN = "REQUEST_AGAIN";
    const TOKEN_RENEW_URL = "/manage-base/api/v1/write/auth-client/token";
    private $loop = 0;
    public $tokenRenewCallback = null;


    public function __construct(ProvisioningAuthCredentialData $authCredentialData = null, $jsonDecodeArray = true)
    {
        $this->httpCommunicator = ProvisioningApiCaller::getInstance();
        $this->authCredentialData = $authCredentialData;
        $this->tokenRenewCallback = $authCredentialData->getAuthTokenRenewCallback();
        $this->setAccessToken($authCredentialData->getAccessToken());
        $this->jsonDecodeArray = $jsonDecodeArray;
    }

    private function setAccessToken($accessToken){
        $this->authenticationHeader = ["access-token:" . $accessToken];
    }

    private function setAccessTokenInHeader($headers = array()){
        if ($headers !== null){
            return array_merge($headers, $this->authenticationHeader);
        }else{
            return $this->authenticationHeader;
        }
    }

    private function renewAccessToken($statusCode)
    {
        try {
            $params = [
                "grant_type" => ProvisioningConstant::GRANT_TYPE_REFRESH_TOKEN,
                "client_secret" => $this->authCredentialData->getClientSecret(),
                "code" => $this->authCredentialData->getCode(),
                "refresh_token" => $this->authCredentialData->getRefreshToken(),
            ];
            if ($statusCode === ProvisioningApiResponseUtil::NOT_FOUND_SYSTEM_CODE){
                $params["grant_type"] = ProvisioningConstant::GRANT_TYPE_AUTHORIZATION_CODE;
                $params["client_id"] = $this->authCredentialData->getClientId();
            }
            $apiResponse = $this->httpCommunicator->POST_JSON(ProvisioningUtil::concatURL($this->authCredentialData->getUrl(), self::TOKEN_RENEW_URL), $params);
            if (isset($apiResponse['code']) && $apiResponse['code'] === 200 && isset($apiResponse['response'])) {
                $json = json_decode($apiResponse['response'], true);
                $responseData = ProvisioningUtil::getValueWithException($json, "responseData", "Unable Get data from API");
                $this->authCredentialData->setAccessToken(ProvisioningUtil::getValueWithException($responseData, "access_token", "Unable Get data from API"));
                $this->authCredentialData->setRefreshToken(ProvisioningUtil::getValueWithException($responseData, "refresh_token", "Unable Get data from API"));
                $this->setAccessToken($this->authCredentialData->getAccessToken());
                if ($this->tokenRenewCallback !== null){
                    call_user_func($this->tokenRenewCallback, $this->authCredentialData);
                }
            } else {
                $requestResponse = new stdClass();
                $requestResponse->isSuccess = false;
                $requestResponse->statusCode = ProvisioningApiResponseUtil::NOT_FOUND_SYSTEM_CODE;
                $responseDecode = json_decode($apiResponse['response']);
                $isSuccess = ProvisioningUtil::getValue($responseDecode,'isSuccess');
                $statusCode = ProvisioningUtil::getValue($responseDecode,'statusCode');
                $message = ProvisioningUtil::getValue($responseDecode,'message');
                if(!is_null($isSuccess)) {
                    $requestResponse->isSuccess = $isSuccess;
                    $requestResponse->statusCode = $statusCode;
                    $requestResponse->message = $message;
                    $response = $requestResponse;
                }else{
                    $requestResponse->message = "Network Error";
                    $response = $requestResponse;
                }
                throw new ProvisioningApiException(json_encode($response));
            }
        } catch (ProvisioningApiException $appException) {
            throw new ProvisioningApiException($appException->getMessage());
        }
    }


    private function responseProcessor($apiResponse){
        try {
            if (isset($apiResponse['code']) && $apiResponse['code'] === 200 && isset($apiResponse['response'])){
                return json_decode($apiResponse['response'], $this->jsonDecodeArray);
            }else{
                if (isset($apiResponse['response'])) {
                    $requestResponse = new stdClass();
                    $requestResponse->isSuccess = false;
                    $requestResponse->statusCode = ProvisioningApiResponseUtil::NOT_FOUND_SYSTEM_CODE;
                    $responseDecode = json_decode($apiResponse['response']);
                    $isSuccess = ProvisioningUtil::getValue($responseDecode,'isSuccess');
                    $statusCode = ProvisioningUtil::getValue($responseDecode,'statusCode');
                    $message = ProvisioningUtil::getValue($responseDecode,'message');
                    if(!is_null($isSuccess)) {
                        if ($this->loop < 3) {
                            $this->renewAccessToken($statusCode);
                            $this->loop++;
                            throw new ProvisioningApiException(self::REQUEST_AGAIN);
                        }
                        $requestResponse->message = $message;
                    }else{
                        $requestResponse->message = "Network Error";
                    }
                    return $requestResponse;
                }else{
                    throw new ProvisioningApiException($apiResponse);
                }
            }
        } catch (ProvisioningApiException $appException) {
            throw new ProvisioningApiException($appException->getMessage());
        }
    }

    public function DELETE_JSON($url, $params, $headers = array()){
        $headersWithToken = $this->setAccessTokenInHeader($headers);
        $response = $this->httpCommunicator->DELETE_JSON($url, $params, $headersWithToken);
        try {
            $response = $this->responseProcessor($response);
        } catch (ProvisioningApiException $e) {
            if($e->getMessage() === self::REQUEST_AGAIN){
                $response = $this->DELETE_JSON($url, $params, $headers);
            }else{
                $response = json_decode($e->getMessage());
            }
        }
        return $response;
    }

    public function POST_JSON($url, $params, $headers = array())
    {
        $headersWithToken = $this->setAccessTokenInHeader($headers);
        $response = $this->httpCommunicator->POST_JSON($url, $params, $headersWithToken);
        try {
            $response = $this->responseProcessor($response);
        } catch (ProvisioningApiException $e) {
            if($e->getMessage() === self::REQUEST_AGAIN){
                $response = $this->POST_JSON($url, $params, $headers);
            }else{
                $response = json_decode($e->getMessage());
            }
        }
        return $response;
    }

    public function GET($url, $params = array(), $headers = array())
    {
        $headersWithToken = $this->setAccessTokenInHeader($headers);
        $response = $this->httpCommunicator->GET($url, $params, $headersWithToken);
        try {
            $response = $this->responseProcessor($response);
        } catch (ProvisioningApiException $e) {
            if($e->getMessage() === self::REQUEST_AGAIN){
                $response = $this->GET($url, $params, $headers);
            }else{
                $response = json_decode($e->getMessage());
            }
        }
        return $response;
    }
}
