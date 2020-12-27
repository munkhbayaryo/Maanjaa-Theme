<?php /* Template Name: Page Bestsellers */ get_header(); ?>

<section class="page-header">
    <h1><?php the_title(); ?></h1>
</section>

<!-- <?php dynamic_sidebar( 'best_sellers' ); ?> -->

<?php echo do_shortcode('[br_filters_group group_id=75 berocket_aapf=true]'); ?>

<div class="woocommerce">
    <div class="products-wrapper grid-mode">
        <ul class="products columns-4">
            <?php
                $atts = array();

                $query_args = array(
                    'post_type' => 'product',
                    'post_status' => 'publish',
                    'orderby' => 'meta_value_num',
                    'meta_key'  => 'total_sales',
                    'order' => 'DESC',
                    'posts_per_page' => 8,
                    'date_query' => array(
                        array(
                            'after' => date( 'Y-m-d', strtotime( '-1 year' ) )
                        ),
                    ),
                    'suppress_filters' => true,
                );

                $query_args = apply_filters( 'woocommerce_shortcode_products_query', $query_args, $atts );

                $query  = new WP_Query( $query_args );

                if ( $query ->have_posts() ) {
                    while ( $query ->have_posts() ) : $query ->the_post();
                        wc_get_template_part( 'content', 'product' );
                    endwhile;
                } else {
                    echo __( 'No products found.' );
                }
                wp_reset_postdata();
            ?>
        </ul><!--/.products-->
    </div>
</div>

<?php get_footer(); ?>