<?php

/*
 Plugin Name: WC Custom per product text for archive page
 Plugin URI: https://profiles.wordpress.org/rynald0s
 Description: This plugin adds a text field to the product data in which you can specify custom text on a per-product level, and show that on the archive/shop page
 Author: Rynaldo Stoltz
 Author URI: https://github.com/rynaldos
 Version: 1.0
 License: GPLv3 or later License
 URI: http://www.gnu.org/licenses/gpl-3.0.html
 */
 
 if ( ! defined( 'ABSPATH' ) ) {
 exit;
}

/**
 * create field for custom text in product data
 */

function rs_product_custom_field() {
 $args = array(
 'id' => 'custom_text_field',
 'label' => __( 'Custom text', 'woocommerce' ),
 'class' => 'rs-custom-field',
 'desc_tip' => true,
 'description' => __( 'Enter the title of your custom text field.', 'woocommerce' ),
 );
 woocommerce_wp_text_input( $args );
}
add_action( 'woocommerce_product_options_general_product_data', 'rs_product_custom_field' );

/**
 * Save the custom field input
 */

function rs_save_custom_field( $post_id ) {
 $product = wc_get_product( $post_id );
 $title = isset( $_POST['custom_text_field'] ) ? $_POST['custom_text_field'] : '';
 $product->update_meta_data( 'custom_text_field', sanitize_text_field( $title ) );
 $product->save();
}
add_action( 'woocommerce_process_product_meta', 'rs_save_custom_field' );

/**
* Show custom field input on archive
*/

add_action( 'woocommerce_after_shop_loop_item', 'rs_show_free_shipping_loop', 5 );
function rs_show_free_shipping_loop() {
     global $post;
     $product = wc_get_product( $post->ID );
     $title = $product->get_meta( 'custom_text_field' );
 if( $title ) {
 // Only display our field if we've got a value for the field title
 printf(
 '<div class="rs-custom-field-wrapper"><label for="rs-title-field">%s</label></div>',
 esc_html( $title )
 );
     }
}