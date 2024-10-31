<?php
/**
 * Enqueue scripts for PDF Viewer by ThemeNcode
 *
 * Enqueue both frontend and backend scripts.
 *
 * @since 1.0
 *
 * @package pdf-viewer-by-themencode
 */

if ( ! function_exists( 'tnc_pvfw_enqueue_script' ) ) {
	/**
	 * Enqueue jquery as some themes may have jquery disabled.
	 */
	function tnc_pvfw_enqueue_script() {
		if ( is_singular( 'pdfviewer' ) ) {
			global $post;

			wp_enqueue_script( 'themencode-pdf-viewer-jquery', plugins_url() . '/' . PVFW_LITE_PLUGIN_DIR . '/tnc-resources/jquery.min.js', array(), PVFW_LITE_PLUGIN_VERSION, false );
			wp_enqueue_script( 'themencode-pdf-viewer-compatibility-js', plugins_url() . '/' . PVFW_LITE_PLUGIN_DIR . '/web/compatibility.js', array(), PVFW_LITE_PLUGIN_VERSION, false );
			wp_enqueue_script( 'themencode-pdf-viewer-pdf-js', plugins_url() . '/' . PVFW_LITE_PLUGIN_DIR . '/build/pdf.js', array(), PVFW_LITE_PLUGIN_VERSION, false );
			wp_enqueue_script( 'themencode-pdf-viewer-debugger-js', plugins_url() . '/' . PVFW_LITE_PLUGIN_DIR . '/web/debugger.js', array(), PVFW_LITE_PLUGIN_VERSION, false );
			wp_enqueue_script( 'themencode-pdf-viewer-pinch-zoom-js', plugins_url() . '/' . PVFW_LITE_PLUGIN_DIR . '/tnc-resources/pinch-zoom.js', array(), PVFW_LITE_PLUGIN_VERSION, false );
			wp_enqueue_script( 'themencode-pdf-viewer-modal-js', plugins_url() . '/' . PVFW_LITE_PLUGIN_DIR . '/tnc-resources/jquery.modal.min.js', array(), PVFW_LITE_PLUGIN_VERSION, false );

			if( ! empty ( $post->ID ) ){
				$get_pvfw_single_settings_for_js = get_post_meta( $post->ID, 'tnc_pvfw_pdf_viewer_fields', true );
				$fto                             = base64_encode( $get_pvfw_single_settings_for_js['file'] );

				if( isset( $get_pvfw_single_settings_for_js['language'] ) && !empty( $get_pvfw_single_settings_for_js['language'] ) ) {
				$get_language                    = $get_pvfw_single_settings_for_js['language'];
				} else {
					$get_language = 'en-US';
				}

				if( isset( $get_pvfw_single_settings_for_js['default_scroll'] ) && !empty( $get_pvfw_single_settings_for_js['default_scroll'] ) ) {
					$scroll_default                  = $get_pvfw_single_settings_for_js['default_scroll'];
				} else {
					$scroll_default = '0';
				}

				if( isset( $get_pvfw_single_settings_for_js['default_spread'] ) && !empty( $get_pvfw_single_settings_for_js['default_spread'] ) ) {
					$spread_default                  = $get_pvfw_single_settings_for_js['default_spread'];
				} else {
					$spread_default = '0';
				}
				
				if( isset( $get_pvfw_single_settings_for_js['default_zoom'] ) && !empty( $get_pvfw_single_settings_for_js['default_zoom'] ) ) {
					$zoom_default                    = $get_pvfw_single_settings_for_js['default_zoom'];
				} else {
					$zoom_default = 'auto';
				}

				wp_add_inline_script(
					'themencode-pdf-viewer-pdf-js',
					'var tnc_locale = "'. $get_language .'";
					var tnc_imageResourcesPath = "'. plugins_url() . '/' . PVFW_LITE_PLUGIN_DIR .'/web/images/";
					var tnc_workerSrc = "'. plugins_url() . '/' . PVFW_LITE_PLUGIN_DIR .'/build/pdf.worker.js";
					var tnc_cMapUrl = "'. plugins_url() . '/' . PVFW_LITE_PLUGIN_DIR .'/web/cmaps/";
					var tnc_cMapPacked = true;

					var fto = "' . $fto . '";
					var tnc_scroll_default = ' . $scroll_default . ';
					var tnc_spread_default = ' . $spread_default . ';
					var tnc_zoom_default = "' . $zoom_default . '";',
			   		$position = 'after' );
			}

			wp_enqueue_script( 'themencode-pdf-viewer-viewer-js', plugins_url() . '/' . PVFW_LITE_PLUGIN_DIR . '/web/viewer.js', array(), PVFW_LITE_PLUGIN_VERSION, false );
			wp_enqueue_script( 'themencode-pdf-viewer-send-to-friend-js', plugins_url() . '/' . PVFW_LITE_PLUGIN_DIR . '/tnc-resources/send-to-friend.js', array(), PVFW_LITE_PLUGIN_VERSION, false );
		}
	}
	add_action( 'wp_enqueue_scripts', 'tnc_pvfw_enqueue_script' );
}


