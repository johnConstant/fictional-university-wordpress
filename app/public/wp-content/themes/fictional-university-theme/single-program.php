<?php

get_header();

while(have_posts()){
    the_post(); 

    pageBanner();
?>

<!-- <div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('images/ocean.jpg') ?>;"></div>
    <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title"><?php the_title(); ?></h1>
      <div class="page-banner__intro">
        <p>Learn how the school of your dreams got started.</p>
      </div>
    </div>  
  </div> -->

  <div class="container container--narrow page-section">
  <div class="metabox metabox--position-up metabox--with-home-link">
      <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program'); ?>"><i class="fa fa-home" aria-hidden="true"></i> All programs</a> <span class="metabox__main"><?php the_title(); ?></span></p>
    </div>
    <div class="generic-content">
        <?php the_field('main_body_content'); ?>
    </div>

    <?php 

        $relatedProfessors = new WP_Query(array(
            'posts_per_page' => -1,
            'post_type' => 'professor',
            'orderby' => 'title',
            'order' => 'ASC',
            'meta_query' => array(
            array(
                'key' => 'related_programs',
                'compare' => 'LIKE',
                'value' => '"'.get_the_ID().'"'
            )
            )
        ));

        if($relatedProfessors -> have_posts()){
            echo '<hr class = "section-break" />';
            echo '<h2 class = "headline headline--small">'.get_the_title().' Professors</h2>';
            echo '<ul class = "professor-cards">';
            while($relatedProfessors->have_posts()){
                $relatedProfessors->the_post(); ?>

            <li class = "professor-card__list-item">
                <a class = "professor-card" href = "<?php the_permalink(); ?>">
                    <img src = "<?php the_post_thumbnail_url('professorLandscape'); ?>" class = "professor-card__image"/>
                    <span class = "professor-card__name"><?php the_title(); ?></span>
                </a>
            </li>
        
        <?php } 
        echo '</ul>';
        }

        wp_reset_postdata();

        $today = date('Ymd');
        
        $homepageEvents = new WP_Query(array(
            'posts_per_page' => 2,
            'post_type' => 'event',
            // Sort events by event date
            'meta_key' => 'event_date',
            // Specify the order of upcoming events to be sorted by the date field ie. a num (20200922)
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            // Remove event from upcoming events if event date has passed
            'meta_query' => array(
              // Only display event if event date is greater than or equal to today
              array(
                'key' => 'event_date',
                'compare' => '>=',
                'value' => $today,
                'type' => 'numeric'
              ),
              // Only display related programs if it contains the program ID
              array(
                  'key' => 'related_programs',
                  'compare' => 'LIKE',
                  'value' => '"'.get_the_ID().'"'
              )
            )
        ));

        if($homepageEvents -> have_posts()){
            echo '<hr class = "section-break" />';
            echo '<h2 class = "headline headline--small">Upcoming '.get_the_title().' Events</h2>';

            while($homepageEvents->have_posts()){
                $homepageEvents->the_post(); 
            
                get_template_part('template-parts/content', 'event');
            
            } 
        ?>

        <hr class = "section-break" />
        <?php

        wp_reset_postdata();    

        $relatedCampuses = get_field('related_campus');
        
        if($relatedCampuses){
            echo '<h2 class = "headline headline--small">'.get_the_title().' is available at these campuses.</h2>';
            echo '<ul class = "min-list link-list">';
            foreach($relatedCampuses as $campus){ ?>
             
                <li><a href = "<?php echo get_the_permalink($campus); ?>"><?php echo get_the_title($campus); ?> </a></li>
             
        <?php    }

        echo '</ul>';

        }

        }?>
  </div>
<?php } 

get_footer();

?>