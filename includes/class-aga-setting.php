<?php

class AGA_Setting {

  protected static $instance ;
  protected $settings ;
  protected $form ; 
  protected $setting_name ;
  protected $setting_description ;

  private function __construct( $settings , $form ) {
    $this->settings = $settings ;
    $this->form = $form ;
  }

  public static function instantiate( $settings , $form ) {
    self::$instance = new self( $settings , $form ) ; 
  } 
 
  public static function set_variables( $setting_variables ) {
    self::$instance->setting_name = isset( $setting_variables[ 'setting_name' ] ) ? $setting_variables[ 'setting_name' ] : "" ;
    self::$instance->setting_description = isset( $setting_variables[ 'setting_description' ] ) ? $setting_variables[ 'setting_description' ] : "" ;    
  }    

  public function settings_with_new_markup() {
    $checked_attribute = aga_get_gform_checked_attribute( $this->setting_name , $this->form ) ; 
    $this->settings[ 'Form Layout' ][ $this->setting_name ] = "
      <tr>
	<th><label for='{$this->setting_name}'>" . $this->setting_description  . "</label></th>
	<td><input type='checkbox' value='1' {$checked_attribute} name='{$this->setting_name}'></td>
      </tr>\n";
    return $this->settings ;
  }    

}  /* end class AGA_Setting */


class AGA_Bottom_Of_Post_Setting extends AGA_Setting {

  public static function get_settings( $settings , $form ) {
    parent::instantiate( $settings , $form ) ;
    parent::set_variables( array( 'setting_name' => 'aga_bottom_of_post' ,
    				   'setting_description' => __( 'Display at the bottom of every single-post page' , 'adapter-gravity-add-on' )
	                  ) ) ;     
    return parent::$instance->settings_with_new_markup() ;
  }
}

class AGA_Horizontal_Form_Setting extends AGA_Setting {

  public static function get_settings( $settings , $form ) {
    parent::instantiate( $settings , $form ) ;
    parent::set_variables( array( 'setting_name' => 'aga_horizontal_display' ,
    				  'setting_description' => __( 'Display form horizontally' , 'adapter-gravity-add-on' )
		         ) ) ; 
    return parent::$instance->settings_with_new_markup() ;
  }
}