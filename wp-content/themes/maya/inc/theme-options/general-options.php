<?php         

global $yiw_skins;       

$yiw_options['general'] = array (      
	 
    /* =================== SKIN =================== */
    'responsive' => array(    
        array( 'name' => __('General Settings', 'yiw'),
        	   'type' => 'title'),
    
        array( 'name' => __('Activate responsive', 'yiw'),
        	   'type' => 'section',
               'effect' => 0),
        array( 'type' => 'open'),                     
         
        array( 'name' => __('Activate responsive', 'yiw'),
        	   'desc' => __('Select if you want to active or not the responsive', 'yiw'),
        	   'id' => 'responsive',
        	   'type' => 'on-off',
        	   'button' => __( 'Save', 'yiw' ),
               'std' => 1 ),     
        	
        array( 'type' => 'close')
    ),        
    /* =================== END SKIN =================== */
     
    /* =================== GENERAL =================== */
    'general' => array(    
        array( 'name' => __('General', 'yiw'),
               'type' => 'section'),
        array( 'type' => 'open'),          
        	
        array( 'name' => __('Layout theme', 'yiw'),
        	   'desc' => __('Select the general layout of the theme.', 'yiw'),
        	   'id' => 'theme_layout',
        	   'type' => 'select',
        	   'options' => array(
			   		'stretched' => __( 'Stretched', 'yiw' ),
			   		'boxed' => __( 'Boxed', 'yiw' ),
			   ),
        	   'std' => 'boxed' ),	             
            
        array( 'name' => __('Custom Favicon', 'yiw'),
               'desc' => __("A favicon is a 16x16 pixel icon that represents your site; paste the URL to a icon image that you want to use as the image. NOTE: it's not allowed the .ico extension", 'yiw'),
               'id' => 'favicon',
               'type' => 'upload',
               'std' => get_template_directory_uri() .'/favicon.ico'),        
            
        array( 'name' => __('Custom Style', 'yiw'),
               'desc' => __('You can write here your custom css, that will replace the default css.', 'yiw'),
               'id' => 'custom_style',
               'type' => 'textarea',
               'std' => ''),
               
            
        array( "name" => __("Date Format", 'yiw'),
               "desc" => __("Set the general date format of theme. Read <a href=\"http://codex.wordpress.org/Formatting_Date_and_Time\">Documentation on date formatting</a>", 'yiw'),
               "id" => "date_format",
               "type" => "text",
               "std" => "F j, Y" ),
               
        array( "name" => __("Map text", 'yiw'),
               "desc" => __("Set the text to show in the label of the map in the contact page.", 'yiw'),
               "id" => "contact_map_text",
               "type" => "text",
               "std" => __( 'Where we are? Find us in this great google map', 'yiw' ) ),        
            
        array( 'type' => 'close')
    ),        
    /* =================== END GENERAL =================== */
    
                                                 
    /* =================== HEADER =================== */
    'header' => array(
        array( 'name' => __('Header', 'yiw'),
               'type' => 'section'),
        array( 'type' => 'open'),        
                                    
        array( 'name' => __('Custom Logo', 'yiw'),
               'desc' => __('Want to use a custom image as logo?', 'yiw'),
               'id' => 'use_logo',     
               'type' => 'on-off',
               'std' => 0),
            
        array( 'name' => __('Logo URL', 'yiw'),
               'desc' => __('Enter the URL to your logo image', 'yiw'),
               'id' => 'logo',     
               'type' => 'upload',  
               'deps' => array(
                    'id' => 'use_logo',
                    'value' => 1
               ),
               'std' => ''),
            
        array( 'name' => __('Logo Description', 'yiw'),
               'desc' => __('Specify if you want the description below the logo', 'yiw'),
               'id' => 'logo_use_description',     
               'type' => 'on-off',
               'std' => 1),
        
        array( 'name' => __( 'Show Topbar', 'yiw'),
               'desc' => __( 'Choose if you want to show the topbar or not.', 'yiw'),
               'id' => 'show_topbar',
               'type' => 'on-off',
               'std' => 1),
        
        array( 'name' => __( 'Top bar content', 'yiw'),
               'desc' => __( 'Choose between static text or twitter slider', 'yiw'),
               'id' => 'topbar_content',
               'type' => 'select',
               'options' => array(
                    'static' => __( 'Static text', 'yiw' ),
                    'twitter' => __( 'Last tweets', 'yiw' )
               ),                     
               'std' => 'static' ),
            
        array( 'name' => __('Topbar text', 'yiw'),
               'desc' => __('Specify the text for the topbar', 'yiw'),
               'id' => 'topbar_text',     
               'type' => 'textarea',
               'deps' => array(
                    'id' => 'topbar_content',
                    'value' => 'static'
               ),
               'std' => '' ),
        
        array( 'name' => __('Twitter username', 'yiw'),
               'desc' => __('Specify twitter username for the last tweets in the topbar', 'yiw'),
               'id' => 'topbar_twitter_username',     
               'type' => 'text',
               'deps' => array(
                    'id' => 'topbar_content',
                    'value' => 'twitter'
               ),
               'std' => '' ),
               
        array( 'name' => __('Twitter items', 'yiw'),
               'desc' => __('Specify the number of tweets you want to show', 'yiw'),
               'id' => 'topbar_twitter_items',     
               'type' => 'text',
               'deps' => array(
                    'id' => 'topbar_content',
                    'value' => 'twitter'
               ),
               'std' => '5' ),
        
        array( 'name' => __('Interval between slides', 'yiw'),
               'desc' => __('Specify the seconds of interval between slides', 'yiw'),
               'id' => 'topbar_twitter_interval',
               'min' => 2,
               'max' => 10,     
               'type' => 'slider_control',
               'deps' => array(
                    'id' => 'topbar_content',
                    'value' => 'twitter'
               ),
               'std' => 5 ),
               
        array( 'name' => __( 'Hide login/logout', 'yiw' ),
               'desc' => __( 'Hide login/logout URL from the top bar', 'yiw'),
               'id' => 'topbar_login',
               'type' => 'on-off',  
               'std' => 0),
               
        array( 'name' => __( 'Hide register', 'yiw' ),
               'desc' => __( 'Hide register URL from the top bar. If you are using the WooCommerce plugin, you need to active the register also in Woocommerce -> Settings -> Customer Accounts -> Allow unregistered users to register from "My Account".', 'yiw'),
               'id' => 'topbar_register',
               'type' => 'on-off',     
               'std' => 1),
            
        array( 'name' => __('Show ribbon cart', 'yiw'),
               'desc' => __('Say if you want the ribbon of cart on topbar.', 'yiw'),
               'id' => 'show_topbar_cart_ribbon',     
               'type' => 'on-off',      
               'std' => 1 ),
            
        array( 'name' => __('Cart hover on ribbon', 'yiw'),
               'desc' => __('Say if you want the cart on hover of ribbon.', 'yiw'),
               'id' => 'topbar_cart_ribbon_hover',     
               'type' => 'on-off',      
               'std' => 0 ),
            
        array( 'name' => __('Topbar cart ribbon', 'yiw'),
               'desc' => __('Upload your custom image for the ribbon in topbar. <b>Upload in image size 112x95px</b>.', 'yiw'),
               'id' => 'topbar_cart_ribbon',     
               'type' => 'upload',
               'deps' => array(
                    'id' => 'show_topbar_cart_ribbon',
                    'value' => 1
               ),
               'std' => '' ),   
            
        array( 'name' => __('Show searchform', 'yiw'),
               'desc' => __('Say if you want the searchform in header.', 'yiw'),
               'id' => 'show_searchform_header',     
               'type' => 'on-off',      
               'std' => 1 ), 
            
        array( 'name' => __('What search', 'yiw'),
               'desc' => __('Say what you want to search using the searchform of header.', 'yiw'),
               'id' => 'show_searchform_post_type',     
               'type' => 'select', 
               'options' => array(
                    'any' => __( 'All', 'yiw' ),
                    'product' => __( 'Products', 'yiw' ),
                    'post' => __( 'Posts', 'yiw' ),
               ),     
               'std' => 'product' ),
/*
        array( 'name' => __('Active Logo Image', 'yiw'),
               'desc' => __('Set if you want to replace the "Title" and "description" options of header, with a logo image.', 'yiw'),
               'id' => 'show_logo', 
               'type' => 'on-off',
               'std' => ''),    */                

        array( 'name' => __('Header Color', 'yiw'),
               'desc' => __('Select the type of header background.', 'yiw'),
               'id' => 'header_bg_color',     
               'type' => 'color-picker',
               'std' => '' ),       
                          
        array( 'name' => __('Header Background', 'yiw'),
               'desc' => __('Select the type of header background.', 'yiw'),
               'id' => 'header_bg_type',     
               'type' => 'select',
               'options' => array(
                    'color-unit' => __( 'Color Unit', 'yiw' ),
                    'bg-image' => __( 'Image', 'yiw' )
               ),
               'std' => 'color-unit' ),      
            
        array( 'name' => __('Header Image Custom', 'yiw'),
               'desc' => __('Upload your background image.', 'yiw'),
               'id' => 'header_bg_image_custom',     
               'type' => 'upload',
               'deps' => array(
                    'id' => 'header_bg_type',
                    'value' => 'bg-image'
               ),
               'std' => '' ),    
            
        array( 'name' => __('Header Image Repeat', 'yiw'),
               'desc' => __('The repeat attribute of header image uploaded above.', 'yiw'),
               'id' => 'header_bg_image_custom_repeat',     
               'type' => 'select',
               'options' => array(
                    'repeat' => __( 'Repeat', 'yiw' ),
                    'repeat-x' => __( 'Repeat Horizontally', 'yiw' ),
                    'repeat-y' => __( 'Repeat Vertically', 'yiw' ),
                    'no-repeat' => __( 'No Repeat', 'yiw' ),
               ),
               'deps' => array(
                    'id' => 'header_bg_type',
                    'value' => 'bg-image'
               ),
               'std' => 'no-repeat' ),  
            
        array( 'name' => __('Header Image Position', 'yiw'),
               'desc' => __('The position attribute of header image uploaded above.', 'yiw'),
               'id' => 'header_bg_image_custom_position',     
               'type' => 'select',
               'options' => array(          
                    'center' => __( 'Center', 'yiw' ),
                    'top left' => __( 'Top left', 'yiw' ),
                    'top center' => __( 'Top center', 'yiw' ),
                    'top right' => __( 'Top right', 'yiw' ),
                    'bottom left' => __( 'Bottom left', 'yiw' ),
                    'bottom center' => __( 'Bottom center', 'yiw' ),
                    'bottom right' => __( 'Bottom right', 'yiw' ),
               ),
               'deps' => array(
                    'id' => 'header_bg_type',
                    'value' => 'bg-image'
               ),
               'std' => 'bottom center' ),  
            
//         array( 'name' => __('Logo Width', 'yiw'),
//                'desc' => __('Enter the width of logo, expressed in pixel. (Leave empty for default)', 'yiw'),
//                'id' => 'logo_width', 
//                'type' => 'text',
//                'std' => ''),
//             
//         array( 'name' => __('Logo Height', 'yiw'),
//                'desc' => __('Enter the height of logo, expressed in pixel. (Leave empty for default)', 'yiw'),
//                'id' => 'logo_height', 
//                'type' => 'text',
//                'std' => ''),
               
        array( 'name' => __('Header Opacity', 'yiw'),
               'desc' => __('Select the opacity of the header', 'yiw'),
               'id' => 'header_opacity',
               'type' => 'slider',
               'min' => 1,
               'max' => 100,
               'type' => 'slider_control',
               'std' => 1),
        
        array( 'type' => 'close')
    ),   
    /* =================== END portfolio =================== */       
    
                                                      
    /* =================== NEWSLETTER =================== */  
    'newsletter-form' => array(
        array( 'name' => __('Newsletter form', 'yiw'),
        	   'type' => 'section'),
        array( 'type' => 'open'),      
        	
        array( 'name' => __('Title', 'yiw'),
        	   'desc' => __('The title of this section, shown bolded.', 'yiw'),
        	   'id' => 'newsletter_form_title',
        	   'type' => 'text',
        	   'std' => 'Stay Updated:'), 
        	
        array( 'name' => __('Description', 'yiw'),
        	   'desc' => __('A description of this section, shown near the title.', 'yiw'),
        	   'id' => 'newsletter_form_description',
        	   'type' => 'text',
        	   'std' => 'subscribe our special newsletter'), 
        	
        array( 'name' => __('Technical information', 'yiw'),
        	   'desc' => __('The options below are for the configuration of the newsletter form. to make functional the form, you need to link it with an external services and you can do it configurating it with the options below.', 'yiw'),
        	   'type' => 'simple-text'),        
        	
        array( 'name' => __('Action', 'yiw'),
        	   'desc' => __('The page where make the request (&lt;form <strong>action=""</strong>&gt;).', 'yiw'),
        	   'id' => 'newsletter_form_action',
        	   'type' => 'text',
        	   'std' => ''),                
        	
        array( 'name' => __('Method of request', 'yiw'),
        	   'desc' => __('The method of the form request (&lt;form <strong>method="POST|GET"</strong>&gt;).', 'yiw'),
        	   'id' => 'newsletter_form_method',
        	   'type' => 'select',
        	   'options' => array(
                    'post' => 'POST',
                    'get' => 'GET'
               ),
        	   'std' => 'post'),
        	
        array( 'name' => __('Identification name of the "Email" field', 'yiw'),
        	   'desc' => __('Configure the identification name of the "Email" field, to allow the script to comunicate the value of this field to the external services (&lt;input <strong>name=""</strong>... /&gt;).', 'yiw'),
        	   'id' => 'newsletter_form_email',
        	   'type' => 'text',
        	   'std' => 'email'),
        	
        array( 'name' => __('Label of "Email" field', 'yiw'),
        	   'desc' => __('The label of the "Email" field.', 'yiw'),
        	   'id' => 'newsletter_form_label_email',
        	   'type' => 'text',
        	   'std' => __( 'Your email', 'yiw' )),
        	
        array( 'name' => __('Label of "Submit" button', 'yiw'),
        	   'desc' => __('The label of the "Submit" button.', 'yiw'),
        	   'id' => 'newsletter_form_label_submit',
        	   'type' => 'text',
        	   'std' => __( 'Subscribe', 'yiw' )),
        	
        array( 'name' => __('Hidden fields', 'yiw'),
        	   'desc' => __('Optional: In this option you can set the hidden fields, to write in serializate way (es. field1=value1&field2=value2&field3=value3&...&fieldN=valueN).', 'yiw'),
        	   'id' => 'newsletter_form_label_hidden_fields',
        	   'type' => 'text',
        	   'std' => ''),
        
        array( 'type' => 'close')   
    ),
    /* =================== END NEWSLETTER =================== */ 
                                                 
                                                      
    /* =================== FOOTER =================== */
    'footer' => array(
        array( 'name' => __('Footer', 'yiw'),
               'type' => 'section'),
        array( 'type' => 'open'),       
         
        array( 'name' => __('Footer Type', 'yiw'),
               'desc' => __('Select the footer type for the theme', 'yiw'),
               'id' => 'footer_type',
               'type' => 'select',
               'options' => array(
                    'normal' => __( 'Two Columns Footer', 'yiw' ), 
                    'centered' => __( 'Centered Footer', 'yiw' ),
                    'big-normal' => __('Big Footer + Two Columns', 'yiw' ),
                    'big-centered' => __('Big Footer + Centered', 'yiw' )
                ),
               'std' => 'normal'),  
            
        array( 'name' => __('Big Footer Widget Areas', 'yiw'),
               'desc' => __('Select the number of widget area you\'d like to use.<br /><strong>Note: It will work only if you\'ve chosen one of Big Footer types above</strong>', 'yiw'),
               'id' => 'footer_rows',
               'type' => 'slider',
               'min' => 1,
               'max' => 4,
               'type' => 'slider_control',
               'std' => 1),  

        array( 'name' => __('Number of widgets in each footer Widget Area', 'yiw'),
               'desc' => __('Select the number of widget you\'d like to use in each footer widget area<br /><strong>Note: It will work only if you\'ve chosen one of Big Footer types above</strong>', 'yiw'),
               'id' => 'footer_columns',
               'type' => 'slider',
               'min' => 1,
               'max' => 4,
               'type' => 'slider_control',
               'std' => 4),  

        array( 'name' => __('Footer centered text', 'yiw'),
               'desc' => __('Enter text used in <strong>centered footer</strong>. It can be HTML.', 'yiw'),
               'id' => 'footer_text_centered',
               'type' => 'textarea',
               'std' => '' ),
            
        array( 'name' => __('Footer copyright text Left', 'yiw'),
               'desc' => __('Enter text used in the left side of the footer. It can be HTML. <strong>NB: not figured on "centered footer"</strong>', 'yiw'),
               'id' => 'copyright_text_left',
               'type' => 'textarea',
               'std' => 'Copyright <a href="%site_url%"><strong>%name_site%</strong></a> 2012' ),
            
        array( 'name' => __('Footer copyright text Right', 'yiw'),
               'desc' => __('Enter text used in the right side of the footer. It can be HTML. <strong>NB: not figured on "centered footer"</strong>', 'yiw'),
               'id' => 'copyright_text_right',
               'type' => 'textarea',
               'std' => 'Powered by <a href="http://www.yourinspirationweb.com/en"><strong>Your Inspiration Web</strong></a>'),
            
        array( 'name' => __('Google Analytics Code', 'yiw'),
               'desc' => __('You can paste your Google Analytics or other tracking code in this box. This will be automatically added to the footer.', 'yiw'),
               'id' => 'ga_code',
               'type' => 'textarea',
               'std' => ''),
         
        array( 'type' => 'close')   
    ),           
    /* =================== END FOOTER =================== */               
    
                                                      
    /* =================== SHOP =================== */
    'shop' => array(
        array( 'name' => __('Shop', 'yiw'),
        	   'type' => 'section'),
        array( 'type' => 'open'),     
         
        array( 'desc' => '<strong>' . __('Products page', 'yiw') . '</strong>',
        	   'type' => 'simple-text'),        
         
        array( 'name' => __('Number of products to show', 'yiw'),
        	   'desc' => __('Select the number of products to show on the pages. Set 0 to show all products.', 'yiw'),
        	   'id' => 'shop_products_per_page',
        	   'type' => 'slider_control',
        	   'min' => 0,
        	   'max' => 100,
        	   'std' => 8),                 
         
        array( 'name' => __('Style for products list', 'yiw'),
        	   'desc' => __('Select the style for the products list.', 'yiw'),
        	   'id' => 'shop_products_style',
        	   'type' => 'select',
        	   'options' => array(
                    'ribbon' => __( 'Ribbon', 'yiw' ),
                    'traditional' => __( 'Traditional', 'yiw' ), 
               ),
        	   'std' => 'ribbon'),  
         
        array( 'name' => __('Title position', 'yiw'),
        	   'desc' => __('Select the position of the title. You can say if put it inside the thumbnail or below the image.', 'yiw'),
        	   'id' => 'shop_title_position',
        	   'type' => 'select',
        	   'options' => array(
                    'inside-thumb' => __( 'Inside the thumbnail', 'yiw' ),
                    'below-thumb' => __( 'Below the thumbnail', 'yiw' ),
               ),                          
               'deps' => array(
                    'id' => 'shop_products_style',
                    'value' => 'traditional'
               ),
        	   'std' => 'inside-thumb'),    
         
        array( 'name' => __('Border thumbnail', 'yiw'),
        	   'desc' => __('Select if you want to show a border on thumbnail.', 'yiw'),
        	   'id' => 'shop_border_thumbnail',
        	   'type' => 'on-off',                         
               'deps' => array(
                    'id' => 'shop_products_style',
                    'value' => 'traditional'
               ),
        	   'std' => 1),   
         
        array( 'name' => __('Shadow thumbnail', 'yiw'),
        	   'desc' => __('Select if you want to show a shadow on thumbnail.', 'yiw'),
        	   'id' => 'shop_shadow_thumbnail',
        	   'type' => 'on-off',                      
               'deps' => array(
                    'id' => 'shop_products_style',
                    'value' => 'traditional'
               ),
        	   'std' => 1),  
         
        array( 'name' => __('Show name', 'yiw'),
        	   'desc' => __('Select if you want to show a the price on the products list.', 'yiw'),
        	   'id' => 'shop_show_name',
        	   'type' => 'on-off',   
        	   'std' => 1),  
         
        array( 'name' => __('Show price', 'yiw'),
        	   'desc' => __('Select if you want to show a the price on the products list.', 'yiw'),
        	   'id' => 'shop_show_price',
        	   'type' => 'on-off',   
        	   'std' => 1),  
         
        array( 'name' => __('Show button details', 'yiw'),
        	   'desc' => __('Select if you want to show the button for product details.', 'yiw'),
        	   'id' => 'shop_show_button_details',
        	   'type' => 'on-off',                       
               'deps' => array(
                    'id' => 'shop_products_style',
                    'value' => 'traditional'
               ),
        	   'std' => 1),  
         
        array( 'name' => __('Show button add to cart', 'yiw'),
        	   'desc' => __('Select if you want to show the purchase button.', 'yiw'),
        	   'id' => 'shop_show_button_add_to_cart',
        	   'type' => 'on-off',  
        	   'std' => 1),  
         
        array( 'name' => __('Label button details', 'yiw'),
        	   'desc' => __('Select the text for the button for product details.', 'yiw'),
        	   'id' => 'shop_button_details_label',
        	   'type' => 'text',                         
               'deps' => array(
                    'id' => 'shop_products_style',
                    'value' => 'traditional'
               ),
        	   'std' => strtoupper( __( 'Details', 'yiw' ))),  
         
        array( 'name' => __('Custom for add to cart ribbon', 'yiw'),
        	   'desc' => __('Upload your custom ribbon image for the add to cart button - Leave empty to show the default one.', 'yiw'),
        	   'id' => 'shop_products_ribbon',
        	   'type' => 'upload',                      
               'deps' => array(
                    'id' => 'shop_products_style',
                    'value' => 'ribbon'
               ),
        	   'std' => ''), 
         
        array( 'name' => __('Custom for add to cart ribbon, when added to cart', 'yiw'),
        	   'desc' => __('Upload your custom ribbon image for the add to cart button, after you added to cart - Leave empty to show the default one.', 'yiw'),
        	   'id' => 'shop_products_ribbon_added',
        	   'type' => 'upload',                      
               'deps' => array(
                    'id' => 'shop_products_style',
                    'value' => 'ribbon'
               ),
        	   'std' => ''),  
         
        array( 'name' => __('Label button add to cart', 'yiw'),
        	   'desc' => __('Select the text for the purchase button.', 'yiw'),
        	   'id' => 'shop_button_addtocart_label',
        	   'type' => 'text',
        	   'std' => strtoupper( __( 'Add to cart', 'yiw' ))), 
         
        array( 'desc' => '<strong>' . __('Category list', 'yiw') . '</strong>',
        	   'type' => 'simple-text'),         
         
        array( 'name' => __('Title position', 'yiw'),
        	   'desc' => __('Select the position title in the categories list.', 'yiw'),
        	   'id' => 'shop_title_position_categories_page',
        	   'type' => 'select',
        	   'options' => array(
                   'inside-thumb' => __( 'Inside thumbnail', 'yiw' ),
                   'below-thumb' => __( 'Below thumbnail', 'yiw' ),
               ),
        	   'std' => 'inside-thumb'),         
         
        array( 'name' => __('Show shadow', 'yiw'),
        	   'desc' => __('Select if you want the shadow below the thumbnail in categories list.', 'yiw'),
        	   'id' => 'shop_show_shadow_categories_page',
        	   'type' => 'on-off',
        	   'std' => 1),       
         
        array( 'desc' => '<strong>' . __('Product detail page', 'yiw') . '</strong>',
        	   'type' => 'simple-text'),         
         
        array( 'name' => __('Show the shop sidebar', 'yiw'),
        	   'desc' => __('Select the layout for the single page.', 'yiw'),
        	   'id' => 'shop_layout_page_single',
        	   'type' => 'select',
        	   'options' => array(
                   'sidebar-right' => __( 'Sidebar right', 'yiw' ),
                   'sidebar-left' => __( 'Sidebar left', 'yiw' ),
                   'sidebar-no' => __( 'No Sidebar', 'yiw' ),
               ),
        	   'std' => 'sidebar-no'),         
         
        array( 'name' => __('Show price', 'yiw'),
        	   'desc' => __('Select if you want to show the price, on the product detail page.', 'yiw'),
        	   'id' => 'shop_show_price_single_page',
        	   'type' => 'on-off',
        	   'std' => 1),       
         
        array( 'name' => __('Show button add to cart', 'yiw'),
        	   'desc' => __('Select if you want to show the purchase button, on the product detail page.', 'yiw'),
        	   'id' => 'shop_show_button_add_to_cart_single_page',
        	   'type' => 'on-off',
        	   'std' => 1),
              
        array( 'name' => __('Show [share] shortcode', 'yiw'),
        	   'desc' => __('Select if you want to show the socials, on the product detail page.', 'yiw'),
        	   'id' => 'shop_show_share_socials',
        	   'type' => 'on-off',
        	   'std' => 0),
        
        array( 'name' => __('[share] title', 'yiw'),
        	   'desc' => __('The title before the socials icons, on the product detail page.', 'yiw'),
        	   'id' => 'shop_share_title',
        	   'type' => 'text',
               'deps' => array(
                    'id' => 'shop_show_share_socials',
                    'value' => 1
               ),
        	   'std' => __( 'love it, share it', 'yiw' ) ), 
        
        array( 'name' => __('Socials [share] shortcode', 'yiw'),
        	   'desc' => __('Select which socials to show, on the product detail page.', 'yiw'),
        	   'id' => 'shop_share_socials',
        	   'type' => 'text',
               'deps' => array(
                    'id' => 'shop_show_share_socials',
                    'value' => 1
               ),
        	   'std' => 'facebook, twitter, pinterest, google, bookmark'),    
         
        array( 'desc' => '<strong>' . __('Product slider shortcode', 'yiw') . '</strong>',
        	   'type' => 'simple-text'),   
         
        array( 'name' => __('Active autoplay', 'yiw'),
        	   'desc' => __('Say if you want to active the autoplay in the product sliders.', 'yiw'),
        	   'id' => 'shop_product_slider_autoplay',
        	   'type' => 'on-off',
        	   'std' => 1),    
         
        array( 'name' => __('Interval autoplay (s)', 'yiw'),
        	   'desc' => __('Set the interval for the autoplay.', 'yiw'),
        	   'id' => 'shop_product_slider_interval',
               'min' => 1,
               'max' => 10,
               'step' => 1,
               'type' => 'slider_control',
        	   'deps' => array(
                  'id' => 'shop_product_slider_autoplay',
                  'value' => 1
               ),
        	   'std' => 6),          
                                          
        array( 'type' => 'close')   
    ),           
    /* =================== END SHOP =================== */
    
    /* =================== BLOG =================== */
    'blog' => array(
        array( 'name' => __('Blog Settings', 'yiw'),
               'type' => 'section'),
        array( 'type' => 'open'),         
        
        array( 'name' => __('Show post date', 'yiw'),
               'desc' => __('Select if you want to show the date for each post.', 'yiw'),
               'id' => 'blog_show_date',
               'type' => 'on-off',
               'std' => 1 ),
        
        array( 'name' => __('Show post categories', 'yiw'),
               'desc' => __('Select if you want to show the categories for each post.', 'yiw'),
               'id' => 'blog_show_categories',
               'type' => 'on-off',
               'std' => 1 ),
               
        array( 'name' => __('Show post author', 'yiw'),
               'desc' => __('Select if you want to show the author for each post.', 'yiw'),
               'id' => 'blog_show_author',
               'type' => 'on-off',
               'std' => 1 ),
    
        array( 'name' => __('Show post number of comments', 'yiw'),
               'desc' => __('Select if you want to show the number of comments for each post.', 'yiw'),
               'id' => 'blog_show_comments',
               'type' => 'on-off',
               'std' => 1 ),
               
        array( 'name' => __('Show post social buttons', 'yiw'),
               'desc' => __('Select if you want to show the social buttons for each post.', 'yiw'),
               'id' => 'blog_show_socials',
               'type' => 'on-off',
               'std' => 1 ),
               
        array( 'name' => __('Blog Type', 'yiw'),
               'desc' => __('Say the layout for your blog page.', 'yiw'),
               'id' => 'blog_type',
               'type' => 'select',
               'options' => array( 'big' => __('Big Thumbnail', 'yiw'), 'small' => __('Small Thumbnail', 'yiw'), 'elegant' => __('Elegant', 'yiw') ),
               'std' => 'big'),
/*
        array( 'name' => __('Items', 'yiw'),
               'desc' => __('Select how many items you want to show on Blog Page', 'yiw'),
               'id' => 'posts_per_page',
               'min' => 1,
               'max' => 50,
               'type' => 'slider_control',
               'std' => 10),          
*/
        array( 'name' => __('Exclude categories', 'yiw'),
               'desc' => __('Select witch categories you want exlude from blog.', 'yiw'),
               'id' => 'blog_cats_exclude',
               'type' => 'cat',
               'cols' => 2,          // number of columns for multickecks
               'heads' => array(__('Blog Page', 'yiw'), __('List cat. sidebar', 'yiw')),  // in case of multi columns, specific the head for each column
               'std' => ''),          
/*
        array( 'name' => __('Show post date', 'yiw'),
               'desc' => __('Select if you want to show the date in your posts.', 'yiw'),
               'id' => 'blog_show_date',
               'type' => 'on-off',
               'std' => 1 ),
*/
/*
        array( 'name' => __('Show read more button', 'yiw'),
               'desc' => __('Select if you want to show the read more button below the post.', 'yiw'),
               'id' => 'blog_show_read_more',
               'type' => 'on-off',
               'std' => __( 1, 'yiw' ) ),
*/
        array( 'name' => __('Read more text', 'yiw'),
               'desc' => __('Write what you want to show on more link', 'yiw'),
               'id' => 'blog_read_more_text',
               'type' => 'text',
               'std' => '-> Read more' ),
               
/*
        array( 'name' => __('Featured Images Alignment', 'yiw'),
               'desc' => __('Specific the featured images alignment', 'yiw'),
               'id' => 'blog_image_align',
               'type' => 'select',
               'options' => array(
                    'alignleft' => 'Left', 
                    'alignright' => 'Right', 
                    'aligncenter' => 'Center'
                ),
               'std' => 'aligncenter'),
            
        array( 'name' => __('Featured Images Size', 'yiw'),
               'desc' => __('Specific the featured images size', 'yiw'),
               'id' => 'blog_image_size',
               'type' => 'select',
               'options' => array(
                    'post-thumbnail' => 'Standard', 
                    'thumbnail' => 'Thumbnail', 
                    'medium' => 'Medium',
                    'large' => 'Large',
                    'custom' => 'Custom'
                ),
               'std' => 'post-thumbnail'),
            
        array( 'name' => __('Featured Images Width', 'yiw'),
               'desc' => __('Specific the featured images width, <strong>if you have selected custom size on option above.</strong>', 'yiw'),
               'id' => 'blog_image_width',
               'type' => 'text',
               'std' => ''),
            
        array( 'name' => __('Featured Images Height', 'yiw'),
               'desc' => __('Specific the featured images height, <strong>if you have selected custom size on option above.</strong>', 'yiw'),
               'id' => 'blog_image_height',
               'type' => 'text',
               'std' => ''),
*/
        array( 'type' => 'close')   
    ),
    /* =================== END BLOG =================== */       
     
    /* =================== portfolio =================== */
    'portfolio' => array(
    
        array( 'name' => __('portfolio', 'yiw'),
               'type' => 'section'),
        array( 'type' => 'open'),


        array( 'name' => __('Default layout page', 'yiw'),
               'desc' => __('Define the default layout to use for the portfolio pages, as single pages, categories page, etc..', 'yiw'),
               'id' => 'portfolio_layout_page',
               'type' => 'select',
               'options' => array(
                    'sidebar-left' => __( 'Sidebar Left', 'yiw' ),
                    'sidebar-right' => __( 'Sidebar Right', 'yiw' ),
                    'sidebar-no' => __( 'No Sidebar', 'yiw' ),
               ),
               'std' => 'sidebar-right'),     

        array( 'name' => __('Show filters', 'yiw'),
               'desc' => __('Say if you want to show the filters navigation in the gallery page.', 'yiw'),
               'id' => 'portfolio_show_filters',
               'type' => 'on-off',
               'std' => 1 ),       
               
        array( 'name' => __('Thumbnail click', 'yiw'),
               'desc' => __('Select what you want to do when you click in the item thumbnail (not valid for the portfolio filterable).', 'yiw'),
               'id' => 'portfolio_thumbnail_click',
               'type' => 'select',
               'options' => array(
                    'lightbox' => __( 'Open full image in a lightbox', 'yiw' ),
                    'item-page' => __( 'Go to item single page', 'yiw' ),
                    'nothing' => __( "Don't do nothing", 'yiw' ),
               ),
               'std' => 'lightbox'),  
               
        array( 'name' => __('Link to single page in Portfolio Filterable', 'yiw'),
               'desc' => __('Select if you want to show the icon to go to the item single page, when you pass over the thumbnail in the portfolio filterable.', 'yiw'),
               'id' => 'portfolio_details_icon',
               'type' => 'on-off',
               'std' => 1),
        
        array( 'name' => __('Show "View Project" button', 'yiw'),
               'desc' => __('Select if you want to show the "View Project" button in 3 columns and big image portfolios.', 'yiw'),
               'id' => 'portfolio_show_view_project',
               'type' => 'on-off',
               'std' => 1),
            
        array( 'name' => __('Lightbox Skin', 'yiw'),
               'desc' => __('Specific what skin you want for videos and images lightbox.', 'yiw'),
               'id' => 'portfolio_skin_lightbox',
               'type' => 'select',
               'options' => array(
                    'pp_default' => 'Default', 
                    'facebook' => 'Facebook', 
                    'light_rounded' => 'Light rounded', 
                    'dark_rounded' => 'Dark rounded semi-transparent',
                    'light_square' => 'Light square',
                    'dark_square' => 'Dark square semi-transparent'
                ),
               'std' => 'pp_default'),   
        
        array( 'type' => 'close')
    ),   
    /* =================== END portfolio =================== */

    /* =================== gallery =================== */
    'gallery' => array(
    
        array( 'name' => __('Gallery', 'yiw'),
               'type' => 'section'),
        array( 'type' => 'open'),  

        array( 'name' => __('Show filters', 'yiw'),
               'desc' => __('Say if you want to show the filters navigation in the gallery page.', 'yiw'),
               'id' => 'gallery_show_filters',
               'type' => 'on-off',
               'std' => 1 ),   
               
        array( 'name' => __('Link to item single page', 'yiw'),
               'desc' => __('Select if you want to show the icon to go to the item single page, when you pass over the thumbnail.', 'yiw'),
               'id' => 'gallery_details_icon',
               'type' => 'on-off',
               'std' => 1),   
        
        array( 'type' => 'close')
    ),   
    /* =================== END services =================== */
 
);   
?>