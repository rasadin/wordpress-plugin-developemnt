<?php
namespace Webmascot\ApiHelper;

use Webmascot\ApiHelper\Communicator\Data\ProvisioningAuthCredentialData;
use Webmascot\ApiHelper\Communicator\ProvisioningApiDataResolver;
use Webmascot\AppService\ProvisioningApiException;

class ProvisioningRequestBuilder
{
    private $authCredentialData;
    public function __construct(ProvisioningAuthCredentialData $authCredentialData)
    {
        $this->authCredentialData = $authCredentialData;
    }

    public function listAll($apiUrl, $max, $offset, $filter = []){
        $apiDataResolver = new ProvisioningApiDataResolver();
        $requestToApiData = $apiDataResolver->getPostParamsData($apiUrl);
        $requestToApiData->setParamArray([
            "max" => $max,
            "offset" => $offset
        ]);
        return $apiDataResolver->requestToAPI($this->authCredentialData, $requestToApiData);
    }

    public function details($apiUrl, $itemUuid){
        $apiDataResolver = new ProvisioningApiDataResolver();
        $requestToApiData = $apiDataResolver->getGetParamsData($apiUrl);
        $requestToApiData->setParamArray([
            "condition" => [
                "EQ" => [
                    "uuid" => $itemUuid
                ]
            ]
        ]);
        return $apiDataResolver->requestToAPI($this->authCredentialData, $requestToApiData);
    }

    public function customRequest($apiUrl, $requestMethod, $params = []){
        $apiDataResolver = new ProvisioningApiDataResolver();
        switch ($requestMethod){
            case ProvisioningApiSchemeHelper::GET:
                $requestToApiData = $apiDataResolver->getGetParamsData($apiUrl);
                break;
            case ProvisioningApiSchemeHelper::POST:
                $requestToApiData = $apiDataResolver->getPostParamsData($apiUrl);
                break;
            case ProvisioningApiSchemeHelper::DELETE:
                $requestToApiData = $apiDataResolver->getDeleteParamsData($apiUrl);
                break;
            default:
                throw new ProvisioningApiException("Please specify a valid request method type. e.g: get / post / delete");
        }
        $requestToApiData->setParamArray($params);
        return $apiDataResolver->requestToAPI($this->authCredentialData, $requestToApiData);
    }
}
