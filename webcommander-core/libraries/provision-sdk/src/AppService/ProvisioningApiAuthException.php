<?php
namespace Webmascot\AppService;

use Exception;

class ProvisioningApiAuthException extends Exception
{

    protected $_messageTemplate = '%s';
    public $httpCode = 500;
    public $apiResponse = null;

    public function __construct($message = '', $httpCode, $apiResponse = null)
    {
        $this->httpCode = $httpCode;
        $this->code = $httpCode;
        $this->apiResponse = $apiResponse;
        parent::__construct($message, $httpCode);
    }

}
