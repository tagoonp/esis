// Initialize when page loads
jQuery( function() {
	BaseFormValidation.init();
});

var BaseFormValidation = function() {
    // Init Bootstrap Forms Validation: https://github.com/jzaefferer/jquery-validation
    var initValidation = function() {
        jQuery( '.js-validation-bootstrap' ).validate({
            errorClass: 'help-block animated fadeInDown',
            errorElement: 'div',
            errorPlacement: function( error, e ) {
                jQuery(e).parents( '.form-group > div' ).append( error );
            },
            highlight: function(e) {
                jQuery(e).closest( '.form-group' ).removeClass( 'has-error' ).addClass( 'has-error' );
                jQuery(e).closest( '.help-block' ).remove();
            },
            success: function(e) {
                jQuery(e).closest( '.form-group' ).removeClass( 'has-error' );
                jQuery(e).closest( '.help-block' ).remove();
            },
            rules: {
                'login1-username': {
                  required: true
                },
                'login1-password': {
                  required: true
                }
            },
            messages: {
                'login1-username': {
                  required: 'กรุณากรอกชื่อบัญชีผู้ใช้!'
                },
                'login1-password': {
                  required: 'กรุณากรอกรหัสผ่าน!'
                }
            }
        });
    };


    return {
        init: function () {
            initValidation();
        }
    };
}();
