<?php /* Template Name: Page Bestsellers */ get_header(); ?>

<div class="row">

    <div class="col">
        <?php dynamic_sidebar( 'best_sellers' ); ?>
    </div>
    <div class="col-6 text-center">
        <h1><?php the_title(); ?></h1>
    </div>
    <div class="col">

    </div>

</div>

<div class="woocommerce">
    <div class="products-wrapper grid-mode">
        <ul class="products best-seller columns-4">
            <?php
                $atts = array();

                $query_args = array(
                    'post_type' => 'product',
                    'post_status' => 'publish',
                    'orderby' => 'meta_value_num',
                    'meta_key'  => 'total_sales',
                    'order' => 'DESC',
                    'posts_per_page' => 12,
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
                        ?>

                        <li <?php wc_product_class('product-list clearfix best-seller' , $product ); ?>>

                                <div class="inner-left">
                                    <?php if ( has_post_thumbnail() ) {
                                        echo '<div class="product-thumb">'; woocommerce_show_product_loop_sale_flash(); echo '<span class="helper">';
                                            echo '<a href="'; the_permalink(); echo '">'; the_post_thumbnail('maanjaa-thumb'); echo '</a>';
                                        echo '</span></div>';
                                    } ?>

                                    <div class="product-details best-seller">
                                        <h3 class="name"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>

                                        <?php do_action( 'express_shop_title' ); ?>
                                        
                                        <?php if($product->get_stock_quantity()>0) {
                                            echo '<p class="stock-in-loop">'; echo 'Only '; echo $product->get_stock_quantity(); echo ' left in stock - order soon.';  echo '</p>';
                                            }
                                        ?>

                                        <div class="rating">
                                            <?php
                                                if ($rating_html = wc_get_rating_html( $product->get_average_rating() )) {
                                                    echo trim( wc_get_rating_html( $product->get_average_rating() ) );
                                                }
                                            ?>
                                        </div>

                                    </div>

                                </div>

                                <div class="inner-right">
                                    <div class="inner">
                                        <div class="price"><?php echo ($product->get_price_html()); ?></div>
                                        <div class="addcart">
                                            <?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
                                        </div>
                                    </div>
                                </div>
                        </li>


                        <?php
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