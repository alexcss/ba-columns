<?php
/*
Plugin Name: BA Columns
Description: Use columns in content
Version: 1.0
Author: AlexCSS
Author: http://alexcss.com
*/

define( 'BAC_URL', plugins_url( '', __FILE__ ) );

function ba_col_styles(){
    wp_enqueue_style('ba-col',  BAC_URL . '/css/ba-col.css');
}

add_action('wp_enqueue_scripts', 'ba_col_styles');

function content_helper( $content, $paragraph_tag = false, $br_tag = false ) {
    $content = preg_replace( '#^<\/p>|^<br \/>|<p>$#', '', $content );

    if ( $br_tag ) {
        $content = preg_replace( '#<br \/>#', '', $content );
    }

    if ( $paragraph_tag ) {
        $content = preg_replace( '#<p>|</p>#', '', $content );
    }

    return do_shortcode( shortcode_unautop( trim( $content ) ) );
}

function ba_col_shortcodes_init(){

    $cols = array(
        'col_1_3',
        'col_1_3_end',
        'col_1_2',
        'col_1_2_end',
        'col_1_4',
        'col_1_4_end',
        'col_1_5',
        'col_1_5_end'
        );

    foreach ($cols as $col) {
        add_shortcode( 'ba_' . $col, 'ba_cols' );
    }

    function ba_cols( $atts, $content = null, $name = '' ) {
        // last class
        $pos = strpos( $name, '_end' );

        if ( false !== $pos ) {
            $name = str_replace( '_end', '', $name );
        }

        $name = str_replace('_', '-', $name);

        $content = content_helper($content);

        $output = '<div class="' . $name . '">' . $content . '</div>';

        if ( false !== $pos ) {
            $output .= "<div class='ba-clear'></div>";
        }

        return $output;
    }

}

add_action('init', 'ba_col_shortcodes_init');


// Filter Functions with Hooks
function ba_col_mce_button() {
  // Check if user have permission
    if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
        return;
    }
  // Check if WYSIWYG is enabled
    if ( 'true' == get_user_option( 'rich_editing' ) ) {
        add_filter( 'mce_external_plugins', 'ba_col_tinymce_plugin' );
        add_filter( 'mce_buttons', 'ba_col_register_mce_button' );
    }
}
add_action('admin_head', 'ba_col_mce_button');

// Function for new button
function ba_col_tinymce_plugin( $plugin_array ) {

    $plugin_array['ba_col_mce_button'] = BAC_URL .'/js/ba-col-button.js';
    return $plugin_array;
}

// Register new button in the editor
function ba_col_register_mce_button( $buttons ) {
  array_push( $buttons, 'ba_col_mce_button' );
  return $buttons;
}
