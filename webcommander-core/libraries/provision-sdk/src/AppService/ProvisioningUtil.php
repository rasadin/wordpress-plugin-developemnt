<?php
namespace Webmascot\AppService;

use Webmascot\ApiHelper\Constant\ProvisioningConstant;

class ProvisioningUtil
{

    public static function concatURL($firstURL, $secondURL, $removeLastChar = null){
        if (substr($firstURL, -1) === "/"){
            $firstURL = substr($firstURL, 0,-1);
        }

        if (substr($secondURL, 0, 1) === "/"){
            $secondURL = substr($secondURL, 1);
        }
        $url = $firstURL . "/" . $secondURL;

        if ($removeLastChar !== null && substr($url, -1) === $removeLastChar){
            $url = substr($url, 0,-1);
        }
        return $url;
    }

    public static function generateRandomString() {
        return md5(uniqid(mt_rand(), true));
    }


    public static function md5($text){
        return md5($text);
    }


    public static function isExpireToken($lastModified, $expiry = ProvisioningConstant::ACCESS_TOKEN_EXPIRY)
    {
        if (time() - strtotime($lastModified) > $expiry) {
            return true;
        }
        return false;
    }

    public static function getValue($objectOrArray, $key, $defaultValue = null){
        if (is_array($objectOrArray) && isset($objectOrArray[$key])){
            return $objectOrArray[$key];
        }elseif (isset($objectOrArray->{$key})){
            return $objectOrArray->{$key};
        }else{
            return $defaultValue;
        }
    }

    public static function getValueWithException($objectOrArray, $key, $defaultValue = null, $message = ""){
        $response = self::getValue($objectOrArray, $key, $defaultValue);
        if ($response === $defaultValue){
            throw new ProvisioningApiException($message);
        }
        return $response;
    }


    public static function setValue($objectOrArray, $key, $value){
        if (isset($objectOrArray[$key])){
            return $objectOrArray[$key] = $value;
        }elseif (isset($objectOrArray->{$key})){
            return $objectOrArray->{$key} = $value;
        }else{
            if (is_array($objectOrArray)){
                $objectOrArray[$key] = $value;
            }else{
                $objectOrArray->{$key} = $value;
            }
        }
    }

    public static function copyToObjectProperty($arrayOrObject, $actualObject){
        if (isset($arrayOrObject)){
            foreach ($arrayOrObject as $property => $value ){
                if (isset($actualObject->{$property})){
                    $actualObject->{$property} = $value;
                }
            }
            return $actualObject;
        }
        return null;
    }

    public static function copyArray($source, $copyFrom, $skipp = [""]){
        foreach ($copyFrom as $property => $value ){
            if (isset($source[$property]) && !in_array($value, $skipp)){
                $source[$property] = $value;
            }
        }
        return $source;
    }


    public static function upperCase($text){
       return strtoupper($text);
    }

    public static function convertToObject($arrayObject)
    {
        $string = json_encode($arrayObject);
        return json_decode($string);
    }



    public static function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    public static function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return $length === 0 || (substr($haystack, -$length) === $needle);
    }

    public static function parseApiResponse($response, $isJsonArray = true, $returnObject = "responseData"){
        if (!isset($response['code']) || $response['code'] !== 200 || !isset($response['response'])){
            throw new ProvisioningApiException("Unable to Pull Data from API");
        }
        $response = json_decode($response['response'], $isJsonArray);
        if ($returnObject !== null){
           return (isset($response[$returnObject]) ? $response[$returnObject] : $response);
        }
        return $response;
    }

    public static function validateDate($date, $defaultDate = null)
    {
        if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)) {
            return $date;
        }elseif (!is_null($defaultDate)){
            self::validateDate($defaultDate);
        }

        throw new ProvisioningApiException("Date $date is not in valid format. Example: 2019-10-22");
    }

    public static function isValidUuid($uuid) {
        $uuid = strtolower($uuid);
        if (!is_string($uuid) || (preg_match('/^[0-9a-f]{8}-(?:[0-9a-f]{4}-){3}[0-9a-f]{12}$/', $uuid) !== 1)) {
            return false;
        }
        return true;
    }

    public static function commaDelimitedStringToArray($commaDelimitedString) {
        if(is_string($commaDelimitedString)) {
            return explode(",", $commaDelimitedString);
        }
        return [];
    }
}
