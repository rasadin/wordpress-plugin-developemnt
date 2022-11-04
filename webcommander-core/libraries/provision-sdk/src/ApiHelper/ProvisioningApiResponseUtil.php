<?php
namespace Webmascot\ApiHelper;


use Webmascot\AppService\ProvisioningApiAuthException;
use Webmascot\ApiHelper\Constant\ProvisioningConstant;

class ProvisioningApiResponseUtil
{

    const BAD_REQUEST_HTTP_CODE = 400;
    const UNAUTHORIZED_HTTP_CODE = 401;
    const FORBIDDEN_HTTP_CODE = 403;
    const NOT_FOUND_HTTP_CODE = 404;
    const INTERNAL_SERVER_ERROR_HTTP_CODE = 500;

    const BAD_REQUEST_SYSTEM_CODE = 1400;
    const UNAUTHORIZED_SYSTEM_CODE = 1401;
    const FORBIDDEN_SYSTEM_CODE = 1403;
    const NOT_FOUND_SYSTEM_CODE = 1404;
    const INTERNAL_SERVER_ERROR_SYSTEM_CODE = 1500;


    private static function responseGenerator($isSuccess = true, $data, $responseKey = "responseData", $statusCode = 1200)
    {
        return array(
            ProvisioningConstant::IS_SUCCESS => $isSuccess,
            ProvisioningConstant::STATUS_CODE => $statusCode,
            "$responseKey" => $data
        );
    }

    public static function successResponseMessageWithKey($message, $messageKey, $statusCode = 1200)
    {
        return self::responseGenerator(true, $message, $messageKey, $statusCode);
    }

    public static function successResponseMessage($message, $statusCode = 1200)
    {
        return self::responseGenerator(true, $message, "message", $statusCode);
    }

    public static function successResponseList($total, $data)
    {
        return self::successResponseData(array(
            "total" => $total,
            "list" => $data,
        ));
    }

    public static function successResponseData($data, $statusCode = 1200)
    {
        return self::responseGenerator(true, $data, "responseData", $statusCode);
    }

    public static function happyResponse()
    {
        return self::responseGenerator(true, "Hurrah", "message");
    }


    public static function responseList($data)
    {
        return self::responseGenerator(true, $data);
    }

    public static function responseSingle($data)
    {
        return self::responseGenerator(true, $data);
    }


    public static function failedResponse($message, $statusCode = 1500)
    {
        return self::responseGenerator(false, $message, "message", $statusCode);
    }


    public static function sentException($message, $httpCode, $systemCode, $isSuccess)
    {
        $apiResponse = self::responseGenerator($isSuccess, $message, "message", $systemCode);
        return new ProvisioningApiAuthException($message, $httpCode, $apiResponse);
    }

    public static function sent404Exception($message)
    {
        return self::sentException($message, self::NOT_FOUND_HTTP_CODE, self::NOT_FOUND_SYSTEM_CODE, false);
    }

    public static function sentUnauthorizedException($message)
    {
        return self::sentException($message, self::UNAUTHORIZED_HTTP_CODE, self::UNAUTHORIZED_SYSTEM_CODE, false);
    }

    public static function sentBadRequestException($message)
    {
        return self::sentException($message, self::BAD_REQUEST_HTTP_CODE, self::BAD_REQUEST_SYSTEM_CODE, false);
    }

    public static function sentInternalServerException($message)
    {
        return self::sentException($message, self::INTERNAL_SERVER_ERROR_HTTP_CODE, self::INTERNAL_SERVER_ERROR_SYSTEM_CODE, false);
    }


}
