<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://walnutztudio.com
 * @since      1.0.0
 *
 * @package    Woo_Billingister
 * @subpackage Woo_Billingister/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Woo_Billingister
 * @subpackage Woo_Billingister/public
 * @author     WalnutZtudio <walnutztudio@gmail.com>
 */
class Woo_Billingister_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Billingister_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Billingister_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woo-billingister-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Billingister_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Billingister_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woo-billingister-public.js', array( 'jquery' ), $this->version, false );

	}

}

/**
 * Add billing fields to register form for WooCommerce.
 */

// Function to check starting char of a string
function startsWith($haystack, $needle){
    return $needle === '' || strpos($haystack, $needle) === 0;
}


// Custom function to display the Billing Address form to registration page
function wz_add_billing_form_to_registration(){
    global $woocommerce;
    $checkout = $woocommerce->checkout();
    ?>
    <?php foreach ( $checkout->get_checkout_fields( 'billing' ) as $key => $field ) : ?>

        <?php if($key!='billing_email'){ 
            woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
        } ?>

    <?php endforeach; 
}
add_action('woocommerce_register_form_start','wz_add_billing_form_to_registration');

// Custom function to save Usermeta or Billing Address of registered user
function wz_save_billing_address($user_id){
    global $woocommerce;
    $address = $_POST;
    foreach ($address as $key => $field){
        if(startsWith($key,'billing_')){
            // Condition to add firstname and last name to user meta table
            if($key == 'billing_first_name' || $key == 'billing_last_name'){
                $new_key = explode('billing_',$key);
                update_user_meta( $user_id, $new_key[1], $_POST[$key] );
            }
            update_user_meta( $user_id, $key, $_POST[$key] );
        }
    }

}
add_action('woocommerce_created_customer','wz_save_billing_address');


// Registration page billing address form Validation
function wz_validation_billing_address(){
    global $woocommerce;
    $address = $_POST;
    foreach ($address as $key => $field) :
        // Validation: Required fields
        if(startsWith($key,'billing_')){
            if($key == 'billing_country' && $field == ''){
                $woocommerce->add_error( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Please select a country.', 'woocommerce' ) );
            }
            if($key == 'billing_first_name' && $field == ''){
                $woocommerce->add_error( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Please enter first name.', 'woocommerce' ) );
            }
            if($key == 'billing_last_name' && $field == ''){
                $woocommerce->add_error( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Please enter last name.', 'woocommerce' ) );
            }
            if($key == 'billing_address_1' && $field == ''){
                $woocommerce->add_error( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Please enter address.', 'woocommerce' ) );
            }
            if($key == 'billing_city' && $field == ''){
                $woocommerce->add_error( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Please enter city.', 'woocommerce' ) );
            }
            if($key == 'billing_state' && $field == ''){
                $woocommerce->add_error( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Please enter state.', 'woocommerce' ) );
            }
            if($key == 'billing_postcode' && $field == ''){
                $woocommerce->add_error( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Please enter a postcode.', 'woocommerce' ) );
            }
            /*
            if($key == 'billing_email' && $field == ''){
                $woocommerce->add_error( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Please enter billing email address.', 'woocommerce' ) );
            }
            */
            if($key == 'billing_phone' && $field == ''){
                $woocommerce->add_error( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Please enter phone number.', 'woocommerce' ) );
            }

        }
    endforeach;
}
add_action('register_post','wz_validation_billing_address');