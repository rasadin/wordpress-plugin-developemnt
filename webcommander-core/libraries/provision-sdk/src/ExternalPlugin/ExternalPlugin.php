<?php
namespace Webmascot\ExternalPlugin;

use Webmascot\ApiHelper\Communicator\Data\ProvisioningAuthCredentialData;

class ExternalPlugin
{
    private $authCredentialData;

    public function __construct(ProvisioningAuthCredentialData $authCredentialData)
    {
        $this->authCredentialData = $authCredentialData;
    }

    public function getAuthCredentialData()
    {
        return $this->authCredentialData;
    }

    public function wiki(){
        return new Wiki($this);
    }
}
