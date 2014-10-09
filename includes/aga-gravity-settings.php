<?php

// Option to output label as placeholder
add_filter( 'gform_form_settings', 'aga_gform_add_label_option' , 1 , 2 ) ;
function aga_gform_add_label_option( $settings, $form ) {
  $form_label_placement = isset( $settings[ 'Form Layout' ][ 'form_label_placement' ] ) ? $settings[ 'Form Layout' ][ 'form_label_placement' ] : "";
  if ( $form_label_placement ) {
    $settings = aga_add_label_placement_to_settings( $form_label_placement ,  $settings , $form ) ;
  }  
  return $settings ;
}

function aga_add_label_placement_to_settings( $form_label_placement , $settings , $form ) {
  $new_option = aga_get_option_for_in_placeholder( $form ) ;
  $new_form_label_settings = aga_get_new_form_label_settings( $new_option , $form_label_placement ) ;
  $settings = add_new_form_label_settings_to_settings( $settings , $new_form_label_settings ) ;
  return $settings ; 
}

function aga_get_option_for_in_placeholder( $form ) {
  $option_name = 'in_placeholder' ; 
  $selected_attribute = aga_get_placeholder_selected_attribute( $form ) ;      
  $new_option = "<option value='$option_name' '{$selected_attribute}'>" . __( 'In placeholder' , 'adapter-gravity-add-on' ) . "</option>" ;
  return $new_option ; 
}

function aga_get_new_form_label_settings( $new_option , $form_label_placement ) {
  $closing_select_tag = '</select>' ;  
  $new_option_with_closing_select_tag = $new_option . ' ' . $closing_select_tag ;
  $new_settings = str_replace( $closing_select_tag , $new_option_with_closing_select_tag , $form_label_placement ) ;
  return $new_settings ;
}

function add_new_form_label_settings_to_settings( $settings , $new_form_label_settings ) { 
  $settings[ 'Form Layout' ][ 'form_label_placement' ] = $new_form_label_settings ;
  return $settings ; 
}

function aga_get_placeholder_selected_attribute( $form )  {
  $is_selected = ( ( isset( $form[ 'labelPlacement' ] ) ) && ( 'in_placeholder' == $form[ 'labelPlacement' ] ) ) ; 
  $selected_attribute = selected( $is_selected , 1 , false ) ;
  return $selected_attribute ;
}


// Option to echo form at bottom of post and to display it inline
add_filter( 'gform_form_settings', 'aga_gform_add_settings', 10, 2);
function aga_gform_add_settings( $settings, $form ) {
  $settings_with_bottom_of_post_option = AGA_Bottom_Of_Post_Setting::get_settings( $settings , $form ) ;
  $settings_with_inline_and_bottom_of_post_options = AGA_Horizontal_Form_Setting::get_settings( $settings_with_bottom_of_post_option , $form ) ;  
  return $settings_with_inline_and_bottom_of_post_options ;
}

add_filter( 'gform_pre_form_settings_save' , 'save_aga_settings' ) ; 
function save_aga_settings( $form ) {
  $form[ 'aga_bottom_of_post' ] = rgpost( 'aga_bottom_of_post' ) ;
  $form[ 'aga_horizontal_display' ] = rgpost( 'aga_horizontal_display' ) ;  
  return $form;
}

function aga_get_gform_checked_attribute( $setting_name , $form ) {
  $is_checked = rgar( $form , $setting_name ) ;
  $checked_attribute = checked( $is_checked , '1' , false ) ;
  return $checked_attribute ; 
}