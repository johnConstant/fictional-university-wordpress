<?php

if(!is_user_logged_in()){ 
    wp_redirect(esc_url(site_url('/')));
    exit;
}

get_header();

while(have_posts()){
    the_post(); 

    pageBanner(array(
      // 'title' => 'Hello there, this is the title',
      // 'subtitle' => 'This is the subtitle',
      // 'photo' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcT7-4zXE87YYqfE4ADhphGayvWnVJ8dBn0M9g&usqp=CAU'
    ));
?>

  <div class="container container--narrow page-section">
    <div class="create-note">
        <h2 class="headline">Create new note:</h2>
        <input type="text" placeholder = "Title" class="new-note-title">
        <textarea name="" id="" cols="30" rows="10" class="new-note-body" placeholder = "Your note here..."></textarea>
        <span class="submit-note">Create note <i class="fa fa-plus" aria-hidden="true"></i></span> 
        <span class="note-limit-message">Note limit reached, delete an older note to make room for this one.</span> 
    </div>

    <ul class="min-list link-list" id = "my-notes">
        <?php 
            $userNotes = new WP_Query(array(
                'post_type' => 'note',
                'posts_per_page' => -1,
                'author' => get_current_user_id()
            ));

            while($userNotes -> have_posts()){
                $userNotes -> the_post()
        ?>

                <li data-id = "<?php the_id(); ?>">
                    <input readonly type="text" class = "note-title-field" value = "<?php echo str_replace('Private: ', '', esc_attr(get_the_title())); ?>">
                    <span class = "edit-note"><i class ="fa fa-pencil" aria-hidden = "true"> Edit</i></span>
                    <span class = "delete-note"><i class ="fa fa-trash-o" aria-hidden = "true"> Delete</i></span>
                    <textarea readonly class = "note-body-field" name="" id="" cols="30" rows="10"><?php echo esc_textarea(wp_strip_all_tags(get_the_content())); ?></textarea>
                    <span class = "update-note btn btn--blue btn--small">Save <i class="fa fa-floppy-o"></i></span>
                </li>

        <?php } ?>
    </ul>
  </div>

<?php } 

get_footer();
?>