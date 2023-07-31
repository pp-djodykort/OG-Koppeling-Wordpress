<?php
/*
* Template Name: Wonen
*/

// ============ Declaring Variables ============
# Post Variables
$post = get_post();
$postTitle = $post->post_title;

# OG Wonen detailpage settings
$OGSettings =

// ============ Start of Program ============
# Header
htmlDetailHeader();

echo("
<h1 class='text-center'>$postTitle</h1>
");

# Footer
htmlDetailFooter();