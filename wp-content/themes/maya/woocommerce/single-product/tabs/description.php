<?php
/**
 * Description Tab
 */
 
global $woocommerce, $post;

if ( $post->post_content ) : ?>
	<div class="panel entry-content" id="tab-description">
	
		<?php $heading = apply_filters('woocommerce_product_description_heading', __('Product Description', 'woocommerce')); ?>
		
		<h2><?php echo $heading; ?></h2>
		
		<?php the_content(); ?>
        
        <?php
        if( yiw_get_option( 'shop_show_share_socials' ) ) :
            echo do_shortcode( '[share title="' . yiw_get_option( 'shop_share_title' ) . '" socials="' . yiw_get_option( 'shop_share_socials' ) . '"]' );
        endif;
        ?>
	
	</div>
<?php endif; ?>