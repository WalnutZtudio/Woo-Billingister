<?php // Silence is golden

if(!is_admin())
{
// Function to check starting char of a string
function startsWith($haystack, $needle)
{
return $needle === '' || strpos($haystack, $needle) === 0;
}
// Custom function to display the Billing Address form to registration page
function my_custom_function()
{
global $woocommerce;
$checkout = $woocommerce->checkout();
?>
<h3><?php _e( 'Billing Address', 'woocommerce' ); ?></h3>
<?php
foreach ($checkout->checkout_fields['billing'] as $key => $field) :
woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
endforeach;
}
add_action('register_form','my_custom_function');

// Custom function to save Usermeta or Billing Address of registered user
function save_address($user_id)
{
global $woocommerce;
$address = $_POST;
foreach ($address as $key => $field) :
if(startsWith($key,'billing_'))
{
// Condition to add firstname and last name to user meta table
if($key == 'billing_first_name' || $key == 'billing_last_name')
{
$new_key = explode('billing_',$key);
update_user_meta( $user_id, $new_key[1], $_POST[$key] );
}
update_user_meta( $user_id, $key, $_POST[$key] );
}
endforeach;

}
add_action('woocommerce_created_customer','save_address');

// Registration page billing address form Validation
function custom_validation()
{
global $woocommerce;
$address = $_POST;
foreach ($address as $key => $field) :
// Validation: Required fields
if(startsWith($key,'billing_'))
{
if($key == 'billing_country' && $field == '')
{
$woocommerce->add_error( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Please select a country.', 'woocommerce' ) );
}
if($key == 'billing_first_name' && $field == '')
{
$woocommerce->add_error( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Please enter first name.', 'woocommerce' ) );
}
if($key == 'billing_last_name' && $field == '')
{
$woocommerce->add_error( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Please enter last name.', 'woocommerce' ) );
}
if($key == 'billing_address_1' && $field == '')
{
$woocommerce->add_error( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Please enter address.', 'woocommerce' ) );
}
if($key == 'billing_city' && $field == '')
{
$woocommerce->add_error( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Please enter city.', 'woocommerce' ) );
}
if($key == 'billing_state' && $field == '')
{
$woocommerce->add_error( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Please enter state.', 'woocommerce' ) );
}
if($key == 'billing_postcode' && $field == '')
{
$woocommerce->add_error( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Please enter a postcode.', 'woocommerce' ) );
}
if($key == 'billing_email' && $field == '')
{
$woocommerce->add_error( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Please enter billing email address.', 'woocommerce' ) );
}
if($key == 'billing_phone' && $field == '')
{
$woocommerce->add_error( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Please enter phone number.', 'woocommerce' ) );
}

}
endforeach;
}
add_action('register_post','custom_validation');
}