if( ! function_exists( 'tnc_pvfw_enqueue_admin_css' )){
	add_action( 'admin_enqueue_scripts', 'tnc_pvfw_enqueue_admin_css' );

	/**
	 * Enqueue Scripts in the admin
	 *
	 * @param  [type] $hook_suffix [description].
	 */
	function tnc_pvfw_enqueue_admin_css( $hook_suffix ) {
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( 'pvfw-admin-css', plugins_url() . '/' . PVFW_LITE_PLUGIN_DIR . '/tnc-resources/admin-css.css', array(), PVFW_LITE_PLUGIN_VERSION, $media = 'all' );
		wp_enqueue_style( 'sweetalert-css', plugins_url() . '/' . PVFW_LITE_PLUGIN_DIR . '/tnc-resources/sweetalert2.min.css', array(), PVFW_LITE_PLUGIN_VERSION, $media = 'all' );
		wp_enqueue_script( 'pvfw-admin-js', plugins_url() . '/' . PVFW_LITE_PLUGIN_DIR . '/tnc-resources/admin-js.js', array(), PVFW_LITE_PLUGIN_VERSION, true );
		wp_enqueue_script( 'sweetalert-js', plugins_url() . '/' . PVFW_LITE_PLUGIN_DIR . '/tnc-resources/sweetalert2.all.min.js', array(), PVFW_LITE_PLUGIN_VERSION, true );
		wp_enqueue_script( 'alert-custom-js', plugins_url() . '/' . PVFW_LITE_PLUGIN_DIR . '/tnc-resources/alert-admin-custom.js', array(), PVFW_LITE_PLUGIN_VERSION, true );



	}
}

if ( ! function_exists( 'tnc_pvfw_lite_remove_all_scripts' ) ){
	function tnc_pvfw_lite_remove_all_scripts() {
		if ( is_singular( 'pdfviewer' )){
			global $wp_scripts;
			$tnc_pvfw_script_handles = array('themencode-pdf-viewer-jquery', 'themencode-pdf-viewer-compatibility-js', 'themencode-pdf-viewer-pdf-js', 'themencode-pdf-viewer-debugger-js', 'themencode-pdf-viewer-pinch-zoom-js', 'themencode-pdf-viewer-modal-js', 'themencode-pdf-viewer-viewer-js', 'themencode-pdf-viewer-send-to-friend-js');
			foreach ($wp_scripts->registered as $single_key => $single_script) {
				if( ! in_array( $single_script->handle, $tnc_pvfw_script_handles) ){
					wp_dequeue_script( $single_script->handle );
				}
			}
		}
	}
	add_action('wp_print_scripts', 'tnc_pvfw_lite_remove_all_scripts');
}

if ( ! function_exists( 'tnc_pvfw_lite_remove_all_styles' ) ){
	function tnc_pvfw_lite_remove_all_styles() {
		if ( is_singular( 'pdfviewer' )){
			global $wp_styles;
			$tnc_pvfw_style_handles = array('themencode-pdf-viewer-css', 'themencode-pdf-viewer-theme-midnight-calm', 'themencode-pdf-viewer-theme-aqua-white', 'themencode-pdf-viewer-modal-css');
			foreach ( $wp_styles->registered as $single_key => $single_style) {
				if( ! in_array( $single_style->handle, $tnc_pvfw_style_handles) ){
					wp_dequeue_style( $single_style->handle );
				}
			}
		}
	}
	add_action('wp_print_styles', 'tnc_pvfw_lite_remove_all_styles');
}

if ( ! function_exists( 'tnc_pvfw_add_viewer_styles') ){
	add_action('wp_enqueue_scripts', 'tnc_pvfw_add_viewer_styles');

	function tnc_pvfw_add_viewer_styles() {
		if ( is_singular( 'pdfviewer' ) ){
			wp_enqueue_style( 'themencode-pdf-viewer-css', plugins_url() . '/' . PVFW_LITE_PLUGIN_DIR . '/web/viewer.css', array(), PVFW_LITE_PLUGIN_VERSION, 'all' );
			// Load selected theme only.
			global $post;
			if( !empty ( $post->ID ) ){
				$get_pvfw_single_settings = get_post_meta( $post->ID, 'tnc_pvfw_pdf_viewer_fields', true );
				$get_pvfw_single_type     = $get_pvfw_single_settings['appearance-select-type'];
				if( $get_pvfw_single_type == 'select-theme' ){
					$get_pvfw_single_theme    = $get_pvfw_single_settings['appearance-select-theme'];
					wp_enqueue_style( 'themencode-pdf-viewer-theme-'. $get_pvfw_single_theme , plugins_url() . '/' . PVFW_LITE_PLUGIN_DIR . '/web/schemes/' . $get_pvfw_single_theme . '.css', array(), PVFW_LITE_PLUGIN_VERSION, 'all' );
				}
			}
			wp_enqueue_style( 'themencode-pdf-viewer-modal-css', plugins_url() . '/' . PVFW_LITE_PLUGIN_DIR . '/tnc-resources/jquery.modal.min.css', array(), PVFW_LITE_PLUGIN_VERSION, 'all' );
		}
	}
}