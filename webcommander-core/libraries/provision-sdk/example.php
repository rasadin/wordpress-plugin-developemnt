<?php


require __DIR__ . './vendor/autoload.php';

use Webmascot\ApiHelper\Communicator\Data\ProvisioningAuthCredentialData;
use Webmascot\ExternalPlugin\ExternalPlugin;
use Webmascot\Provisioning\Provisioning;

//composer dump-autoload

$authCredential = new ProvisioningAuthCredentialData([
    'clientId' => "25fec77bebbf420c9b0393388980f368",
    'clientSecret' => "b9294b722dec49b3a5c08efb4f9a32d4",
    'accessToken' => "d901d2903be24565a06350914eded7ab",
    'refreshToken' => "04df4f7f9b4a4896b2ff33a715f930f2",
    'code' => "2f5a82cc464c453e8d5f86226e4a7f1a",
    'url' => "http://dev-wc-pps1.webmascot.net/",
    'authTokenRenewCallback' => function(ProvisioningAuthCredentialData $authCredentialData){
        file_put_contents("token.json", json_encode((array) $authCredentialData));
    },
    'instanceIdentifier' => "7852-18A2-85D2-144A"
]);
$provisioning = new Provisioning($authCredential);
//        print_r($provisioning->template()->categoriesByType("general"));
//        print_r($provisioning->price()->getAmountWithTax("DFE3FC43-C942-443F-85B4-07FD5F832F36", "AU"));
//        print_r(json_encode($provisioning->template()->details("255577FE-D2FF-4D73-A7F0-092307ED49CB")));
        print_r($provisioning->template()->listAll(100,0,"", "ecommerce"));
//        print_r(json_encode($provisioning->template()->typesAndCategory()));
//        print_r($provisioning->package()->listAll());
//        print_r(json_encode($provisioning->package()->details("6FA56083-D9A7-433F-A99C-8DCFC9A9BF3F")));
//        print_r(json_encode($provisioning->account()->isEmailExists("masumul@bitmascot.com")));
//        print_r(json_encode($provisioning->account()->subscription()));
//        print_r($provisioning->account()->loginByEmailAndPassword("masumul@bitmascot.com", "12346"));
//        print_r($provisioning->account()->loginByEmailAndPassword('iman@bitmascot.com', '123456'));
//        print_r($provisioning->ticketing()->loginWithTicketsByEmailAndPassword("masumul@bitmascot.com", "123456"));
//        print_r($provisioning->ticketing()->newInquiry("Masum","masumul@bitmascot.com", "Ticket","Testing"));
//        print_r(json_encode($provisioning->account()->signUp([
//            "user_details" => [
//                "first_name" => "Masumul",
//                "last_name" => "Hassan",
//                "company" => "Bitmascot pvt ltd",
//                "email" => "abcded@bitmascot.com",
//                "password" => "123456",
//                "phone" => "",
//                "web" => "",
//                "street_address" => "ysdgafjksdf",
//                "country" => "AU",
//                "state" => "NSW",
//                "city" => "Victoria",
//                "zip" => "3000",
//                "is_email_verified" => true
//            ],
//            "invoice" => [
//                [
//                    "item_uuid" => "FA4CEDA2-6710-436B-8AEF-03879B3AB5C2",
//                    "item_type" => "PACKAGE",
//                    "tiered_uuid" => "FEBEDBFD-E6B0-4502-B4AE-3B9B652027C2"
//                ]
//            ],
//            "payment" => [
//                "card_number" => "4242424242424242",
//                "expires" => "1225",
//                "cvv" => "999"
//            ],
//            "is_user_registered" => false,
//            "website_type" => "CONTENT" / "E-COMMERCE"
//        ])));

$externalPlugin = new ExternalPlugin($authCredential);
//print_r($externalPlugin->wiki()->suggestion("test"));
