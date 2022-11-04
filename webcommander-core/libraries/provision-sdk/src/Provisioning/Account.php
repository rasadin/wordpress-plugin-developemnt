<?php
namespace Webmascot\Provisioning;

use Webmascot\ApiHelper\ProvisioningApiSchemeHelper;
use Webmascot\ApiHelper\ProvisioningRequestBuilder;
use Webmascot\AppService\ProvisioningApiException;
use Webmascot\AppService\ProvisioningUtil;

class Account
{
    private $provisioning;

    const SIGN_UP_API = "/manage-trial/api/v1/write/trial-sign-up/create-trial-sign-up";
    const EMAIL_CHECK_API = "/manage-trial/api/v1/read/trial-sign-up/get-entity-by-email";
    const LOGIN_API = "/manage-instance/api/v1/read/management-hub/account-info-by-email-and-password";
    const ACCOUNT_INFO_API = "/manage-instance/api/v1/read/management-hub/get-account-info";
    const SUBSCRIPTION_API = "/manage-instance/api/v1/write/management-hub/change-subscription";

    public function __construct(Provisioning $provisioning)
    {
        $this->provisioning = $provisioning;
    }

    public function isEmailExists($email){
        $requestBuilder = new ProvisioningRequestBuilder($this->provisioning->getAuthCredentialData());
        try {
            $response = $requestBuilder->customRequest(self::EMAIL_CHECK_API, ProvisioningApiSchemeHelper::GET, [
                "email" => $email
            ]);

            if(ProvisioningUtil::getValue($response,'isSuccess') && ProvisioningUtil::getValue(ProvisioningUtil::getValue($response,'responseData'),'email') === $email){
                return [
                    'isSuccess' => true,
                    'statusCode' => 1200,
                    'responseData' => [
                        'isEmailExists' => true
                    ]
                ];
            }
            return [
                'isSuccess' => true,
                'statusCode' => 1200,
                'responseData' => [
                    'isEmailExists' => false
                ]
            ];
        } catch (ProvisioningApiException $e) {
            throw new ProvisioningApiException($e->getMessage());
        }
    }

    public function loginByEmailAndPassword($email, $password){
        $requestBuilder = new ProvisioningRequestBuilder($this->provisioning->getAuthCredentialData());
        try {
            return $requestBuilder->customRequest(self::LOGIN_API, ProvisioningApiSchemeHelper::POST, [
                "email" => $email,
                "password" => $password
            ]);
        } catch (ProvisioningApiException $e) {
            throw new ProvisioningApiException($e->getMessage());
        }
    }

    public function signUp(array $subscriptionData){
        $requestBuilder = new ProvisioningRequestBuilder($this->provisioning->getAuthCredentialData());
        try {
            return $requestBuilder->customRequest(self::SIGN_UP_API, ProvisioningApiSchemeHelper::POST, $subscriptionData);
        } catch (ProvisioningApiException $e) {
            throw new ProvisioningApiException($e->getMessage());
        }
    }
}
