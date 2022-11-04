<?php
namespace Webmascot\ApiHelper\Communicator\Data;

class ProvisioningApiRequestData
{
    const POST = "post";
    const GET = "get";
    const DELETE = "delete";

    const URL_PARAMS_REQUEST = "application/x-www-form-urlencoded";
    const FORM_DATA_REQUEST = "application/x-www-form-urlencoded";
    const JSON_DATA_REQUEST = "application/json";

    public $requestMethod;
    public $url;
    public $contextType;
    public $params;
    public $request = null;
    public $jsonDecodeArray = true;

    public static function getRequestInstance($url){
        $instance = new ProvisioningApiRequestData();
        $instance->url = $url;
        $instance->contextType = self::URL_PARAMS_REQUEST;
        $instance->requestMethod = self::GET;
        return $instance;
    }

    public static function postRequestInstance($url){
        $instance = new ProvisioningApiRequestData();
        $instance->url = $url;
        $instance->contextType = self::JSON_DATA_REQUEST;
        $instance->requestMethod = self::POST;
        return $instance;
    }

    public static function deleteRequestInstance($url){
        $instance = new ProvisioningApiRequestData();
        $instance->url = $url;
        $instance->contextType = self::JSON_DATA_REQUEST;
        $instance->requestMethod = self::DELETE;
        return $instance;
    }


    public function getParams()
    {
        return $this->params;
    }


    public function setParams($key,  $value)
    {
        $this->params[$key] = $value;
        return $this;
    }

    public function setParamArray($array)
    {
        $this->params = $array;
        return $this;
    }


    public function getRequest()
    {
        return $this->getRequest();
    }


    public function setRequest($request)
    {
        $this->request = $request;
        return $this;
    }

    public function getApiRequestObject(){
        $requestObject = new ProvisioningApiRequestObject();
        $requestObject->rawParams = $this->params;
        $requestObject->httpMethod = $this->requestMethod;
        $requestObject->contextType = $this->contextType;
        return $requestObject;
    }

    public function resetParams(){
        $this->params = array();
    }


}
