<?php 

/*
Plugin Name: MultiSite New User, No Confirmation
Plugin URI: https://wordpress.org/plugins/multisite-new-user-no-confirmation/
Description: Mimic the super-admin "Skip Confirmation Email" checkbox for regular users.
Author: Brian Santalone
Version: 1.0.1
Author URI: http://santalone.com/wordpress-plugins/
*/


function wnet_custom_user_profile_fields($user){
	if (!is_super_admin( $user_id )) {
?>
    <table class="form-table">
		<tr>
		<th scope="row"><?php _e('Skip Confirmation Email') ?></th>
		<td><input type="checkbox" name="skipconfirmation" value="1" <?php checked( $_POST['skipconfirmation'], 1 ); ?> /> Add the user without sending an email that requires their confirmation.</td>
	</tr>
    </table>
	
	
<?php
	}
}

add_action( "user_new_form", "wnet_custom_user_profile_fields" );

add_filter('wpmu_signup_user_notification', 'wnet_auto_activate_users', 10, 4);
function wnet_auto_activate_users($user, $user_email, $key, $meta){

	if(!current_user_can('manage_options'))
        return false;

	if (!empty($_POST['skipconfirmation']) && $_POST['skipconfirmation'] == 1) {
		wpmu_activate_signup($key);
		  return false;
	} 
}


/* end of file */