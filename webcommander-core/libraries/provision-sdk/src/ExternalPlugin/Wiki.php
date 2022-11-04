<?php
namespace Webmascot\ExternalPlugin;

use Webmascot\ApiHelper\ProvisioningApiSchemeHelper;
use Webmascot\ApiHelper\ProvisioningRequestBuilder;
use Webmascot\AppService\ProvisioningApiException;
use Webmascot\AppService\ProvisioningUtil;

class Wiki
{
    private $externalPlugin;
    private $instanceIdentifier;
    const SEARCH_API = "/w_c_wiki/api/v1/read/search-info/search";
    const SUGGESTION_API = "/w_c_wiki/api/v1/read/search-info/suggestion";

    public function __construct(ExternalPlugin $externalPlugin)
    {
        $this->externalPlugin = $externalPlugin;
        $this->instanceIdentifier = $this->externalPlugin->getAuthCredentialData()->getInstanceIdentifier();
    }

    public function search($search){
        $requestBuilder = new ProvisioningRequestBuilder($this->externalPlugin->getAuthCredentialData());
        try {
            return $requestBuilder->customRequest(ProvisioningUtil::concatURL(self::SEARCH_API,"?uuid=".$this->instanceIdentifier), ProvisioningApiSchemeHelper::POST, [
                "wildcard_search" => "%".$search."%"
            ]);
        } catch (ProvisioningApiException $e) {
            throw new ProvisioningApiException($e->getMessage());
        }
    }


    public function suggestion($search){
        $requestBuilder = new ProvisioningRequestBuilder($this->externalPlugin->getAuthCredentialData());
        try {
            return $requestBuilder->customRequest(ProvisioningUtil::concatURL(self::SUGGESTION_API,"?uuid=".$this->instanceIdentifier), ProvisioningApiSchemeHelper::POST, [
                "wildcard_search" => "%".$search."%"
            ]);
        } catch (ProvisioningApiException $e) {
            throw new ProvisioningApiException($e->getMessage());
        }
    }

}
