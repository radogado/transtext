<?php	

/*
To add custom PHP functions to the theme, create a new 'custom-functions.php' file in the theme folder. 
They will be added to the theme automatically.
*/

/**
 * Enqueue Scripts & Stylesheets
 * @package themify
 ***************************************************************************/
function themify_theme_enqueue_scripts(){

	///////////////////
	//Enqueue styles
	///////////////////
	
	//Themify base styling
	wp_enqueue_style( 'theme-style', get_stylesheet_uri(), array(), wp_get_theme()->display('Version'));
	
	//Themify Media Queries CSS
	wp_enqueue_style( 'themify-media-queries', THEME_URI . '/media-queries.css');	

	//User stylesheet
	if(is_file(TEMPLATEPATH . "/custom_style.css"))
		wp_enqueue_style( 'custom-style', THEME_URI . '/custom_style.css');
	
	//prettyPhoto styles
	wp_enqueue_style ( 'pretty-photo', THEMIFY_URI . '/css/lightbox.css');

	///////////////////
	//Enqueue scripts
	///////////////////
	
	//prettyPhoto, lightbox script
	wp_enqueue_script( 'pretty-photo', THEMIFY_URI . '/js/lightbox.js', array('jquery'), false, true );
	
	//slider
	wp_enqueue_script( 'jquery-slider', THEME_URI . '/js/jquery.slider.js', array('jquery'), false, true );	
	
	//Themify internal scripts
	wp_enqueue_script( 'theme-script',	THEME_URI . '/js/themify.script.js', array('jquery'), false, true );
	
	//Inject variable values in gallery script
	wp_localize_script( 'theme-script', 'themifyScript', array(
			'overlayTheme' => apply_filters('themify_overlay_gallery_theme', 'pp_default')
		)
	);
	
	//WordPress internal script to move the comment box to the right place when replying to a user
	if ( is_single() || is_page() ) wp_enqueue_script( 'comment-reply' );

}
add_action('wp_enqueue_scripts', 'themify_theme_enqueue_scripts');

/**
 * Add JavaScript files if IE version is lower than 9
 * @package themify
 * @since 1.2.5
 */
function themify_ie_enhancements(){
	echo '
	<!-- media-queries.js -->
	<!--[if lt IE 9]>
		<script src="' . THEME_URI . '/js/respond.js"></script>
	<![endif]-->
	
	<!-- html5.js -->
	<!--[if lt IE 9]>
		<script src="'.themify_https_esc('http://html5shim.googlecode.com/svn/trunk/html5.js').'"></script>
	<![endif]-->
	';
}
add_action( 'wp_head', 'themify_ie_enhancements' );

/**
 * Add viewport tag for responsive layouts
 * @package themify
 * @since 1.2.5
 */
function themify_viewport_tag(){
	echo "\n".'<meta name="viewport" content="width=100%, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">'."\n";
}
add_action( 'wp_head', 'themify_viewport_tag' );
	
/* 	Custom Post Types
/***************************************************************************/
	
	///////////////////////////////////////
	// Setup Write Panel Options
	///////////////////////////////////////
	
	// Slider Post Type
	register_post_type('slider', array(
			'label' => __('Slider', 'themify'),
			'singular_label' => __('Slider', 'themify'),
			'description' => "",
			'menu_position' => 5,
			'public' => true,
			'show_ui' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'rewrite' => false,
			'query_var' => false,
			'supports' => array('title', 'editor', 'author', 'custom-fields')
		));
	
	// Highlights Post Type
	register_post_type('highlights', array(
			'label' => __('Highlights', 'themify'),
			'singular_label' => __('Highlights', 'themify'),
			'description' => "",
			'menu_position' => 5,
			'public' => true,
			'show_ui' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'rewrite' => false,
			'query_var' => false,
			'supports' => array('title', 'editor', 'author', 'custom-fields')
		));


/**
 * Make IE behave like a standards-compliant browser 
 */
function themify_ie_standards_compliant() {
	echo '
	<!--[if lt IE 9]>
	<script src="'.themify_https_esc('http://s3.amazonaws.com/nwapi/nwmatcher/nwmatcher-1.2.5-min.js').'"></script>
	<script type="text/javascript" src="'.themify_https_esc('http://cdnjs.cloudflare.com/ajax/libs/selectivizr/1.0.2/selectivizr-min.js').'"></script> 
	<![endif]-->
	';
}
add_action('wp_head', 'themify_ie_standards_compliant');

