<?php
if(!class_exists('Timeline_Posttype'))
{
    class Timeline_Posttype
    {
        
         /**
    	 * The Constructor
    	 */
    	public function __construct()
    	{
    		// register actions
            add_action( 'init', array(&$this,'timeline_custom_post_type' ));
			add_filter('manage_edit-timeline_columns',array(&$this,'add_new_timeline_columns'));
		    add_action( 'manage_timeline_posts_custom_column' , array(&$this,'custom_columns'), 10, 2 );
	
    	} // END public function __construct())

          // Register Custom Post Type
        function timeline_custom_post_type() {

                    $labels = array(
                            'name'                => _x( 'Timeline Item', 'Post Type General Name', 'timeline' ),
                            'singular_name'       => _x( 'Timeline Item', 'Post Type Singular Name', 'timeline' ),
                            'menu_name'           => __( 'Timeline Item', 'timeline' ),
                            'name_admin_bar'      => __( 'Timeline Item', 'timeline' ),
                            'parent_item_colon'   => __( 'Parent Item:', 'timeline' ),
                            'all_items'           => __( 'All Items', 'timeline' ),
                            'add_new_item'        => __( 'Add New Item', 'timeline' ),
                            'add_new'             => __( 'Add New', 'timeline' ),
                            'new_item'            => __( 'New Item', 'timeline' ),
                            'edit_item'           => __( 'Edit Item', 'timeline' ),
                            'update_item'         => __( 'Update Item', 'timeline' ),
                            'view_item'           => __( 'View Item', 'timeline' ),
                            'search_items'        => __( 'Search Items', 'timeline' ),
                            'not_found'           => __( 'Not found', 'timeline' ),
                            'not_found_in_trash'  => __( 'Not found in Trash', 'timeline' ),
                    );
                    $args = array(
                            'label'               => __( 'timeline', 'timeline' ),
                            'description'         => __( 'Timeline Post Type Description', 'timeline' ),
                            'labels'              => $labels,
                            'supports'            => array('title','editor','thumbnail','author','genesis-seo','genesis-layouts' ),
                            'taxonomies'          => array(),
                            'hierarchical'        => false,
                            'public'              => true,
                            'show_ui'             => true,
                            'show_in_menu'        => true,
                            'menu_position'       => 5,
                            'show_in_admin_bar'   => true,
                            'show_in_nav_menus'   => true,
                            'can_export'          => true,
                            'has_archive'         => true,
                            'exclude_from_search' => false,
                            'publicly_queryable'  => true,
                            'capability_type'     => 'page',
                            'rewrite' 			  => array('slug' => 'timeline','with_front' => false),
							//'menu_icon'=>TIMELINE_PLUGIN_URL.'/images/timeline.png',
                    );
                    register_post_type( 'timeline', $args );

            }
			function add_new_timeline_columns($gallery_columns) {
				$new_columns['cb'] = '<input type="checkbox" />';
					$new_columns['images'] = __('Images');
				$new_columns['title'] = _x('Title', 'column name');
				$new_columns['year'] = __('Year');
				$new_columns['date'] = _x('Date', 'column name');
			
				$new_columns['content'] = _x('Content', 'column name');
				return $new_columns;
			}	

		
		function custom_columns( $column, $post_id ) {
			 switch ( $column ) {
				 case "year":
				 $posted_year= get_the_date('Y', $post_id );
				 echo"<p><strong>".$posted_year."</strong></p>";
				  break;
				case "images":
				// - show thumb -
					$post_image_id = get_post_thumbnail_id(get_the_ID());
					if ($post_image_id) {
					$thumbnail = wp_get_attachment_image_src( $post_image_id, array(150,150), false);
					if ($thumbnail) (string)$thumbnail = $thumbnail[0];
					echo '<img src="'.$thumbnail.'" alt="" />';
					}
				  break;
				case "content":
				echo  $content=get_the_excerpt();
				break;
			  }
		}


			
  }
    
}