<?php

/*
Plugin Name: Instant Custom Fields
Description: Allows instant embedding of custom fields in Post & Page Content. Useful for javascript tags (Video Embeds) that get stripped from Post Content.
Plugin URI: http://complex.com
Author: Anthony L. Rivera
Author URI: http://complexmediainc.com
Version: 1.0
License: GPL2
*/

/*

    Copyright (C) 2015  Anthony L. Rivera   anthonylrivera@gmail.com

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( ! array_key_exists( 'instant-custom-fields', $GLOBALS ) ) {
if ( !class_exists( 'Instant_Custom_Fields' ) ) {

  class Instant_Custom_Fields {

    public function __construct(){
      add_filter( 'the_content', array( $this, 'filter_instant_shortcodes'), 1, 1 );
    }
   
    public function filter_instant_shortcodes( $content ) {
      
      global $post;
      
      preg_match_all('/{{*?[a-zA-Z0-9-_]*}}/', $content, $cfs ); 

      if ( isset($cfs) && is_array($cfs) ) {
        
        foreach ( $cfs[0] as $icf_tag ) {
          $icf_name = substr($icf_tag, 2, -2);
      
          $custom_field_value = get_post_meta( $post->ID, $icf_name, true );
          
          if( ! empty( $custom_field_value ) ) {
            $content = str_replace( $icf_tag, $custom_field_value, $content );
          } 
        }
      
      }

      return $content;
    }

  }

  $GLOBALS['instant-custom-fields'] = new Instant_Custom_Fields();

}
}
