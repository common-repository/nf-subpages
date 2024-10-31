<?php if ( ! defined( 'ABSPATH' ) ) exit;
   /*
   Plugin Name: NF Subpages
   Plugin URI: http://macnetic-labs.de
   Description: A plugin to add subpages. Includes the option for custom classes.
   Text Domain: nf-subpages
   Domain Path: /lang/
   Version: 1.0
   Author: Jens Brunnert
   Author URI: http://macnetic-labs.de
   License: GPL2
   */


function nf_subpages_dependencies() {
	if ( !is_plugin_active( 'ninja-forms/ninja-forms.php' ) ) {
		add_action("admin_notices", function() {
			echo '<div class="error fade"><p>'. _e("Plugin 'NF Subpages' deactivated, because it requires the Ninja Forms plugin to be installed and active", "nf-subpages").'</p></div>';
		});
		deactivate_plugins( plugin_basename( __FILE__ ) );
		unset($_GET['activate']);
	}
}
add_action( 'admin_init', 'nf_subpages_dependencies' );

function nf_subpages_extend_setup_license() {
	if ( class_exists( 'NF_Extension_Updater' ) ) {
		new NF_Extension_Updater( 'NF Subpages', '1.0', 'Jens Brunnert', __FILE__, 'option_prefix' );
	}
}
add_action( 'admin_init', 'nf_subpages_extend_setup_license' );

function nf_subpages_load_lang() {
	$textdomain = 'nf-subpages';
	$locale = apply_filters( 'plugin_locale', get_locale(), $textdomain );

	load_textdomain( $textdomain, WP_LANG_DIR . '/nf-subpages/' . $textdomain . '-' . $locale . '.mo' );

	load_plugin_textdomain( $textdomain, FALSE, dirname(plugin_basename(__FILE__)) . '/lang/' );
}
add_action( 'init', 'nf_subpages_load_lang');

function nf_subpages_scripts() {
	wp_register_style( 'nf-subpages-style', plugins_url('css/nf-subpages-no-js-style.css', __FILE__));
	wp_enqueue_style( 'nf-subpages-style' );

	wp_enqueue_script( 'nf-subpages-script', plugins_url('js/nf-subpages-script.js', __FILE__), array( 'jquery' ), false, true );
	wp_localize_script( 'nf-subpages-script', 'nf_subpages', array( 'js_style_url' => plugins_url('css/nf-subpages-style.css', __FILE__) ) );

}
add_action('wp_enqueue_scripts', 'nf_subpages_scripts');

function nf_register_field_fieldset_start(){
	$args = array(
        'name' => __( 'Fieldset Start', 'nf-subpages' ),
        'sidebar' => 'layout_fields',
        'edit_function' => '',
        'display_function' => 'nf_field_fieldset_start',
        'group' => 'layout_elements',
        'display_label' => false,
        'display_wrap' => false,
        'edit_label' => true,
        'edit_label_pos' => false,
        'edit_req' => false,
        'edit_custom_class' => true,
        'edit_help' => false,
        'edit_meta' => false,
        'edit_conditional' => true,
        'process_field' => false,
	);

    if( function_exists( 'ninja_forms_register_field' ) ) {
		ninja_forms_register_field('_fieldset_start', $args);
    }

}
add_action('init', 'nf_register_field_fieldset_start');

function nf_field_fieldset_start($field_id, $data){
	$field_class = ninja_forms_get_field_class($field_id);
	?>
	<fieldset class="<?php echo $field_class;?>" id="nf_field_<?php echo $field_id;?>_div_wrap" rel="<?php echo $field_id;?>">
	<legend><?php echo $data["label"];?></legend>
	<?php

}

function nf_register_field_fieldset_end(){
	$args = array(
		'name' => __( 'Fieldset End', 'nf-subpages' ),
		'sidebar' => 'layout_fields',
		'edit_function' => '',
		'display_function' => 'nf_field_fieldset_end',
		'group' => 'standard_fields',
		'display_label' => false,
		'display_wrap' => false,
		'edit_label' => false,
		'edit_label_pos' => false,
		'edit_req' => false,
		'edit_custom_class' => false,
		'edit_help' => false,
		'edit_meta' => false,
		'edit_conditional' => true,
		'process_field' => false,
	);

    if( function_exists( 'ninja_forms_register_field' ) ) {
		ninja_forms_register_field('_fieldset_end', $args);
    }	
}
add_action('init', 'nf_register_field_fieldset_end');

function nf_field_fieldset_end($field_id, $data){
	?>
	</fieldset>
	<?php

}

function nf_register_field_subpage_start(){
    $args = array(
        'name' => __( 'Subpage Start', 'nf-subpages' ),
        'sidebar' => 'layout_fields',
        'edit_function' => '',
        'display_function' => 'nf_field_subpage_start',
        'group' => 'layout_elements',
        'display_label' => false,
        'display_wrap' => false,
        'edit_label' => true,
        'edit_label_pos' => false,
        'edit_req' => false,
        'edit_custom_class' => true,
        'edit_help' => false,
        'edit_meta' => false,
        'edit_conditional' => true,
        'process_field' => false,
    );

    if( function_exists( 'ninja_forms_register_field' ) ) {
		ninja_forms_register_field('_subpage_start', $args);
    }
    
}
add_action('init', 'nf_register_field_subpage_start');

function nf_field_subpage_start($field_id, $data){
    $field_class = ninja_forms_get_field_class($field_id);
    ?>
    <div class="nf_subpage_wrap <?php echo $field_class;?>" id="nf_field_<?php echo $field_id;?>_subpage_wrap" data-index="" rel="<?php echo $field_id;?>">
		<div class="nf_subpage_header"><span class="nf_subpage_title"><?php echo $data["label"];?></span></div>
		<div class="nf_subpage_content">
			<fieldset class="nf_subpage_fieldset <?php echo $field_class;?>">
				<legend><?php echo $data["label"];?></legend>
<?php

}

function nf_register_field_subpage_end(){
    $args = array(
        'name' => __( 'Subpage End', 'nf-subpages' ),
        'sidebar' => 'layout_fields',
        'edit_function' => '',
        'display_function' => 'nf_field_subpage_end',
        'group' => 'standard_fields',
        'display_label' => false,
        'display_wrap' => false,
        'edit_label' => false,
        'edit_label_pos' => false,
        'edit_req' => false,
        'edit_custom_class' => false,
        'edit_help' => false,
        'edit_meta' => false,
        'edit_conditional' => true,
        'process_field' => false,
    );

    if( function_exists( 'ninja_forms_register_field' ) ) {
		ninja_forms_register_field('_subpage_end', $args);
    }

    
}
add_action('init', 'nf_register_field_subpage_end');

function nf_field_subpage_end($field_id, $data){
    ?>
			</fieldset>
		</div>
		<div class="nf_subpage_footer">
			<span class="nf_subpage_navigation">
				<span class="nf_subpage_button nf_subpage_prev"><?php _e( 'prev', 'nf-subpages' ) ?></span>
				<span class="nf_subpage_button nf_subpage_next"><?php _e( 'next', 'nf-subpages' ) ?></span>
			</span>
			<span class="nf_subpage_progressbar_wrap">
				<div class="nf_subpage_progressbar">
					<div class="nf_subpage_progressbar_text">0 %</div>
					<span></span>
				</div>
			</span>
			<br class="nf_subpage_clear" />
		</div>
    </div>
<?php

}
?>