<?php
namespace Webmascot\Provisioning;

use Webmascot\ApiHelper\ProvisioningApiSchemeHelper;
use Webmascot\ApiHelper\ProvisioningRequestBuilder;
use Webmascot\AppService\ProvisioningApiException;

class Price
{
    private $provisioning;

    const TIERED_ITEM_PRICE_WITH_TAX = "/manage-instance/api/v1/read/management-hub/tiered-item-tax";

    public function __construct(Provisioning $provisioning)
    {
        $this->provisioning = $provisioning;
    }

    public function getAmountWithTax($tieredUuid, $countryCode){
        $requestBuilder = new ProvisioningRequestBuilder($this->provisioning->getAuthCredentialData());
        try {
            return $requestBuilder->customRequest(self::TIERED_ITEM_PRICE_WITH_TAX, ProvisioningApiSchemeHelper::GET, [
                'tiered_pricing_uuid' => $tieredUuid,
                'country_code' => $countryCode
            ]);
        } catch (ProvisioningApiException $e) {
            throw new ProvisioningApiException($e->getMessage());
        }
    }
}
