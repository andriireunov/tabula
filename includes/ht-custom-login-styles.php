<?php

add_action( 'login_enqueue_scripts', 'ht_login_logo' );
add_filter( 'login_headerurl', 'ht_login_logo_url' );
add_filter( 'login_headertext', 'ht_login_logo_url_title' );

function ht_login_logo() { ?>
        <?php print_r(get_custom_logo()) ?>
	<style type="text/css">
        #login h1 a, .login h1 a {
            <?php if (has_custom_logo()): ?>
            background-image: url(<?php echo get_custom_logo(); ?>);
            height:108px;
            width:240px;
            background-size: 240px 108px;
            background-repeat: no-repeat;
            <?php endif; ?>
        }

        #login .button-primary {
            /*background: transparent;*/
            /*color: #647B4B;*/
            /*border-color: #647B4B;*/
            /*border-radius: 5px;*/
            /*font-weight: 700;*/
        }

        #login #loginform {
            /*border-radius: 10px;*/
        }

        #login #nav a.wp-login-lost-password,
        #login #nav a.wp-login-lost-password:hover,
        #login #nav a#backtoblog,
        #login #nav a#backtoblog:hover {
            /*color: #647B4B;*/
        }

        .wp-core-ui .button, .wp-core-ui .button-secondary {
            /*color: #647B4B !important;*/
        }

        .wp-core-ui .button-primary:focus,
        .login .button.wp-hide-pw:focus,
        input[type=checkbox]:focus,
        input[type=text]:focus,
        .js.login input.password-input:focus {
            /*border-color: #647B4B !important;*/
            /*box-shadow: 0 0 0 1px #647B4B !important;*/
        }

        body.login {
            /*background-color: #F8F5EE;*/
        }
	</style>
<?php }

function ht_login_logo_url() {
	return home_url();
}

function ht_login_logo_url_title() {
	return get_bloginfo('name');
}
