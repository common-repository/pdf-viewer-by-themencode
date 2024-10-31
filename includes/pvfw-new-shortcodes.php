<?php
/**
 * Register new shortcodes
 *
 * All the shortcodes here.
 *
 * @since [1.0]
 *
 * @package pdf-viewer-by-themencode
 */

if ( ! function_exists( 'tnc_pvfw_embed_shortcode' )){
	/**
	 * [tnc_pvfw_embed_shortcode description]
	 *
	 * @param  [type] $atts [description].
	 *
	 * @return [type]       [description]
	 */
	function tnc_pvfw_embed_shortcode( $atts ) {

		extract(
			shortcode_atts(
				array(
					'width'        => '100%',
					'height'       => '800',
					'viewer_id'    => '',
					'iframe_title' => '',
					'page'         => '',
				),
				$atts,
				'tnc_pdf_embed_shortcode'
			)
		);

		$get_pvfw_global_settings = get_option( 'pvfw_csf_options' );
		$get_pvfw_single_settings = get_post_meta( $viewer_id, 'tnc_pvfw_pdf_viewer_fields', true );

		if( ! empty( $get_pvfw_single_settings['toolbar-elements-use-global-settings'] ) ) {
			$toolbar_use_global = $get_pvfw_single_settings['toolbar-elements-use-global-settings'];
		} else {
			$toolbar_use_global = '';
		}

		if ( $toolbar_use_global == '0' ) {
			$fullscreen = ($get_pvfw_single_settings['fullscreen'] == '1') ? 'on' : 'off' ;
		} else {
			$fullscreen = ($get_pvfw_global_settings['toolbar-fullscreen'] == '1') ? 'on' : 'off' ;
		}

		$get_fullscreen_text = $get_pvfw_global_settings['general-fullscreen-text'];

		if ( ! empty( $get_fullscreen_text ) ) {
			$fullscreen_text = $get_fullscreen_text;
		} else {
			$fullscreen_text = esc_html__( 'Fullscreen Mode', 'pdf-viewer-by-themencode' );
		}

		$output  = '';

		if ( $fullscreen == 'on' ) {
			$output .= '<a class="fullscreen-mode" href="' . esc_url( get_permalink( $viewer_id ) ) . '#page=' . esc_attr( $page ) . '" target="_blank">' . esc_attr( $fullscreen_text ) . '</a><br>';
		}
		$output .= '<iframe width="' . esc_attr( $width ) . '" height="' . esc_attr( $height ) . '" src="' . esc_url ( get_permalink( $viewer_id ) ) . '#page=' . esc_attr( $page ) . '" title="' . esc_attr( $iframe_title ) . '"></iframe>';

		return $output;
	}

	add_shortcode( 'pvfw-embed', 'tnc_pvfw_embed_shortcode' );
}

if ( ! function_exists( 'tnc_pvfw_link_shortcode' )){
	/**
	 * [tnc_pvfw_link_shortcode description]
	 *
	 * @param  [type] $atts [description].
	 * @return [type]       [description]
	 */
	function tnc_pvfw_link_shortcode( $atts ) {
		extract(
			shortcode_atts(
				array(
					'text'      => 'Open PDF',
					'open_type' => ' ',
					'target'    => '_blank',
					'viewer_id' => '',
					'class'     => 'tnc-pdf',
					'page'         => '',
				),
				$atts,
				'tnc_pdf_new_link_shortcode'
			)
		);

		$output  = '';

		$output .= '<a href="' . esc_url( get_permalink( $viewer_id ) ) . '#page=' . esc_attr( $page ) . '" class="' . esc_attr( $class ) . ' ' . esc_attr( $open_type ) . '" target="' . esc_attr( $target ) . '">' . esc_html( $text ) . '</a>';

		return $output;
	}

	add_shortcode( 'pvfw-link', 'tnc_pvfw_link_shortcode' );
}
