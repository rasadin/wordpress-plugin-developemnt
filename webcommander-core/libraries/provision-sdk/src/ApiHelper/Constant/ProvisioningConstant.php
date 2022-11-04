<?php
namespace Webmascot\ApiHelper\Constant;

class ProvisioningConstant
{

    const ACCEPT_POST_TYPE = "application/json";
    const IS_SUCCESS = "isSuccess";
    const STATUS_CODE = "statusCode";
    const BASE = "base";

    const GRANT_TYPE_AUTHORIZATION_CODE = "authorization_code";
    const GRANT_TYPE_REFRESH_TOKEN = "refresh_token";
    const GRANT_TYPE_BEARER = "Bearer";
    const ACCESS_TOKEN_EXPIRY = 3600;

    const PACKAGE = "PACKAGE";
    const TEMPLATE = "TEMPLATE";
    const ADD_ON = "ADDONS";
    const FEATURE = "FEATURE";
}
