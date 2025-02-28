<?php
/**
 * Plugin Name: Elementor WooCommerce Price Dynamic Tags
 * Description: Adiciona tags dinâmicas de Preço Promocional, Preço Normal e isOnSale ao Elementor para uso em páginas de produto WooCommerce.
 * Version: 1.0
 * Author: Kelvyn Sinhorini
 * Text Domain: elementor-woocommerce-price-dynamic-tags
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Protege contra acesso direto
}

add_action( 'elementor/dynamic_tags/register', function( $dynamic_tags ) {

    // --- Classe: Sale Price (preço promocional) ---
    class EWCPT_Sale_Price_Tag extends \Elementor\Core\DynamicTags\Data_Tag {
        public function get_name() {
            return 'ewcpt_sale_price_tag';
        }
        public function get_title() {
            return __( 'Produto: Preço Promocional (WC)', 'elementor-woocommerce-price-dynamic-tags' );
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
    class EWCPT_Regular_Price_Tag extends \Elementor\Core\DynamicTags\Data_Tag {
        public function get_name() {
            return 'ewcpt_regular_price_tag';
        }
        public function get_title() {
            return __( 'Produto: Preço Normal (WC)', 'elementor-woocommerce-price-dynamic-tags' );
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
    class EWCPT_Is_On_Sale_Tag extends \Elementor\Core\DynamicTags\Data_Tag {
        public function get_name() {
            return 'ewcpt_is_on_sale_tag';
        }
        public function get_title() {
            return __( 'Produto: Está em Promoção? (WC)', 'elementor-woocommerce-price-dynamic-tags' );
        }
        public function get_categories() {
            // Também texto, pois o Elementor não tem “boolean category” por padrão
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

    // Registrar as novas classes de tags dinâmicas no Elementor
    $dynamic_tags->register_tag( 'EWCPT_Sale_Price_Tag' );
    $dynamic_tags->register_tag( 'EWCPT_Regular_Price_Tag' );
    $dynamic_tags->register_tag( 'EWCPT_Is_On_Sale_Tag' );

});
