<?php 
/**
 * Popup Mailchimp
 */

add_action( 'webalive_before_footer', 'popup_mailchimp' );
function popup_mailchimp() {
    ?>
    <!-- The Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Need more sleep?</h4>

                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="">
                        <p>Sign up to receive a free audio guide on how to get your best night's sleep - the science backed way.</p>
                        <link href="https://cdn-images.mailchimp.com/embedcode/slim-081711.css" rel="stylesheet" type="text/css">

                        <!-- Email Signup HTML -->
                        <div class="mc_embed_signup">
                            <form action="//themodlife.us19.list-manage.com/subscribe/post-json?u=fe01469d4f5d878a1a7493ed5&id=7c86dadb15&c=?" method="post" name="mc-embedded-subscribe-form" class="validate mc-embedded-subscribe-form newsletter__form" novalidate="">

                                <input type="text" value="" name="FNAME" class="" placeholder="First Name" id="mce-FNAME">
                                <input type="email" value="" name="EMAIL" placeholder="Email*" class="required email" id="mce-EMAIL">
                                <input type="submit" value="ModLife Me" name="submit" id="mc-embedded-subscribe" class="button">
                                <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" placeholder="Email*" name="b_bfaeb9f9cfe94bf88ebe82105_58d7ecad1c" tabindex="-1" value=""></div>
                            </form>
                            <div class="mce-responses">
                                <div class="response mce-error-response" style="display:none"></div>
                                <div class="response mce-success-response" style="display:none"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script>
    jQuery(document).ready(function($) {
        setTimeout(() => {
            var mailchimpCookie = Cookies.get('tmlc_mailchimp_cookie');
            console.log(mailchimpCookie);
            if( typeof mailchimpCookie == 'undefined' ) {
                $("#myModal").modal();
                $('#myModal').on('hidden.bs.modal', function() {
                    isClosed = true;
                    Cookies.set('tmlc_mailchimp_cookie', 1, { expires: 1 });
                })
            }
        }, 40000);
    });
    </script>
    <?php
}