<?php
/**
 * Plugin Name: My Elementor WC Dynamic Tags
 * Description: Adiciona tags dinâmicas de Preço Promocional, Preço Normal e isOnSale no Elementor.
 * Version: 1.0
 * Author: Seu Nome
 * Text Domain: my-elementor-wc-dynamic-tags
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Protege acesso direto
}

add_action( 'elementor/dynamic_tags/register', function( $dynamic_tags ) {

    // --- Classe: Sale Price (preço promocional) ---
    class WC_Sale_Price_Tag extends \Elementor\Core\DynamicTags\Data_Tag {
        public function get_name() {
            return 'wc_sale_price_tag';
        }
        public function get_title() {
            return __( 'Produto: Preço Promocional (WC)', 'my-elementor-wc-dynamic-tags' );
        }
        public function get_categories() {
            return [ \Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY ];
        }
        public function get_value( array $options = [] ) {
            if ( is_product() ) {
                global $product;
                if ( $product instanceof \WC_Product && $product->is_on_sale() ) {
                    return wc_price( $product->get_sale_price() );
                }
            }
            return '';
        }
    }

    // --- Classe: Regular Price (preço normal) ---
    class WC_Regular_Price_Tag extends \Elementor\Core\DynamicTags\Data_Tag {
        public function get_name() {
            return 'wc_regular_price_tag';
        }
        public function get_title() {
            return __( 'Produto: Preço Normal (WC)', 'my-elementor-wc-dynamic-tags' );
        }
        public function get_categories() {
            return [ \Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY ];
        }
        public function get_value( array $options = [] ) {
            if ( is_product() ) {
                global $product;
                if ( $product instanceof \WC_Product ) {
                    return wc_price( $product->get_regular_price() );
                }
            }
            return '';
        }
    }

    // --- Classe: isOnSale (retorna “true” ou “false”) ---
    class WC_Is_On_Sale_Tag extends \Elementor\Core\DynamicTags\Data_Tag {
        public function get_name() {
            return 'wc_is_on_sale_tag';
        }
        public function get_title() {
            return __( 'Produto: Está em Promoção? (WC)', 'my-elementor-wc-dynamic-tags' );
        }
        public function get_categories() {
            return [ \Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY ];
        }
        public function get_value( array $options = [] ) {
            if ( is_product() ) {
                global $product;
                if ( $product instanceof \WC_Product ) {
                    return $product->is_on_sale() ? 'true' : 'false';
                }
            }
            return 'false';
        }
    }

    // Registrar as classes
    $dynamic_tags->register_tag( 'WC_Sale_Price_Tag' );
    $dynamic_tags->register_tag( 'WC_Regular_Price_Tag' );
    $dynamic_tags->register_tag( 'WC_Is_On_Sale_Tag' );
});