/* Custom Write Panels
/***************************************************************************/

	///////////////////////////////////////
	// Setup Write Panel Options
	///////////////////////////////////////
	
	// Post Meta Box Options
	$post_meta_box_options = array(
	// Layout
	array(
		  "name" 		=> "layout",	
		  "title" 		=> __('Single Layout', 'themify'), 	
		  "description" => "", 				
		  "type" 		=> "layout",			
		'show_title' => true,
		  "meta"		=> array(
					array("value" => "default", "img" => "images/layout-icons/default.png", "selected" => true, 'title' => __('Default', 'themify')),

					array('value' => 'sidebar1', 'img' => 'images/layout-icons/sidebar1.png', 'title' => __('Sidebar Right', 'themify')),
					array('value' => 'sidebar1 sidebar-left', 'img' => 'images/layout-icons/sidebar1-left.png', 'title' => __('Sidebar Left', 'themify')),
					array('value' => 'sidebar-none', 'img' => 'images/layout-icons/sidebar-none.png', 'title' => __('No Sidebar ', 'themify'))
				)
		),
   	// Post Image
	array(
		  "name" 		=> "post_image",
		  "title" 		=> __('Featured Image', 'themify'),
		  "description" => '',
		  "type" 		=> "image",
		  "meta"		=> array()
		),
   	// Featured Image Size
	array(
		'name'	=>	'feature_size',
		'title'	=>	__('Image Size', 'themify'),
		'description' => __('Image sizes can be set at <a href="options-media.php">Media Settings</a> and <a href="admin.php?page=regenerate-thumbnails">Regenerated</a>', 'themify'),
		'type'		 =>	'featimgdropdown'
		),
	// Image Width
	array(
		  "name" 		=> "image_width",	
		  "title" 		=> __('Image Width', 'themify'), 
		  "description" => "", 				
		  "type" 		=> "textbox",			
		  "meta"		=> array("size"=>"small")			
		),
	// Image Height
	array(
		  "name" 		=> "image_height",	
		  "title" 		=> __('Image Height', 'themify'), 
		  "description" => __('Enter height = 0 to disable vertical cropping with img.php enabled', 'themify'), 				
		  "type" 		=> "textbox",			
		  "meta"		=> array("size"=>"small")			
		),
	// Hide Post Title
	array(
		  "name" 		=> "hide_post_title",	
		  "title" 		=> __('Hide Post Title', 'themify'), 	
		  "description" => "", 				
		  "type" 		=> "dropdown",			
		  "meta"		=> array(
		  						array("value" => "default", "name" => "", "selected" => true),
								array("value" => "yes", 'name' => __('Yes', 'themify')),
								array("value" => "no",	'name' => __('No', 'themify'))
							)			
		),
	// Unlink Post Title
	array(
		  "name" 		=> "unlink_post_title",	
		  "title" 		=> __('Unlink Post Title', 'themify'), 	
		  "description" => __('Unlink post title (it will display the post title without link)', 'themify'), 				
		  "type" 		=> "dropdown",			
		  "meta"		=> array(
		  						array("value" => "default", "name" => "", "selected" => true),
								array("value" => "yes", 'name' => __('Yes', 'themify')),
								array("value" => "no",	'name' => __('No', 'themify'))
							)			
		),

	// Hide Post Meta
	array(
		  "name" 		=> "hide_post_meta",	
		  "title" 		=> __('Hide Post Meta', 'themify'), 	
		  "description" => "", 				
		  "type" 		=> "dropdown",			
		  "meta"		=> array(
		  						array("value" => "default", "name" => "", "selected" => true),
								array("value" => "yes", 'name' => __('Yes', 'themify')),
								array("value" => "no",	'name' => __('No', 'themify'))
							)
		),
	// Hide Post Date
	array(
		  "name" 		=> "hide_post_date",	
		  "title" 		=> __('Hide Post Date', 'themify'), 	
		  "description" => "", 				
		  "type" 		=> "dropdown",			
		  "meta"		=> array(
		  						array("value" => "default", "name" => "", "selected" => true),
								array("value" => "yes", 'name' => __('Yes', 'themify')),
								array("value" => "no",	'name' => __('No', 'themify'))
							)
		),
	// Hide Post Image
	array(
		  "name" 		=> "hide_post_image",	
		  "title" 		=> __('Hide Featured Image', 'themify'), 	
		  "description" => "", 				
		  "type" 		=> "dropdown",			
		  "meta"		=> array(
		  						array("value" => "default", "name" => "", "selected" => true),
								array("value" => "yes", 'name' => __('Yes', 'themify')),
								array("value" => "no",	'name' => __('No', 'themify'))
							)			
		),
		// Unlink Post Image
	array(
		  "name" 		=> "unlink_post_image",	
		  "title" 		=> __('Unlink Featured Image', 'themify'), 	
		  "description" => __('Display the Featured Image without link', 'themify'), 				
		  "type" 		=> "dropdown",			
		  "meta"		=> array(
		  						array("value" => "default", "name" => "", "selected" => true),
								array("value" => "yes", 'name' => __('Yes', 'themify')),
								array("value" => "no",	'name' => __('No', 'themify'))
							)			
		),
	// External Link
	array(
		  "name" 		=> "external_link",	
		  "title" 		=> __('External Link', 'themify'), 	
		  "description" => __('Link Featured Image to external URL', 'themify'), 				
		  "type" 		=> "textbox",			
		  "meta"		=> array()			
		),
	// Lightbox Link
	array(
		  "name" 		=> "lightbox_link",	
		  "title" 		=> __('Lightbox Link', 'themify'), 
		  "description" => __('Link Featured Image to lightbox image, video or external iframe (<a href="http://themify.me/docs/lightbox">learn more</a>)', 'themify'), 				
		  "type" 		=> "textbox",			
		  "meta"		=> array()			
		)
	);
								
	
	// Page Meta Box Options
	$page_meta_box_options = array(
  	// Page Layout
	array(
		  "name" 		=> "page_layout",
		  "title"		=> __('Sidebar Option', 'themify'),
		  "description"	=> "",
		  "type"		=> "layout",
			'show_title' => true,
		  "meta"		=> array(
		  						array("value" => "default", "img" => "images/layout-icons/default.png", "selected" => true, 'title' => __('Default', 'themify')),
								
								 array('value' => 'sidebar1', 'img' => 'images/layout-icons/sidebar1.png', 'title' => __('Sidebar Right', 'themify')),
								 array('value' => 'sidebar1 sidebar-left', 'img' => 'images/layout-icons/sidebar1-left.png', 'title' => __('Sidebar Left', 'themify')),
								 array('value' => 'sidebar-none', 'img' => 'images/layout-icons/sidebar-none.png', 'title' => __('No Sidebar ', 'themify'))
								 )
		),
	// Hide page title
	array(
		  "name" 		=> "hide_page_title",
		  "title"		=> __('Hide Page Title', 'themify'),
		  "description"	=> "",
		  "type" 		=> "dropdown",			
		  "meta"		=> array(
		  						array("value" => "default", "name" => "", "selected" => true),

								 array("value" => "yes", 'name' => __('Yes', 'themify')),
								 array("value" => "no",	'name' => __('No', 'themify'))
								 )	
		),
   // Query Category
	array(
		  "name" 		=> "query_category",
		  "title"		=> __('Query Category', 'themify'),
		  "description"	=> __('Select a category or enter multiple category IDs (eg. 2,5,6). Enter 0 to display all category.', 'themify'),
		  "type"		=> "query_category",
		  "meta"		=> array()
		),
	// Section Categories
	array(
		  "name" 		=> "section_categories",	
		  "title" 		=> __('Section Categories', 'themify'), 	
		  "description" => __('Display multiple query categories separately', 'themify'), 				
		  "type" 		=> "dropdown",			
		  "meta"		=> array(
		  						array("value" => "default", "name" => "", "selected" => true),

								 array("value" => "yes", 'name' => __('Yes', 'themify')),
								 array("value" => "no",	'name' => __('No', 'themify'))
								 )			
		),
	// Post Layout
	array(
		  "name" 		=> "layout",
		  "title"		=> __('Query Post Layout', 'themify'),
		  "description"	=> "",
		  "type"		=> "layout",
			'show_title' => true,
		  "meta"		=> array(
								 array('value' => 'list-post', 'img' => 'images/layout-icons/list-post.png', 'selected' => true, 'title' => __('List Post', 'themify')),
								 array('value' => 'grid4', 'img' => 'images/layout-icons/grid4.png', 'title' => __('Grid 4', 'themify')),
								 array('value' => 'grid3', 'img' => 'images/layout-icons/grid3.png', 'title' => __('Grid 3', 'themify')),
								 array('value' => 'grid2', 'img' => 'images/layout-icons/grid2.png', 'title' => __('Grid 2', 'themify')),
								 array('value' => 'list-large-image', 'img' => 'images/layout-icons/list-large-image.png', 'title' => __('List Large Image', 'themify')),
								 array('value' => 'list-thumb-image', 'img' => 'images/layout-icons/list-thumb-image.png', 'title' => __('List Thumb Image', 'themify')),
								 array('value' => 'grid2-thumb', 'img' => 'images/layout-icons/grid2-thumb.png', 'title' => __('Grid 2 Thumb', 'themify'))
								 )
		),
	// Posts Per Page
	array(
		  "name" 		=> "posts_per_page",
		  "title"		=> __('Posts per page', 'themify'),
		  "description"	=> "",
		  "type"		=> "textbox",
		  "meta"		=> array("size" => "small")
		),
	
	// Display Content
	array(
		  "name" 		=> "display_content",
		  "title"		=> __('Display Content', 'themify'),
		  "description"	=> "",
		  "type"		=> "dropdown",
		  "meta"		=> array(
								 array('name' => __('Full Content', 'themify'),"value"=>"content","selected"=>true),
		  						 array('name' => __('Excerpt', 'themify'),"value"=>"excerpt"),
								 array('name' => __('None', 'themify'),"value"=>"none")
								 )
		),
	// Featured Image Size
	array(
		'name'	=>	'feature_size_page',
		'title'	=>	__('Image Size', 'themify'),
		'description' => __('Image sizes can be set at <a href="options-media.php">Media Settings</a> and <a href="admin.php?page=regenerate-thumbnails">Regenerated</a>', 'themify'),
		'type'		 =>	'featimgdropdown'
		),
	// Image Width
	array(
		  "name" 		=> "image_width",	
		  "title" 		=> __('Image Width', 'themify'), 
		  "description" => "", 				
		  "type" 		=> "textbox",			
		  "meta"		=> array("size"=>"small")			
		),
	// Image Height
	array(
		  "name" 		=> "image_height",	
		  "title" 		=> __('Image Height', 'themify'), 
		  "description" => __('Enter height = 0 to disable vertical cropping with img.php enabled', 'themify'), 				
		  "type" 		=> "textbox",			
		  "meta"		=> array("size"=>"small")			
		),
	// Hide Title
	array(
		  "name" 		=> "hide_title",
		  "title"		=> __('Hide Post Title', 'themify'),
		  "description"	=> "",
		  "type" 		=> "dropdown",			
		  "meta"		=> array(
		  						array("value" => "default", "name" => "", "selected" => true),

								 array("value" => "yes", 'name' => __('Yes', 'themify')),
								 array("value" => "no",	'name' => __('No', 'themify'))
								 )
		),
	// Unlink Post Title
	array(
		  "name" 		=> "unlink_title",	
		  "title" 		=> __('Unlink Post Title', 'themify'), 	
		  "description" => __('Unlink post title (it will display the post title without link)', 'themify'), 				
		  "type" 		=> "dropdown",			
		  "meta"		=> array(
		  						array("value" => "default", "name" => "", "selected" => true),

								 array("value" => "yes", 'name' => __('Yes', 'themify')),
								 array("value" => "no",	'name' => __('No', 'themify'))
								 )			
		),
	// Hide Post Date
	array(
		  "name" 		=> "hide_date",
		  "title"		=> __('Hide Post Date', 'themify'),
		  "description"	=> "",
		  "type" 		=> "dropdown",			
		  "meta"		=> array(
		  						array("value" => "default", "name" => "", "selected" => true),

								 array("value" => "yes", 'name' => __('Yes', 'themify')),
								 array("value" => "no",	'name' => __('No', 'themify'))
								 )
		),
	// Hide Post Meta
	array(
		  "name" 		=> "hide_meta",
		  "title"		=> __('Hide Post Meta', 'themify'),
		  "description"	=> "",
		  "type" 		=> "dropdown",			
		  "meta"		=> array(
		  						array("value" => "default", "name" => "", "selected" => true),

								 array("value" => "yes", 'name' => __('Yes', 'themify')),
								 array("value" => "no",	'name' => __('No', 'themify'))
								 )
		),
	// Hide Post Image
	array(
		  "name" 		=> "hide_image",	
		  "title" 		=> __('Hide Featured Image', 'themify'), 	
		  "description" => "", 				
		  "type" 		=> "dropdown",			
		  "meta"		=> array(
		  						array("value" => "default", "name" => "", "selected" => true),

								 array("value" => "yes", 'name' => __('Yes', 'themify')),
								 array("value" => "no",	'name' => __('No', 'themify'))
								 )			
		),
	// Unlink Post Image
	array(
		  "name" 		=> "unlink_image",	
		  "title" 		=> __('Unlink Featured Image', 'themify'), 	
		  "description" => __('Display the Featured Image without link', 'themify'), 				
		  "type" 		=> "dropdown",			
		  "meta"		=> array(
		  						array("value" => "default", "name" => "", "selected" => true),

								 array("value" => "yes", 'name' => __('Yes', 'themify')),
								 array("value" => "no",	'name' => __('No', 'themify'))
								 )			
		),
	// Page Navigation Visibility
	array(
		  "name" 		=> "hide_navigation",
		  "title"		=> __('Hide Page Navigation', 'themify'),
		  "description"	=> "",
		  "type" 		=> "dropdown",			
		  "meta"		=> array(
		  						array("value" => "default", "name" => "", "selected" => true),

								 array("value" => "yes", 'name' => __('Yes', 'themify')),
								 array("value" => "no",	'name' => __('No', 'themify'))
								 )
		)	
	);
	
	// Slider Meta Box Options
	$slider_meta_box_options = array(
	// Post LayoutSidebar Option
	array(
		 "name" 		=> "layout",
		 "title"		=> __('Slide Layout', 'themify'),
		 "description"	=> "",
		 "type"		=> "layout",
			'show_title' => true,
		 "meta"		=> array(
				array('value' => 'slider-default', 'img' => 'images/layout-icons/slider-default.png', 'selected' => true, 'title' => __('Default', 'themify')),
				array('value' => 'slider-image-only', 'img' => 'images/layout-icons/slider-image-only.png', 'title' => __('Image Only', 'themify')),
				array('value' => 'slider-content-only', 'img' => 'images/layout-icons/slider-content-only.png', 'title' => __('Content Only', 'themify')),
				array('value' => 'slider-image-caption', 'img' => 'images/layout-icons/slider-image-caption.png', 'title' => __('Image Caption', 'themify'))
			)
		),
	// Feature Image
	array(
		  "name" 		=> "feature_image",	
		  "title" 		=> __('Featured Image', 'themify'), //slider image
		  "description" => "", 				
		  "type" 		=> "image",			
		  "meta"		=> array()			
		),
	// Featured Image Size
	array(
		'name'	=>	'feature_size',
		'title'	=>	__('Image Size', 'themify'),
		'description' => __('Image sizes can be set at <a href="options-media.php">Media Settings</a> and <a href="admin.php?page=regenerate-thumbnails">Regenerated</a>', 'themify'),
		'type'		 =>	'featimgdropdown'
	),
	// Image Width
	array(
		  "name" 		=> "image_width",	
		  "title" 		=> __('Image Width', 'themify'), 
		  "description" => "", 				
		  "type" 		=> "textbox",			
		  "meta"		=> array("size"=>"small")			
		),
	// Image Height
	array(
		  "name" 		=> "image_height",	
		  "title" 		=> __('Image Height', 'themify'), 
		  "description" => __('Enter height = 0 to disable vertical cropping with img.php enabled', 'themify'), 				
		  "type" 		=> "textbox",			
		  "meta"		=> array("size"=>"small")			
		),
	// External Link
	array(
		  "name" 		=> "external_link",	
		  "title" 		=> __('External Link', 'themify'), 	
		  "description" => __('Link Featured Image to external URL', 'themify'), 				
		  "type" 		=> "textbox",			
		  "meta"		=> array()			
		),
	// Lightbox Link
	array(
		  "name" 		=> "lightbox_link",	
		  "title" 		=> __('Lightbox Link', 'themify'), 
		  "description" => __('Link Featured Image to lightbox image, video or external iframe (<a href="http://themify.me/docs/lightbox">learn more</a>)', 'themify'), 				
		  "type" 		=> "textbox",			
		  "meta"		=> array()			
		)
	);
	
	// Homepage Highlights Options
	$highlights_meta_box_options = array(
		// Image Icon
		array(
			  "name" 		=> "feature_image",	
			  "title" 		=> __('Featured Image', 'themify'), //icon image 
			  "description" => "", 				
			  "type" 		=> "image",			
			  "meta"		=> array()			
			),
		// Image Width
		array(
			  "name" 		=> "image_width",	
			  "title" 		=> __('Image Width', 'themify'), 
			  "description" => "", 				
			  "type" 		=> "textbox",			
			  "meta"		=> array("size"=>"small")			
			),
		// Image Height
		array(
			  "name" 		=> "image_height",	
			  "title" 		=> __('Image Height', 'themify'), 
			  "description" => __('Enter height = 0 to disable vertical cropping with img.php enabled', 'themify'), 				
			  "type" 		=> "textbox",			
			  "meta"		=> array("size"=>"small")			
			),
		// External Link
		array(
			  "name" 		=> "external_link",	
			  "title" 		=> __('External Link', 'themify'), 	
			  "description" => __('Link Featured Image to external URL', 'themify'), 				
			  "type" 		=> "textbox",			
			  "meta"		=> array()			
			),
		// Lightbox Link
		array(
			  "name" 		=> "lightbox_link",	
			  "title" 		=> __('Lightbox Link', 'themify'), 
			  "description" => __('Link Featured Image to lightbox image, video or external iframe (<a href="http://themify.me/docs/lightbox">learn more</a>)', 'themify'), 				
			  "type" 		=> "textbox",			
			  "meta"		=> array()			
			)
	 );
	
	///////////////////////////////////////
	// Build Write Panels
	///////////////////////////////////////
	themify_build_write_panels(array(
		array(
			 "name"		=> __('Post Options', 'themify'),			// Name displayed in box
			 "options"	=> $post_meta_box_options, 	// Field options
			 "pages"	=> "post"					// Pages to show write panel
			 ),
		array(
			 "name"		=> __('Page Options', 'themify'),	
			 "options"	=> $page_meta_box_options, 		
			 "pages"	=> "page"
			 ),
   		array(
			 "name"		=> __('Homepage Slider Options', 'themify'),	
			 "options"	=> $slider_meta_box_options, 		
			 "pages"	=> "slider"
			 ),
		array(
			 "name"		=> __('Homepage Highlights Options', 'themify'),	
			 "options"	=> $highlights_meta_box_options, 		
			 "pages"	=> "highlights"
			 )
  		)
	);
	
