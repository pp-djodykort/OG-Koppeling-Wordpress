<?php
/*
Template Name: Contact
 */
?>

<?php get_header(); ?>

<div class='container'>
    <h1><?php the_title();?></h1>

    <div class='row'>

        <div class='col-lg-6'>
        <!-- Adding the contact 7 form -->
        <?php echo do_shortcode('[contact-form-7 id="25" title="Contact form 1"]'); ?>
        </div>

        <div class='col-lg-6'>
            <?php get_template_part('includes/section', 'content'); ?>
        </div>

    </div>
</div>

<?php get_footer(); ?>