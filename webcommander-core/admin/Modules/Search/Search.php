<?php 
namespace WCC\Admin\Modules;
use Webmascot\ApiHelper\Communicator\Data\ProvisioningAuthCredentialData;
use Webmascot\ExternalPlugin\ExternalPlugin;
use Webmascot\Provisioning\Provisioning;

class Search {

    /**
     * Construct Function
     */
    public function __construct() {
        add_action( 'wp_ajax_generate_suggestions', [ $this, 'generate_suggestions' ] );
        add_action( 'wp_ajax_nopriv_generate_suggestions', [ $this, 'generate_suggestions' ] );

        // $this->generate_suggestions();
    }

    /**
     * Search Library Init
     * @author Rabiul
     * @since 1.0.0
     */
    public function serach_init() {
        $authCredential = new ProvisioningAuthCredentialData([
            'clientId'      => "25fec77bebbf420c9b0393388980f368",
            'clientSecret'  => "b9294b722dec49b3a5c08efb4f9a32d4",
            'accessToken'   => "f90e7db82d794e25824bb5a5bcd35671",
            'refreshToken'  => "f5be65e725f34571b32163f09c8d438d",
            'code'          => "2f5a82cc464c453e8d5f86226e4a7f1a",
            'url'           => "http://ex-plugin.webcommander.com/",
            'authTokenRenewCallback' => function(ProvisioningAuthCredentialData $authCredentialData){
                $data = array(
                    'client_id'     => $authCredentialData->getClientId(),
                    'client_secret' => $authCredentialData->getClientSecret(),
                    'access_token'  => $authCredentialData->getAccessToken(),
                    'refresh_token' => $authCredentialData->getRefreshToken(),
                    'code'          => $authCredentialData->getCode(),
                    'url'           => $authCredentialData->getUrl(),
                );

                // $this->update_provision_data($data);
            },
            'instanceIdentifier' => "7A34-FAAB-EA56-CAD9"
        ]);

        return $externalPlugin = new ExternalPlugin( $authCredential );
    }

    /**
     * Get Provision Data
     * @author Rabiul
     * @since 1.0.0
     */
    public function get_provision_data() {
        global $wpdb;
        $table = $wpdb->prefix.'provision';
        $sql = "SELECT * FROM $table";
        $results = $wpdb->get_results($sql);
        
        $return_data = [];
        foreach( $results as $result ) {
            $return_data = array(
                'client_id'     => $result->client_id,
                'client_secret' => $result->client_secret,
                'access_token'  => $result->access_token,
                'refresh_token' => $result->refresh_token,
                'code'          => $result->code,
                'url'           => $result->url,
            );
        }
    
        return (object) $return_data;
    }

    /**
     * Generate Suggestion By Keyword
     * @author Rabiul
     * @since 1.0.0
     */
    public function generate_suggestions() {
        // \check_ajax_referer( WCC_NONCE, 'nonce' );


        if( isset( $_POST[ 'keyword' ] ) && ! empty( $_POST[ 'keyword' ] ) ) {
            $keyword = sanitize_text_field( $_POST[ 'keyword' ] );
            $suggestion = $this->serach_init()->wiki()->suggestion( $keyword );
        }else {
            $suggestion = false;
        }

        echo wp_json_encode( $suggestion );
        wp_die();
    }
    
}