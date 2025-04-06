<?php

/**
 * Plugin Name: Product Country Flag for WooCommerce
 * Description: Add a country flag to WooCommerce products and show it beside the product title.
 * Version: 1.0
 * Author: ChatGPT
 */
// Add the country flag field to all product types (simple, variable, etc.)

add_action('woocommerce_product_options_general_product_data', 'add_country_flag_field');

function add_country_flag_field()
{

    global $post;



    echo '<div class="options_group">';

    woocommerce_wp_select(array(

        'id' => '_product_country_flag',
        'label' => 'Country Flag',
        'desc_tip' => true,
        'description' => 'Select a country flag for this product.',
        'options' => array(
            '' => 'Select Country',
            'usa' => 'USA',
            'canada' => 'Canada',
            'france' => 'France',
            'uk' => 'United Kingdom',
            'germany' => 'Germany',
            'uae' => 'UAE',
            'saudi' => 'Saudi Arabia',
            'india' => 'India',
            'japan' => 'Japan',

        )

    ));

    echo '</div>';
}
// Save the selected flag
add_action('woocommerce_process_product_meta', function ($post_id) {
    if (isset($_POST['_product_country_flag'])) {
        update_post_meta($post_id, '_product_country_flag', sanitize_text_field($_POST['_product_country_flag']));
    }
});
// Show flag beside product title
add_filter('the_title', function ($title, $id) {
    if (get_post_type($id) !== 'product')
        return $title;
    $flag = get_post_meta($id, '_product_country_flag', true);
    if ($flag) {
        $flag_url = plugin_dir_url(__FILE__) . 'flags/' . $flag . '.png';
        $title .= ' <img src="' . esc_url($flag_url) . '" alt="' . esc_attr(ucfirst($flag)) . ' Flag" style="width:20px; height:auto; vertical-align:middle; margin-left:5px;">';
    }
    return $title;
}, 10, 2);