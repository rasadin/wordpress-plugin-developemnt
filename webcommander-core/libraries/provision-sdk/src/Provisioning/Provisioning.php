<?php
namespace Webmascot\Provisioning;

use Webmascot\ApiHelper\Communicator\Data\ProvisioningAuthCredentialData;

class Provisioning
{
    private $authCredentialData;

    public function getAuthCredentialData()
    {
        return $this->authCredentialData;
    }

    public function __construct(ProvisioningAuthCredentialData $authCredentialData)
    {
        $this->authCredentialData = $authCredentialData;
    }

    public function template(){
        return new Template($this);
    }

    public function package(){
        return new Package($this);
    }

    public function account(){
        return new Account($this);
    }

    public function ticketing(){
        return new Ticketing($this);
    }

    public function price(){
        return new Price($this);
    }
}
