<?php
namespace Webmascot\ApiHelper\Communicator;

use stdClass;
use Webmascot\ApiHelper\ProvisioningApiHelper;
use Webmascot\ApiHelper\ProvisioningApiSchemeHelper;
use Webmascot\ApiHelper\Communicator\Data\ProvisioningApiRequestData;
use Webmascot\ApiHelper\Communicator\Data\ProvisioningAuthCredentialData;

class ProvisioningApiDataResolver
{

    public function requestToAPI(ProvisioningAuthCredentialData $authCredentialData, ProvisioningApiRequestData $apiRequestData){
        $apiResponse = null;
        $httpCommunication = new ProvisioningOAuth2ApiCaller($authCredentialData);
        if ($apiRequestData->request !== null){
            $apiEngine = new ProvisioningApiHelper();
            $apiRequestObject = $apiEngine->processRequestInputAndHeader($apiRequestData->request);
            $apiRequestData->params = $apiRequestObject->rawParams;
        }
        if ($apiRequestData->requestMethod ===  ProvisioningApiSchemeHelper::POST){
            $apiResponse = $httpCommunication->POST_JSON($authCredentialData->getUrl() . $apiRequestData->url, $apiRequestData->params);
        }elseif ($apiRequestData->requestMethod ===  ProvisioningApiSchemeHelper::DELETE){
            $apiResponse = $httpCommunication->DELETE_JSON($authCredentialData->getUrl() . $apiRequestData->url, $apiRequestData->params);
        }else{
            $apiResponse = $httpCommunication->GET($authCredentialData->getUrl() . $apiRequestData->url, $apiRequestData->params);
        }
        return $apiResponse;
    }

    public function getPostParamsData($url){
        return ProvisioningApiRequestData::postRequestInstance($url);
    }

    public function getGetParamsData($url){
        return ProvisioningApiRequestData::getRequestInstance($url);
    }

    public function getDeleteParamsData($url){
        return ProvisioningApiRequestData::deleteRequestInstance($url);
    }
}