/* 	Custom Functions
/***************************************************************************/	

	///////////////////////////////////////
	// Enable WordPress feature image
	///////////////////////////////////////
	add_theme_support( 'post-thumbnails' );
    remove_post_type_support( 'page', 'thumbnail' );

	///////////////////////////////////////
	// Add wmode transparent and post-video container for responsive purpose
	///////////////////////////////////////	
	function themify_add_video_wmode_transparent($html) {
		$services = array(
			'youtube.com',
			'youtu.be',
			'blip.tv',
			'vimeo.com',
			'dailymotion.com',
			'hulu.com',
			'viddler.com',
			'qik.com',
			'revision3.com',
			'wordpress.tv',
			'wordpress.com',
			'funnyordie.com'
		);
		$video_embed = false;
		foreach( $services as $service ){
			if(stripos($html, $service)){
				$video_embed = true;
				break;
			}
		}
		if( $video_embed ){
			$html = '<div class="post-video">' . $html . '</div>';
			if (strpos($html, "<embed src=" ) !== false) {
				$html = str_replace('</param><embed', '</param><param name="wmode" value="transparent"></param><embed wmode="transparent" ', $html);
				return $html;
			}
			else {
				if(strpos($html, "wmode=transparent") == false){
					if(strpos($html, "?fs=" ) !== false){
						$search = array('?fs=1', '?fs=0');
						$replace = array('?fs=1&wmode=transparent', '?fs=0&wmode=transparent');
						$html = str_replace($search, $replace, $html);
						return $html;
					}
					else{
						$youtube_embed_code = $html;
						$patterns[] = '/youtube.com\/embed\/([a-zA-Z0-9._-]+)/';
						$replacements[] = 'youtube.com/embed/$1?wmode=transparent';
						return preg_replace($patterns, $replacements, $html);
					}
				}
				else{
					return $html;
				}
			}
		} else {
			return '<div class="post-embed">' . $html . '</div>';
		}
	}
	add_filter('embed_oembed_html', 'themify_add_video_wmode_transparent');

	///////////////////////////////////////
	// Adds a rel="prettyPhoto" tag to all linked image files
	///////////////////////////////////////
	add_filter('the_content', 'themify_addlightboxrel_replace', 12);
	add_filter('the_excerpt', 'themify_addlightboxrel_replace');
	add_filter('widget_text', 'themify_addlightboxrel_replace');
	add_filter('get_comment_text', 'themify_addlightboxrel_replace');
	function themify_addlightboxrel_replace ($content)
	{   global $post;
		$pattern = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i";
		$replacement = '<a$1href=$2$3.$4$5 rel="prettyPhoto['.$post->ID.']"$6>$7</a>';
		$content = preg_replace($pattern, $replacement, $content);
		return $content;
	}

	// Register Custom Menu Function
	function themify_register_custom_nav() {
		if (function_exists('register_nav_menus')) {
			register_nav_menus( array(
				'main-nav' => __( 'Main Navigation', 'themify' ),
			) );
		}
	}
	
	// Register Custom Menu Function - Action
	add_action('init', 'themify_register_custom_nav');
	
	// Default Main Nav Function
	function themify_default_main_nav() {
		echo '<ul id="main-nav" class="clearfix">';
		wp_list_pages('title_li=');
		echo '</ul>';
	}

	// Register Sidebars
	if ( function_exists('register_sidebar') ) {
		register_sidebar(array(
			'name' => __('Sidebar', 'themify'),
			'id' => 'sidebar-main',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widgettitle">',
			'after_title' => '</h4>',
		));
		register_sidebar(array(
			'name' => __('Social Widget', 'themify'),
			'id' => 'social-widget',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<strong>',
			'after_title' => '</strong>',
		));
	}
	
	// Home Page Widgets
	themify_register_grouped_widgets(
		array(
			'homewidget-4col' => 4,
			'homewidget-3col' => 3,
			'homewidget-2col' => 2,
			'homewidget-1col' => 1
		),
		array(
			'sidebar_name' => __('Home Widget', 'themify'),
			'sidebar_id' => 'home-widget',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widgettitle">',
			'after_title' => '</h4>'
		),
		'setting-homepage_widgets',
		'homewidget-3col'
	);

	// Footer Sidebars
	themify_register_grouped_widgets();

	// Custom Theme Comment
	function themify_theme_comment($comment, $args, $depth) {
	   $GLOBALS['comment'] = $comment; 
	   ?>
		<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
			<p class="comment-author">
				<?php echo get_avatar($comment,$size='74'); ?>
				<?php printf('<cite>%s</cite>', get_comment_author_link()) ?><br />
				<small class="comment-time"><strong><?php comment_date(apply_filters('themify_comment_date', 'M d, Y')); ?></strong> @ <?php comment_time(apply_filters('themify_comment_time', 'H:i:s')); ?><?php edit_comment_link( __('Edit', 'themify'),' [',']') ?></small>
			</p>
			<div class="commententry">
				<?php if ($comment->comment_approved == '0') : ?>
				<p><em><?php _e('Your comment is awaiting moderation.', 'themify') ?></em></p>
				<?php endif; ?>
			
				<?php comment_text() ?>
				<p class="reply">
				<?php comment_reply_link(array_merge( $args, array('add_below' => 'comment', 'depth' => $depth, 'reply_text' => __( 'Reply', 'themify' ), 'max_depth' => $args['max_depth']))) ?>
				</p>
			</div>
			
		<?php
	}
	
	// Themify Theme Key
	add_filter('themify_theme_key', create_function('$k', "return 'sbu0mzid3ljrbzsn5pijara96pahq6a8a';"));

?>