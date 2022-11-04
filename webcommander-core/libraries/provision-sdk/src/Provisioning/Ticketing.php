<?php
namespace Webmascot\Provisioning;

use Webmascot\AppService\ProvisioningApiException;

class Ticketing
{
    private $provisioning;

    public function __construct(Provisioning $provisioning)
    {
        $this->provisioning = $provisioning;
    }

    public function loginWithTicketsByEmailAndPassword($email, $password){
        try {
            $account = new Account($this->provisioning);
            $loginResponse = $account->loginByEmailAndPassword($email, $password);
            if($loginResponse['isSuccess'] && isset($loginResponse['responseData'])){
                if(isset($loginResponse['responseData']['default_card'])){
                    unset($loginResponse['responseData']['default_card']);
                }
                $loginResponse['responseData']['tickets'] = [
                    [
                      "title" => "Ticket 1",
                      "description" => "This is ticket description",
                      "status" => "PENDING",
                      "status_date" => "2020-02-18",
                      "issue_date" => "2020-02-17"
                    ],
                    [
                        "title" => "Ticket 2",
                        "description" => "This is ticket description",
                        "status" => "PENDING",
                        "status_date" => "2020-02-18",
                        "issue_date" => "2020-02-17"
                    ],
                    [
                      "title" => "Ticket 3",
                      "description" => "This is ticket description",
                      "status" => "PENDING",
                      "status_date" => "2020-02-18",
                      "issue_date" => "2020-02-17"
                    ],
                    [
                        "title" => "Ticket 4",
                        "description" => "This is ticket description",
                        "status" => "PENDING",
                        "status_date" => "2020-02-18",
                        "issue_date" => "2020-02-17"
                    ],
                    [
                      "title" => "Ticket 5",
                      "description" => "This is ticket description",
                      "status" => "PENDING",
                      "status_date" => "2020-02-18",
                      "issue_date" => "2020-02-17"
                    ],
                    [
                        "title" => "Ticket 6",
                        "description" => "This is ticket description",
                        "status" => "PENDING",
                        "status_date" => "2020-02-18",
                        "issue_date" => "2020-02-17"
                    ]
                ];
            }
            return $loginResponse;
        } catch (ProvisioningApiException $e) {
            throw new ProvisioningApiException($e->getMessage());
        }
    }

    public function newInquiry($name, $email, $subject, $message){
        try {
            return [
                "isSuccess" => true,
                "statusCode" => 1200,
                "message" => "Inquiry submitted successfully"
            ];
        } catch (ProvisioningApiException $e) {
            throw new ProvisioningApiException($e->getMessage());
        }
    }
}
