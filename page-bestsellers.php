<?php /* Template Name: Page Bestsellers */ get_header(); ?>

<section class="page-header">
    <h1><?php the_title(); ?></h1>
</section>

<div class="woocommerce">
    <div class="products-wrapper grid-mode">
        <ul class="products columns-4">
            <?php
                $args = array(
                    'post_type' => 'product',
                    'orderby' => 'meta_value_num',
                    'order' => 'DESC',
                    'posts_per_page' => 8,
                    'meta_key'  => 'total_sales',
                    'date_query' => array(
                        array(
                            'after' => date( 'Y-m-d', strtotime( '-1 year' ) )
                        ),
                    ),
                );
                $loop = new WP_Query( $args );
                if ( $loop->have_posts() ) {
                    while ( $loop->have_posts() ) : $loop->the_post();
                        wc_get_template_part( 'content', 'product' );
                    endwhile;
                } else {
                    echo __( 'No products found' );
                }
                wp_reset_postdata();
            ?>
        </ul><!--/.products-->
    </div>
</div>


</div>

<?php get_footer(); ?>