<?php 

function university_like_routes(){

    //Post Like Method
    register_rest_route('university/v1', 'manageLike', array(
        'methods' => 'POST',
        'callback' => 'create_like'
    ));

    // Delete Like Method
    register_rest_route('university/v1', 'manageLike', array(
        'methods' => 'DELETE',
        'callback' => 'delete_like'
    ));
}

function create_like($data){
    if(is_user_logged_in()){
        $professor = sanitize_text_field($data['professorId']);

        // if this query returns any results then the current user has already liked this professor.
        $existsQuery = new WP_Query(array(
            'post_type' => 'like',
            'author' => get_current_user_id(),
            'meta_query' => array(
                array(
                'key' => 'liked_professor_id',
                'compare' => '=',
                'value' => $professor
                )
            )
        ));   

        // Check if current user has already liked this professor
        if($existsQuery->found_posts == 0 AND get_post_type($professor) == 'professor'){
            // Add like for a professor
            return wp_insert_post(array(
                'post_type' => 'like',
                'post_status' => 'publish',
                'post_title' => 'Our Second PHP Create Post',
                'meta_input' => array(
                    'liked_professor_id' => $professor
                )
            ));
        }else{
            die('You have already liked this professor');
        }    
    }else{
        die('You must be logged in to like a professor.');
    }
}

function delete_like($data){
    $likeId = sanitize_text_field($data['like']);  

    if(get_current_user_id() == get_post_field('post_author', $likeId) AND get_post_type($likeId) == 'like'){
        wp_delete_post($likeId, true);
        return 'Like deleted';
    }else{
        die('You do not have permission to delete that.');
    }
}

add_action('rest_api_init', 'university_like_routes');

?>