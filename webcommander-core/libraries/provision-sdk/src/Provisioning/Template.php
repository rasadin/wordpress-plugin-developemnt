<?php
namespace Webmascot\Provisioning;

use Webmascot\ApiHelper\ProvisioningApiSchemeHelper;
use Webmascot\ApiHelper\ProvisioningRequestBuilder;
use Webmascot\AppService\ProvisioningApiException;

class Template
{
    private $provisioning;
    const TEMPLATE_LIST_API = "/manage-instance/api/v1/read/management-hub/template-list-with-illustrator";
    const TEMPLATE_DETAILS_API = "/manage-instance/api/v1/read/management-hub/template-details-with-illustrator";
    const TEMPLATE_TYPE_AND_CATEGORY_API = "/manage-instance/api/v1/read/management-hub/template-types-and-categories";
    const TEMPLATE_CATEGORY_BY_TYPE_API = "/manage-instance/api/v1/read/management-hub/template-categories-by-template-type";

    public function __construct(Provisioning $provisioning)
    {
        $this->provisioning = $provisioning;
    }

    public function listAll($max = null, $offset = null, $search = null, $type = null, $categories = null){
        $requestBuilder = new ProvisioningRequestBuilder($this->provisioning->getAuthCredentialData());
        try {
            return $requestBuilder->customRequest(self::TEMPLATE_LIST_API, ProvisioningApiSchemeHelper::GET, [
                'max' => $max,
                'offset' => $offset,
                'search_value' => $search,
                'type' => $type,
                'categories' => $categories
            ]);
        } catch (ProvisioningApiException $e) {
            throw new ProvisioningApiException($e->getMessage());
        }
    }

    public function details($templateUuid){
        $requestBuilder = new ProvisioningRequestBuilder($this->provisioning->getAuthCredentialData());
        try {
            return $requestBuilder->customRequest(self::TEMPLATE_DETAILS_API, ProvisioningApiSchemeHelper::GET, [
                'uuid' => $templateUuid
            ]);
        } catch (ProvisioningApiException $e) {
            throw new ProvisioningApiException($e->getMessage());
        }
    }

    public function typesAndCategory(){
        $requestBuilder = new ProvisioningRequestBuilder($this->provisioning->getAuthCredentialData());
        try {
            return $requestBuilder->customRequest(self::TEMPLATE_TYPE_AND_CATEGORY_API, ProvisioningApiSchemeHelper::GET);
        } catch (ProvisioningApiException $e) {
            throw new ProvisioningApiException($e->getMessage());
        }
    }

    public function categoriesByType($type){
        $requestBuilder = new ProvisioningRequestBuilder($this->provisioning->getAuthCredentialData());
        try {
            return $requestBuilder->customRequest(self::TEMPLATE_CATEGORY_BY_TYPE_API, ProvisioningApiSchemeHelper::GET, [
                "template_type" => $type
            ]);
        } catch (ProvisioningApiException $e) {
            throw new ProvisioningApiException($e->getMessage());
        }
    }
}
