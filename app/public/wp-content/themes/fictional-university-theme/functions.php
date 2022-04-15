<?php 

require get_theme_file_path('/includes/search-route.php');
require get_theme_file_path('/includes/like-route.php');

function pageBanner($args = NULL){
    // php logic will live here
    if(!$args['title']){
        $args['title'] = get_the_title();
    }

    if(!$args['subtitle']){
        $args['subtitle'] = get_field('page_banner_subtitle');
    }

    if(!$args['photo']){
        if(get_field('page_banner_background_image') AND !is_archive() AND !is_home()){
            $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
        } else {
            $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
        }
    }

?>

    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo'];?>;"></div>
        <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php echo $args['title'] ?></h1>
        <div class="page-banner__intro">
            <p><?php echo $args['subtitle'] ?></p>
        </div>
        </div>  
    </div>


<?php } 


    
    function university_files(){
        wp_enqueue_style('font_awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
        wp_enqueue_style('google_fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
        wp_enqueue_script('google_map', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBHWMM9esmb8AoyPr7AOT3lcsYQtr4PsX4', NULL, '1.0', true);

        if (strstr($_SERVER['SERVER_NAME'], 'fictional-university.local')) {
            wp_enqueue_script('main-university-js', 'http://localhost:3000/bundled.js', NULL, '1.0', true);
        }else{
            wp_enqueue_script('our_vendors_js', get_theme_file_uri('/bundled-assets/vendors~scripts.e3c5e6c075b806fc8212.js'), NULL, '1.0', true);
            wp_enqueue_script('main_university_js', get_theme_file_uri('/bundled-assets/scripts.5b844e6e89952c8c67f7.js'), NULL, '1.0', true);
            wp_enqueue_style('our_main_styles', get_theme_file_uri('/bundled-assets/styles.5b844e6e89952c8c67f7.css'));
        }
        // Create Variable called universityData which dynamically holds the URL.
        // this allows the JSON fetch method to work whether in dev or production environments.
        wp_localize_script('main-university-js', 'universityData', array(
            'root_url' => get_site_url(),
            'nonce' => wp_create_nonce('wp_rest')
        ));
    }

    add_action('wp_enqueue_scripts', 'university_files'); 

    function university_features(){
        register_nav_menu('headerMenuLocation', 'Header Menu Location');
        register_nav_menu('footerMenuLocation1', 'Footer Menu Location 1');
        register_nav_menu('footerMenuLocation2', 'Footer Menu Location 2');
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        // Add different image sizes and shapes to the DB
        add_image_size('professorLandscape', '400', '260', false);
        add_image_size('professorPortrait', '480', '640', true);
        add_image_size('pageBanner', '1500', '350', true);
    }

    add_action('after_setup_theme', 'university_features');

    function university_adjust_queries($query){

        $today = date('Ymd');
        if(!is_admin() AND is_post_type_archive('program') AND $query -> is_main_query()){
            // Organise alphabetically by title
            $query -> set('orderby', 'title');
            $query -> set('order', 'ASC');
            $query -> set('posts_per_page', -1);

        }

        if(!is_admin() AND is_post_type_archive('campus') AND $query -> is_main_query()){
            $query -> set('posts_per_page', -1);
        }

        if(!is_admin() AND is_post_type_archive('event') AND $query -> is_main_query()){
            $query -> set('meta_key', 'event_date');
            $query -> set('orderby', 'meta_value_num');
            $query -> set('order', 'ASC');
            $query -> set('meta_query', array(
                array(
                  'key' => 'event_date',
                  'compare' => '>=',
                  'value' => $today,
                  'type' => 'numeric'
                )
              ));
        }
    }

    add_action('pre_get_posts', 'university_adjust_queries');


    function university_map_key($api){
        $api['key'] = 'AIzaSyBHWMM9esmb8AoyPr7AOT3lcsYQtr4PsX4';
        return $api;
    }

    add_filter('acf/fields/google_map/api', 'university_map_key');


    // Add field to JSON REST API :- authorName
    function university_custom_rest(){
        register_rest_field('post', 'authorName', array(
            'get_callback' => function(){
                return get_the_author();
            }
        ));

        register_rest_field('note', 'noteCount', array(
            'get_callback' => function(){
                return count_user_posts(get_current_user_id(), 'note');
            }
        ));
    }

    add_action('rest_api_init', 'university_custom_rest');

    // Redirect subscriber accounts out of admin and on to homepage

    function redirect_subs_to_frontend(){
        
        $currentUser = wp_get_current_user();
        if(count($currentUser -> roles) == 1 AND $currentUser -> roles[0] == 'subscriber'){
            wp_redirect(site_url('/'));
            exit;
        }
    }

    add_action('admin_init', 'redirect_subs_to_frontend');


    function no_subs_admin_bar(){
        
        $currentUser = wp_get_current_user();
        if(count($currentUser -> roles) == 1 AND $currentUser -> roles[0] == 'subscriber'){
            show_admin_bar(false);
        }
    }

    add_action('wp_loaded', 'no_subs_admin_bar');

    // Customise Login screen

    function our_header_url(){
        return esc_url(site_url('/'));
    }

    add_filter('login_headerurl', 'our_header_url');

// Load stylesheet on login screen

    function our_login_css(){
        wp_enqueue_style('our_main_styles', get_theme_file_uri('/bundled-assets/styles.5b844e6e89952c8c67f7.css'));
        wp_enqueue_style('google_fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    }

    add_action('login_enqueue_scripts', 'our_login_css');

    function our_login_title(){
        return get_bloginfo('name');
    }

    add_filter('login_headertitle', 'our_login_title');



    // force note posts to be private
    function make_note_private($data, $postArr){
        
        if($data['post_type'] == 'note'){
            // Place limit on the number of notes per user
            if(count_user_posts(get_current_user_id(),'note') > 3 AND !$postArr['ID']){
                die('Sorry but you have reached your note limit');
            }

            // Remove all HTML from the notes inputs
            $data['post_content'] = sanitize_textarea_field($data['post_content']);
            $data['post_title'] = sanitize_text_field($data['post_title']);
        }

        if($data['post_type'] == 'note' AND $data['post_status'] != 'trash'){
            $data['post_status'] = 'private';
        }
        return $data;
    }

    add_filter('wp_insert_post_data', 'make_note_private', 10, 2);

?> 