;(function($) {
    "use strict";
    /**
    * Settings Tab
    * @author Rabiul
    * @since 1.0.0
    */
    var settings_tab = function() {
        $( '.wcc-tabs li a' ).on( 'click', function(e) {
            e.preventDefault();
            $( '.wcc-tabs li a' ).removeClass( 'active' );
            $(this).addClass('active');
            var tab = $(this).attr( 'href' );
            $( '.wcc-settings-tab' ).removeClass( 'active' );
            $( '.wcc-settings-tabs' ).find( tab ).addClass( 'active' );
        });
    }
    settings_tab();

    /**
    * Saving General Tab Data
    * @author Rabiul
    * @since 1.0.0
    */
    var generalTabData = function() {
        var generalTabForm = '#general-form-settings';

        $(document.body).on('submit', generalTabForm, function(e) {
            e.preventDefault();

            $.ajax({
                url: adminLocalizer.ajaxUrl,
                type: 'post',
                data: {
                    action: 'general_tab_settings', // [N.B ] admin/Modules/Settings/Settings.php,
                    fields: $(generalTabForm).serialize(),
                    nonce: adminLocalizer.nonce
                },
                success: function(res) {
                    var data  = JSON.parse(res);
                    console.log(data);
                    if( 'saved' == data ) {
                        // $('.wcc-settings-tabs').insertAfter('<p class="notice-success">Settings saved!</p>');
                        alert('Data Saved!');
                    }
                }
            });
        })
    }
    generalTabData();
})(jQuery)