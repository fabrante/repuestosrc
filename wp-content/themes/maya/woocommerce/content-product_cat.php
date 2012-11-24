<?php
/**
 * The template for displaying product category thumbnails within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product_cat.php
 *
 * @package WooCommerce
 * @since WooCommerce 1.6
 */
 
global $woocommerce_loop;                    

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) 
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ) 
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_categories_columns', 3 );

// Increase loop count
$woocommerce_loop['loop']++;
?>
<li class="product category <?php 
	if ( ! isset( $woocommerce_loop['setLast'] ) && $woocommerce_loop['loop'] % $woocommerce_loop['columns'] == 0 ) 
		echo 'last'; 
	elseif ( ! isset( $woocommerce_loop['setFirst'] ) && ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] == 0 ) 
		echo 'first'; 
	?>">

	<?php do_action( 'woocommerce_before_subcategory', $category ); ?>
		
	<a href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>"<?php if ( yiw_get_option('shop_show_shadow_categories_page') ) : ?> class="shadow"<?php endif ?>>
				
		<?php
			/** 
			 * woocommerce_before_subcategory_title hook
			 *
			 * @hooked woocommerce_subcategory_thumbnail - 10
			 */	  
			do_action( 'woocommerce_before_subcategory_title', $category ); 
		?>
		
		<h3 class="<?php echo yiw_get_option('shop_title_position_categories_page') ?>">
			<?php echo $category->name; ?> 
			<?php if ( $category->count > 0 ) : ?>
				<mark class="count">(<?php echo $category->count; ?>)</mark>
			<?php endif; ?>
		</h3>

		<?php
			/** 
			 * woocommerce_after_subcategory_title hook
			 */	  
			do_action( 'woocommerce_after_subcategory_title', $category ); 
		?>
	
	</a>
	
	<?php do_action( 'woocommerce_after_subcategory', $category ); ?>
			
</li>