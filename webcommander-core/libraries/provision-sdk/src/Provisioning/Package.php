<?php
namespace Webmascot\Provisioning;

use Webmascot\ApiHelper\ProvisioningApiSchemeHelper;
use Webmascot\ApiHelper\ProvisioningRequestBuilder;
use Webmascot\AppService\ProvisioningApiException;

class Package
{
    private $provisioning;

    const PACKAGE_LIST_API = "/manage-instance/api/v1/read/management-hub/package-list-by-partner-uuid-and-generation";
    const PACKAGE_DETAILS_API = "/manage-instance/api/v1/read/management-hub/package-details";

    public function __construct(Provisioning $provisioning)
    {
        $this->provisioning = $provisioning;
    }

    public function listAll($partnerUuid = "ALL_PARTNER", $generation = "A"){
        $requestBuilder = new ProvisioningRequestBuilder($this->provisioning->getAuthCredentialData());
        try {
            return $requestBuilder->customRequest(self::PACKAGE_LIST_API, ProvisioningApiSchemeHelper::GET, [
                'generation' => $generation,
                'partner_uuid' => $partnerUuid
            ]);
        } catch (ProvisioningApiException $e) {
            throw new ProvisioningApiException($e->getMessage());
        }
    }

    public function details($packageUuid){
        $requestBuilder = new ProvisioningRequestBuilder($this->provisioning->getAuthCredentialData());
        try {
            return $requestBuilder->customRequest(self::PACKAGE_DETAILS_API, ProvisioningApiSchemeHelper::GET, [
                'uuid' => $packageUuid
            ]);
        } catch (ProvisioningApiException $e) {
            throw new ProvisioningApiException($e->getMessage());
        }
    }
}
