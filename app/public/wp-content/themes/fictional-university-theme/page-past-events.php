
<?php
get_header();

pageBanner(array(
  'title' => 'Past Events',
  'subtitle' => 'A recap of our past events.'
));
?>


<!-- <div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('images/ocean.jpg') ?>;"></div>
    <div class="page-banner__content container container--narrow">
       <h1 class="page-banner__title">Past Events</h1>
      <div class="page-banner__intro">
        <p>A recap of our past events.</p>
      </div>
    </div>  
  </div> -->

  <div class="container container--narrow page-section">
    <?php 
    
    $today = date('Ymd');
        
        $pastEvents = new WP_Query(array(
            //'posts_per_page' => 1,
            'post_type' => 'event',
            // Sort events by event date
            'meta_key' => 'event_date',
            // Specify the order of upcoming events to be sorted by the date field ie. a num (20200922)
            'orderby' => 'meta_value_num',
            // 'order' => 'ASC',
            // Remove event from upcoming events if event date has passed
            'meta_query' => array(
              // Only display event if event date is less than or equal to today
              array(
                'key' => 'event_date',
                'compare' => '<=',
                'value' => $today,
                'type' => 'numeric'
              )
              ),
              'paged' => get_query_var('paged', 1)
        ));
    
    while($pastEvents -> have_posts()){
    $pastEvents -> the_post(); 

      get_template_part('template-parts/content', 'event');
    }
    
    echo paginate_links(array(
        'total' => $pastEvents -> max_num_pages
    ));
    ?>
  </div>

<?php
get_footer(); 
?>