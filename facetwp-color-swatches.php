<?php
/*
Plugin Name: FacetWP - Variation Swatches for WooCommerce Integration
Description: 
Version: 0.1
Author: FacetWP, LLC
Author URI: https://facetwp.com/
GitHub URI: 
*/

defined( 'ABSPATH' ) or exit;

class FacetWP_Color_Swatches
{

    function __construct() {

        add_filter( 'facetwp_assets', [ $this, 'assets' ] );
        add_filter( 'facetwp_facet_html', [ $this, 'render_colors' ], 10, 2 );
    }

    function assets( $assets ) {
        $assets['swatches-flyout.js'] = plugins_url( '', __FILE__ ) . '/assets/js/front.js';
        $assets['swatches-flyout.css'] = plugins_url( '', __FILE__ ) . '/assets/css/front.css';
        return $assets;
    }

    function render_colors( $output, $params ) {
        if ( 'color' == $params['facet']['type'] ) {
            $facet = $params['facet'];

            $attrs = wc_get_attribute_taxonomy_ids( );
            $attr = wc_get_attribute( $attrs[ str_replace( 'tax/pa_', '', $params['facet']['source'] ) ] );

            if ( ! isset( $attr->type ) ) {
                return $output;
            }

            $output = '';
            $values = (array) $params['values'];
            $selected_values = (array) $params['selected_values'];

            foreach ( $values as $result ) {

                $term = get_term( $result['term_id'] );

                $img = '';
                if ( 'image' == $attr->type ) {
                    $img = (int) wvs_get_product_attribute_image( $term );
                    $img ( 0 < $img ) ? wp_get_attachment_image_url( $img ) : '';
                }

                $color = ( ! empty( wvs_get_product_attribute_color( $term ) ) ) ? wvs_get_product_attribute_color( $term ) : $result['facet_display_value'];
                $selected = in_array( $result['facet_value'], $selected_values ) ? ' checked' : '';
                $selected .= ( 0 == $result['counter'] ) ? ' disabled' : '';
                $output .= '<div class="facetwp-color' . $selected . '" data-value="' . $result['facet_value'] . '" data-color="' . esc_attr( $color ) . '" data-img="' . esc_attr( $img ) . '"></div>';
            }
        }
        return $output;
    }
}

new FacetWP_Color_Swatches();