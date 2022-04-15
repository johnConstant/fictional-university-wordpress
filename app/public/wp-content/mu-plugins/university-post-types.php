<?php

function university_post_types(){

        // Campus Post Type

        register_post_type('campus', array(
            // Change slug from 'event' to 'events'
            'rewrite' => array(
                'slug' => 'campuses'
            ),
            // Allow archive page for post type
            'has_archive' => true,
            // Show post type in sidebar
            'public' => true,
            'labels' => array(
                'name' => 'Campuses',
                'add_new_item' => 'Add New Campus',
                'edit_item' => 'Edit Campus',
                // Change Archive title
                'all_items' => 'All Campuses',
                'singular_name' => 'Campus'
            ),
            // Change icon in sidebar menu
            'menu_icon' => 'dashicons-location-alt',
            // Add excerpt field to editor
            'supports' => array(
                'title', 'editor', 'excerpt'
            ),
            // Display block editor instead of classic editor
            // Shows in REST API because modern block editor uses JS
            // Must list editor in supports array
            'show_in_rest' => true,
            'capability_type' => 'campus',
            'map_meta_cap' => true
        ));

        // Event Post Type

        register_post_type('event', array(
            // Change slug from 'event' to 'events'
            'rewrite' => array(
                'slug' => 'events'
            ),
            // Allow archive page for post type
            'has_archive' => true,
            // Show post type in sidebar
            'public' => true,
            'labels' => array(
                'name' => 'Events',
                'add_new_item' => 'Add New Event',
                'edit_item' => 'Edit Event',
                // Change Archive title
                'all_items' => 'All Events',
                'singular_name' => 'Event'
            ),
            // Change icon in sidebar menu
            'menu_icon' => 'dashicons-calendar-alt',
            // Add excerpt field to editor
            'supports' => array(
                'title', 'editor', 'excerpt'
            ),
            // Display block editor instead of classic editor
            // Shows in REST API because modern block editor uses JS
            // Must list editor in supports array
            'show_in_rest' => true,
            // Change settings to allow for custom permissions within user roles :- "Event Planner"
            'capability_type' => 'event',
            'map_meta_cap' => true
        ));

        // After creating a new post type remember to save the permalinks in the settings sidebar menu.
        // This will recreate the entire websites permalink structure and make the pages visible in the front end.

        // Program Post type

        register_post_type('program', array(
            // Change slug from 'event' to 'events'
            'rewrite' => array(
                'slug' => 'programs'
            ),
            // Allow archive page for post type
            'has_archive' => true,
            // Show post type in sidebar
            'public' => true,
            'labels' => array(
                'name' => 'Programs',
                'add_new_item' => 'Add New Program',
                'edit_item' => 'Edit Program',
                // Change Archive title
                'all_items' => 'All Programs',
                'singular_name' => 'Programs'
            ),
            // Change icon in sidebar menu
            'menu_icon' => 'dashicons-awards',
            // Add excerpt field to editor
            'supports' => array(
                'title'
            ),
            // Display block editor instead of classic editor
            // Shows in REST API because modern block editor uses JS
            // Must list editor in supports array
            'show_in_rest' => true
        ));

        // Professor Post Type

        register_post_type('professor', array(
            // Show post type in sidebar
            'public' => true,
            'labels' => array(
                'name' => 'Professors',
                'add_new_item' => 'Add New Professor',
                'edit_item' => 'Edit Professor',
                // Change Archive title
                'all_items' => 'All Professors',
                'singular_name' => 'Professor'
            ),
            // Change icon in sidebar menu
            'menu_icon' => 'dashicons-welcome-learn-more',
            // Add excerpt field to editor
            'supports' => array(
                'title', 'editor', 'thumbnail'
            ),
            // Display block editor instead of classic editor
            // Shows in REST API because modern block editor uses JS
            // Must list editor in supports array
            'show_in_rest' => true
        ));

        // Notes Post Type

        register_post_type('note', array(
            // Show post type in sidebar
            'public' => false,
            'show_ui' => true,
            'labels' => array(
                'name' => 'Notes',
                'add_new_item' => 'Add New Note',
                'edit_item' => 'Edit Note',
                // Change Archive title
                'all_items' => 'All Notes',
                'singular_name' => 'Note'
            ),
            // Change icon in sidebar menu
            'menu_icon' => 'dashicons-welcome-write-blog',
            // Add excerpt field to editor
            'supports' => array(
                'title', 'editor'
            ),
            // Display block editor instead of classic editor
            // Shows in REST API because modern block editor uses JS
            // Must list editor in supports array
            'show_in_rest' => true,
            'capability_type' => 'note',
            'map_meta_cap' => true
        ));

        // Likes post type
        register_post_type('like', array(
            // Show post type in sidebar
            'public' => false,
            'show_ui' => true,
            'labels' => array(
                'name' => 'Likes',
                'add_new_item' => 'Add New Like',
                'edit_item' => 'Edit Like',
                // Change Archive title
                'all_items' => 'All Likes',
                'singular_name' => 'Like'
            ),
            // Change icon in sidebar menu
            'menu_icon' => 'dashicons-heart',
            'supports' => array(
                'title'
            )
        ));

        // Homepage Slide post type
        register_post_type("slide", array(
            "supports" => array("title"),
            "public" => true,
            "labels" => array(
                "name" => "Slideshow",
                "add_new_item" => "Add new Slide",
                "edit_item" => "Edit Slide",
                "all_items" => "All Slides",
                "singular_name" => "Slide"
            ),
            "menu_icon" => "dashicons-slides",
        ));

    }

    add_action('init', 'university_post_types');

    ?>