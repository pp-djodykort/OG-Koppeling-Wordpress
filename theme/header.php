<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta charset='utf-8'>
        <title>Pixelplus <?php echo($post->post_name) ?></title>

        <?php wp_head(); ?>
    </head>

    <body>
        <header>
            <!-- Language Flag changing based on what language you are on and what post/page -->
            <?php if (str_starts_with(($post->post_name), 'nl-')): {?>
                <a href='https://og-wp.pixelplus.nl/en-<?php echo(substr(($post->post_name), 3))?>'><img class='flag' src='https://www.djody.nl/wp-content/uploads/2022/12/engelse-vlag.png' alt='Look for the engelse-vlag.png'></a>
            <?php } ?>
            
            <?php else: {?>
                <a href='https://og-wp.pixelplus.nl/nl-<?php echo(substr(($post->post_name), 3))?>'><img class='flag' src='https://www.djody.nl/wp-content/uploads/2022/12/nederlandse-vlag.png' alt='Look for the nederlandse-vlag.png'></a>
            <?php } ?>
            <?php endif; ?>
        
        </header>