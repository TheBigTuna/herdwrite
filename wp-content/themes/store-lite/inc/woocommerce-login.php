<?php

// THIS WILL CREATE store_lite_separate_registration_form action.
  
add_action( 'store_lite_register_form_woocommerce_action', 'store_lite_separate_registration_form' );
    
function store_lite_separate_registration_form() {
if ( is_admin() ) return;

if ( is_user_logged_in() ) {
   wc_add_notice( sprintf( __( 'You are currently logged in. If you wish to register with a different account please <a href="%s">log out</a> first', 'store-lite' ), wc_logout_url() ) );
   wc_print_notices();
} else {
     
   // NOTE: THE FOLLOWING <FORM> IS COPIED FROM woocommerce\templates\myaccount\form-login.php
   // IF WOOCOMMERCE RELEASES AN UPDATE TO THAT TEMPLATE, YOU MUST CHANGE THIS ACCORDINGLY
   ?>
        
    <form method="post" class="woocommerce-form woocommerce-form-register register" action="#registra" <?php do_action( 'woocommerce_register_form_tag' ); ?> >
  
         <?php do_action( 'woocommerce_register_form_start' ); ?>
  
         <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
  
            <label for="reg_username"><?php esc_html_e( 'Username', 'store-lite' ); ?> <span class="required">*</span></label>
            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
  
         <?php endif; ?>
  
            <label for="reg_email"><?php esc_html_e( 'Email address', 'store-lite' ); ?> <span class="required">*</span></label>
            <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
  
         <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
  
            <label for="reg_password"><?php esc_html_e( 'Password', 'store-lite' ); ?> <span class="required">*</span></label>
            <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" />
  
         <?php endif; ?>
  
         <?php do_action( 'woocommerce_register_form' ); ?>
  
            <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
            <button type="submit" class="woocommerce-Button button" name="register" value="<?php esc_attr_e( 'Register', 'store-lite' ); ?>"><?php esc_html_e( 'Register', 'store-lite' ); ?></button>
  
         <?php do_action( 'woocommerce_register_form_end' ); ?>
  
      </form>
  
   <?php
   // END OF COPIED HTML
   // ------------------
     
}

}

// THIS WILL CREATE store_lite_login_form_woocommerce_action action.
  
add_action( 'store_lite_login_form_woocommerce_action', 'store_lite_separate_login_form' );
  
function store_lite_separate_login_form() {
    if ( is_admin() ) return;

     if ( !is_user_logged_in() ){
         
       // NOTE: THE FOLLOWING <FORM> IS COPIED FROM woocommerce\templates\myaccount\form-login.php
       // IF WOOCOMMERCE RELEASES AN UPDATE TO THAT TEMPLATE, YOU MUST CHANGE THIS ACCORDINGLY
       ?>
        
        <form class="woocommerce-form woocommerce-form-login login" method="post">
      
             <?php do_action( 'woocommerce_login_form_start' ); ?>
      
                <label for="username"><?php esc_html_e( 'Username or email address', 'store-lite' ); ?> <span class="required">*</span></label>
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" />
      
                <label for="password"><?php esc_html_e( 'Password', 'store-lite' ); ?> <span class="required">*</span></label>
                <input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" />
      
             <?php do_action( 'woocommerce_login_form' ); ?>
      
                <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                <button type="submit" class="woocommerce-Button button" name="login" value="<?php esc_attr_e( 'Log in', 'store-lite' ); ?>"><?php esc_html_e( 'Log in', 'store-lite' ); ?></button>
                <label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline">
                   <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', 'store-lite' ); ?></span>
                </label>
      
                <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'store-lite' ); ?></a>
               
             <?php do_action( 'woocommerce_login_form_end' ); ?>
      
          </form>
      
       <?php
       // END OF COPIED HTML
       // ------------------
         
    }

}