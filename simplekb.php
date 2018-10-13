<?php

/**
 * Plugin Name: SimpleKB
 * Plugin URI: https://github.com/davidshq/simpleKB
 * Description: Creates a Custom Post Type and associated Custom Taxonomies for an intentionally simple Knowledge Base.
 * Version: 0.1
 * Author: Dave Mackey
 * Author URI: https://davemackey.net/
 * License: GPL2
*/

class SimpleKB {

    /**
     * Constructor: Called when plugin is initialized.
     *
     * @since 0.1
     */
	function __construct() {
		add_action( 'init', array( $this, 'skb_register_skb_cpt'));
        add_action( 'init', 'skb_register_taxonomy_subject');
	}

	/**
     * Activation Hook: Registers SimpleKB Role to SimpleKB
     *
     * @since 0.1
     */
	function plugin_activation() {
	     // Set capabilities for role
        $customCaps = array(
            // Permissions for SimpleKB
            'edit_others_skbs'          => true,
            'delete_others_skbs'        => true,
            'delete_private_skbs'       => true,
            'edit_private_skbs'         => true,
            'read_private_skbs'         => true,
            'edit_published_skbs'       => true,
            'publish_skbs'              => true,
            'delete_published_skbs'     => true,
            'edit_skbs'                 => true,
            'delete_skbs'               => true,
            'edit_skb'                  => true,
            'read_skb'                  => true,
            'delete_skb'                => true,
            'read'                      => true,
            // Permissions for SKB Subject Taxonomy
            'manage_skb_subjects'          => true,
            'edit_skb_subjects'            => true,
            'delete_skb_subjects'          => true,
            'assign_skb_subjects'          => true,
    );

    // Create our SimpleKBs role and assign the custom capabilities to it
    add_role( 'skb_editor', __( 'SimpleKB Editor', 'skb' ), $customCaps );

    // Add custom capabilities to Admin and Editor Roles
     $roles = array( 'administrator', 'editor' );
     foreach ( $roles as $roleName ) {
         // Get role
         $role = get_role( $roleName );

         // Check role exists
         if ( is_null( $role) ) {
             continue;
         }

         // Iterate through our custom capabilities, adding them
         // to this role if they are enabled
         foreach ( $customCaps as $capability => $enabled ) {
             if ( $enabled ) {
                 // Add capability
                 $role->add_cap( $capability );
             }
         }
     }
	}

    /**
     * Deactivate Plugin
     *
     * @since 0.1
     */
	function plugin_deactivation() {
	    remove_role ('skb_editor');
    }

    /**
     * Registers a Custom Post Type: skb
     *
     * @since 0.1
     */
	function skb_register_skb_cpt() {
		// Define the labels for CPT.
		$labels = array(
			'name'               => _x ('SimpleKB', 'post type general name', 'skb' ),
			'singular_name'      => _x ('SimpleKB', 'post type singular name', 'skb' ),
			'menu_name'          => _x ('SimpleKBs', 'admin menu', 'skb' ),
			'name_admin_bar'     => _x ('SimpleKBs', 'skb' ),
			'add_new'            => _x ('Add New', 'skb', 'skb' ),
			'add_new_item'       => _x ('Add New SimpleKB', 'skb' ),
			'new_item'           => _x ('New SimpleKB', 'skb' ),
			'edit_item'          => _x ('Edit SimpleKB', 'skb' ),
			'view_item'          => _x ('View SimpleKB', 'skb' ),
			'all_items'          => _x ('All SimpleKBs', 'skb' ),
			'search_items'       => _x ('Search SimpleKBs', 'skb' ),
			'parent_item_colon'  => _x ('Parent SimpleKBs:', 'skb' ),
			'not_found'          => _x ('No SimpleKB found.', 'skb' ),
			'not_found_in_trash' => _x ('No SimpleKB found in Trash.', 'skb' ),
		);

		// Define CPT capabilities.
        $capabilities = array(
            'edit_others_posts'     => 'edit_others_skbs',
            'delete_others_posts'   => 'delete_others_skbs',
            'delete_private_posts'  => 'delete_private_skbs',
            'edit_private_posts'    => 'edit_private_skbs',
            'read_private_posts'    => 'read_private_skbs',
            'edit_published_posts'  => 'edit_published_skbs',
            'publish_posts'         => 'publish_skbs',
            'delete_published_posts'=> 'delete_published_skbs',
            'edit_posts'            => 'edit_skbs'   ,
            'delete_posts'          => 'delete_skbs',
            'edit_post'             => 'edit_skb',
            'read_post'             => 'read_skb',
            'delete_post'           => 'delete_skb',
        );
        // Define CPT attributes.
		$args = array(
			'description'   => 'Simple Knowledge Base Articles.',
			'has_archive'   => true,
			'hierarchical'  => true,
			'labels'        => $labels,
			'menu_icon'     => 'dashicons-admin-comments',
			'menu_position' => 30,
			'public'        => true,
			'with_front'    => false,
			'rewrite'       => array(
			    'with_front' => false,
                'slug'       => 'kb',
            ),
			'supports'      => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes', 'post-formats' ),
            'capabilities'  => $capabilities,
            'map_meta_cap'  => true,
		);

		// Register CPT.
		register_post_type( 'skb', $args );
	}
}

