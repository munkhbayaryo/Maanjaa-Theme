<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );?>
<div class="row">
<div class="col-lg-3 d-none d-lg-block">
<div class="filters-area">
<?php
/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action( 'woocommerce_sidebar' );
?>
</div>
</div>
<div class="col-12 col-lg-9">
<?php

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

?>
<header class="woocommerce-products-header">
	<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
		<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
	<?php endif; ?>

	<span class="list-style-buttons">
		<a href="#" id="gridview" class="switcher"><span class="ti-layout-grid2"></span></a>
		<a href="#" id="listview" class="switcher"><span class="ti-align-left"></span></a>
	</span>
	<span id="show-filter" class="show-filter">
		<a href="#"><span class="ti-filter"></span></a>
		<span>Show filter</span>
	</span>

	<?php
	/**
	 * Hook: woocommerce_archive_description.
	 *
	 * @hooked woocommerce_taxonomy_archive_description - 10
	 * @hooked woocommerce_product_archive_description - 10
	 */
	do_action( 'woocommerce_archive_description' );
	?>
</header>
<?php
if ( woocommerce_product_loop() ) {

	/**
	 * Hook: woocommerce_before_shop_loop.
	 *
	 * @hooked woocommerce_output_all_notices - 10
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */
	do_action( 'woocommerce_before_shop_loop' );

	// woocommerce_product_loop_start();

	// if ( wc_get_loop_prop( 'total' ) ) {
	// 	while ( have_posts() ) {
	// 		the_post();

	// 		/**
	// 		 * Hook: woocommerce_shop_loop.
	// 		 */
	// 		do_action( 'woocommerce_shop_loop' );

	// 		wc_get_template_part( 'content', 'product' );
	// 	}
	// }

	$paged                   = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;
	$ordering                = WC()->query->get_catalog_ordering_args();
	$ordering['orderby']     = array_shift(explode(' ', $ordering['orderby']));
	$ordering['orderby']     = stristr($ordering['orderby'], 'price') ? 'meta_value_num' : $ordering['orderby'];
	$products_per_page       = apply_filters('loop_shop_per_page', wc_get_default_products_per_row() * wc_get_default_product_rows_per_page());
  
	$featured_products       = wc_get_products(array(
	//   'meta_key'             => '',
	  'status'               => 'publish',
	  'limit'                => $products_per_page,
	  'page'                 => $paged,
	  'featured'             => true,
	  'paginate'             => true,
	  'return'               => 'ids',
	//   'orderby'              => $ordering['orderby'],
	//   'order'                => $ordering['order'],
	));
  
	wc_set_loop_prop('current_page', $paged);
	wc_set_loop_prop('is_paginated', wc_string_to_bool(true));
	wc_set_loop_prop('page_template', get_page_template_slug());
	wc_set_loop_prop('per_page', $products_per_page);
	wc_set_loop_prop('total', $featured_products->total);
	wc_set_loop_prop('total_pages', $featured_products->max_num_pages);
  
	if($featured_products) {
	  do_action('woocommerce_before_shop_loop');
	  woocommerce_product_loop_start();
		foreach($featured_products->products as $featured_product) {
		  $post_object = get_post($featured_product);
		  setup_postdata($GLOBALS['post'] =& $post_object);
		  wc_get_template_part('content', 'product');
		}
		wp_reset_postdata();
	  woocommerce_product_loop_end();
	  do_action('woocommerce_after_shop_loop');
	} else {
	  do_action('woocommerce_no_products_found');
	}

	woocommerce_product_loop_end();

	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	do_action( 'woocommerce_after_shop_loop' );
} else {
	/**
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action( 'woocommerce_no_products_found' );
}

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' ); ?>
</div>
		
</div>

<?php
get_footer( 'shop' );
