<?php
/*
Plugin Name: Devis.wedo.lu Helper plugin
Description: Better than a child theme
Version: 1.0
Author: Vagelis P.
*/
function v_check_roles() {
    $user = wp_get_current_user();
    $role = ( array ) $user->roles;
    if (!empty($role)):
      print_r($role);
    endif;  
 }
 //add_action('wp_footer','v_check_roles', 100);