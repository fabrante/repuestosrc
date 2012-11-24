<?php
/**
 * Loop Add to Cart
 */
 
global $post, $product, $woocommerce_loop;

if ( isset( $woocommerce_loop['style'] ) )
    $style = $woocommerce_loop['style'];
else
    $style = yiw_get_option( 'shop_products_style', 'ribbon' );                

if( $product->get_price() === '' && $product->product_type!=='external') return;
?>

<?php if (!$product->is_in_stock()) : ?>  
		
	<a href="<?php echo get_permalink($post->ID); ?>" class="button"><?php echo apply_filters('out_of_stock_add_to_cart_text', __('Read More', 'woocommerce')); ?></a>

<?php 
else :
		
	switch ($product->product_type) :
		case "variable" :
			$link 	= get_permalink($post->ID);
			$label 	= apply_filters('variable_add_to_cart_text', __('Select options', 'woocommerce'));
		break;
		case "grouped" :
			$link 	= get_permalink($post->ID);
			$label 	= apply_filters('grouped_add_to_cart_text', __('View options', 'woocommerce'));
		break;
		case "external" :
			$link 	= get_permalink($post->ID);
			$label 	= apply_filters('external_add_to_cart_text', __('Read More', 'woocommerce'));
		break;
		default :
			$link 	= esc_url( $product->add_to_cart_url() );
			$label 	= apply_filters('add_to_cart_text', yiw_get_option( 'shop_button_addtocart_label', __('Add to cart', 'woocommerce')));
		break;
	endswitch; ?>
	
	<div class="buttons">
        <?php if ( $style == 'traditional' ) : ?><a href="<?php the_permalink(); ?>" class="details"><?php echo yiw_get_option( 'shop_button_details_label' ) ?></a><?php endif; ?>
	    <a href="<?php echo $link ?>" data-product_id="<?php echo $product->id ?>" class="add-to-cart add_to_cart_button product_type_<?php echo $product->product_type ?>"><?php echo $label ?></a><?php
	?></div><?php

endif; 
?>