/**
 * Create a custom taxonomy, SimpleKB Subjects.
 *
 * @since 0.1
 */
function skb_register_taxonomy_subject() {
	// Define labels for taxonomy
	$labels = array(
		'name'              => _x( 'Subjects', 'taxonomy general name' ),
		'singular_name'     => _x( 'Subject', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Subjects' ),
		'all_items'         => __( 'All Subjects' ),
		'parent_item'       => __( 'Parent Subject' ),
		'parent_item_colon' => __( 'Parent Subject:'),
		'edit_item'         => __( 'Edit Subject' ),
		'update_item'       => __( 'Update Subject' ),
		'add_new_item'      => __( 'Add New Subject' ),
		'new_item_name'     => __( 'New Subject Name' ),
		'menu_name'         => __( 'Subjects' ),
	);
	// Define capabilities of taxonomy
    $capabilities = array(
        'manage_terms'          => 'manage_skb_subjects',
        'edit_terms'            => 'edit_skb_subjects',
        'delete_terms'          => 'delete_skb_subjects',
        'assign_terms'          => 'assign_skb_subjects'
    );
    // Define taxonomy
	$args = array(
		'hierarchical'            => true,
		'labels'                  => $labels,
		'show_ui'                 => true,
		'show_admin_column'       => true,
		'query_var'               => true,
		'rewrite'                 => array(
            'with_front' => 'false',
		    'slug' => 'subject',
        ),
        'capabilities'            => $capabilities,
        'map_meta_cap'            => 'true'
	);

	// Register taxonomy.
	register_taxonomy( 'skb_subject', array( 'skb' ), $args );

	// Flush permalinks.
	global $wp_rewrite;
	$wp_rewrite->flush_rules();
}

/**
 * Create simplekb_all Shortcode
 *
 * @return string
 * @since 0.1
 */
function skb_get_kbs_shortcode() {
    $args = array(
        'post_type'    => 'skb',
        'post_status'  => 'publish'
    );

    $string = '';
    $query = new WP_Query( $args );
    if( $query->have_posts() ) {
        $string .= '<ul>';
        while( $query->have_posts() ) {
            $query->the_post();
            $string .= '<li><a href="' . get_permalink() . '" title="' . get_the_title() . '">' . get_the_title() . '</a></li>';
        }
        $string .= '</ul>';
    }
    wp_reset_postdata();
    return $string;
}

add_shortcode('simplekb_all','skb_get_kbs_shortcode');

$SimpleKB = new SimpleKB;

register_activation_hook( __FILE__, array( &$SimpleKB, 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( &$SimpleKB, 'plugin_deactivation' ) );
