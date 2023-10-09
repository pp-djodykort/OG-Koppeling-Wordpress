<!-- get post till there is no more post to get -->
<?php if (have_posts()): while (have_posts()): the_post();?>
    <?php the_content(); ?>
<?php endwhile; else: endif; ?>