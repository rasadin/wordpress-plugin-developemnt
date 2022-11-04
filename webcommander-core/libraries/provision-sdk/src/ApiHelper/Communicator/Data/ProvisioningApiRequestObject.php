<?php
namespace Webmascot\ApiHelper\Communicator\Data;

use Webmascot\ApiHelper\Communicator\ProvisioningApiCaller;

class ProvisioningApiRequestObject
{

    public $httpMethod;
    public $rawParams = null;
    public $processedParams = null;
    public $processedCondition = null;
    public $contextType = ProvisioningApiCaller::APPLICATION_JSON_CONTEXT_TYPE;
    public $apiEngine = null;

}
