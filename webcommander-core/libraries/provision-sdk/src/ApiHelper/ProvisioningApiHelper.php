<?php
namespace Webmascot\ApiHelper;


use Webmascot\ApiHelper\Communicator\Data\ProvisioningApiRequestObject;

class ProvisioningApiHelper
{

    private function getRequestType($requestObject)
    {
        if ($requestObject->is("get")) {
            return ProvisioningApiSchemeHelper::GET;
        } elseif ($requestObject->is("post")) {
            return ProvisioningApiSchemeHelper::POST;
        } elseif ($requestObject->is("delete")) {
            return ProvisioningApiSchemeHelper::DELETE;
        }
    }

    public function processRequestInputAndHeader($requestObject)
    {
        $apiRequestObject = new ProvisioningApiRequestObject();
        $apiRequestObject->httpMethod = $this->getRequestType($requestObject);
        if ($apiRequestObject->httpMethod === ProvisioningApiSchemeHelper::GET) {
            $apiRequestObject->rawParams = $requestObject->getQueryParams();
        } elseif ($apiRequestObject->httpMethod === ProvisioningApiSchemeHelper::POST || $apiRequestObject->httpMethod === ProvisioningApiSchemeHelper::DELETE) {
            $apiRequestObject->rawParams = $requestObject->getData();
        }
        $apiRequestObject->contextType = $requestObject->getHeaderLine('Content-Type');
        return $apiRequestObject;
    }

}
