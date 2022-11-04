<?php
namespace Webmascot\ApiHelper\Communicator\Data;

class ProvisioningAuthCredentialData
{
    private $clientId;
    private $clientSecret;
    private $accessToken;
    private $refreshToken;
    private $code;
    private $url;
    private $authTokenRenewCallback;
    private $instanceIdentifier;

    public function __construct($params = [])
    {
        foreach ($params as $key => $value) {
            if (property_exists($this, $key)){
                $this->$key = $value;
            }
        }
    }

    public function getClientId()
    {
        return $this->clientId;
    }

    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    public function setClientSecret($clientSecret)
    {
        $this->clientSecret = $clientSecret;
    }

    public function getAccessToken()
    {
        return $this->accessToken;
    }

    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    public function setRefreshToken($refreshToken)
    {
        $this->refreshToken = $refreshToken;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getAuthTokenRenewCallback()
    {
        return $this->authTokenRenewCallback;
    }

    public function setAuthTokenRenewCallback($authRenewCallbackFunction)
    {
        $this->authTokenRenewCallback = $authRenewCallbackFunction;
    }

    public function getInstanceIdentifier()
    {
        return $this->instanceIdentifier;
    }

    public function setInstanceIdentifier($instanceIdentifier)
    {
        $this->instanceIdentifier = $instanceIdentifier;
    }

}
