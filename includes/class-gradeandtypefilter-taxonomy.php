<?php
class GradeAndTypeFilter_Taxonomy {
    public function register_taxonomies() {
        $labels = array(
            'name'              => _x( 'Grades', 'taxonomy general name' ),
            'singular_name'     => _x( 'Grade', 'taxonomy singular name' ),
            'search_items'      => __( 'Search Grades' ),
            'all_items'         => __( 'All Grades' ),
            'parent_item'       => __( 'Parent Grade' ),
            'parent_item_colon' => __( 'Parent Grade:' ),
            'edit_item'         => __( 'Edit Grade' ),
            'update_item'       => __( 'Update Grade' ),
            'add_new_item'      => __( 'Add New Grade' ),
            'new_item_name'     => __( 'New Grade Name' ),
            'menu_name'         => __( 'Grades' ),
    
        );
    
        $args = array(
            'hierarchical'      => false,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_rest'      => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'grade' ),
        );
    
        register_taxonomy( 'grade', array( 'post', 'sfwd-courses' ), $args );


        $labels = array(
            'name'              => _x( 'Types', 'taxonomy general name' ),
            'singular_name'     => _x( 'Type', 'taxonomy singular name' ),
            'search_items'      => __( 'Search Types' ),
            'all_items'         => __( 'All Types' ),
            'parent_item'       => __( 'Parent Type' ),
            'parent_item_colon' => __( 'Parent Type:' ),
            'edit_item'         => __( 'Edit Type' ),
            'update_item'       => __( 'Update Type' ),
            'add_new_item'      => __( 'Add New Type' ),
            'new_item_name'     => __( 'New Type Name' ),
            'menu_name'         => __( 'Types' ),
        );
    
        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_in_rest'          => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'type' ),
        );
    
        register_taxonomy( 'type', array( 'post' , 'sfwd-courses'), $args );
    }
}
