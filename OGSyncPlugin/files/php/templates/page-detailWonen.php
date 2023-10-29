<?php
/*
* Template Name: Wonen
*/

// ============ Declaring Variables ============
# Vars
$boolTrue = True;
# Post Variables
$post = get_post();
$postTitle = $post->post_title;
$queryImages = new WP_Query([
	'post_type' => 'attachment',
	'post_parent' => $post->ID,
	'posts_per_page' => -1,
	'post_status' => 'any',
]);
$imagesExist = $queryImages->have_posts();

# OG Wonen detailpage settings


// ============ Start of Program ============
# ======== Header ========
OGSyncTools::htmlDetailHeader();

# ======== Content ========
echo("
	<!-- ==== Post title ==== -->
	<h1 class='text-center'>$postTitle</h1>
	
	<!-- ==== Post content ==== -->
	<!-- Images -->
	<div class='container-md'>
		<div id='carouselExampleIndicators idDetailpageCarousel' class='carousel'>
			<div class='carousel-indicators'>
		    	<button type='button' data-bs-target='#carouselExampleIndicators' data-bs-slide-to='0' class='active' aria-current='true' aria-label='Slide 1'></button>
		    	<button type='button' data-bs-target='#carouselExampleIndicators' data-bs-slide-to='1' aria-label='Slide 2'></button>
		    	<button type='button' data-bs-target='#carouselExampleIndicators' data-bs-slide-to='2' aria-label='Slide 3'></button>
	    	</div>
		  		<div class='carousel-inner'>
			    <div class='carousel-item active'>
			      	<img src='https://getbootstrap.com/docs/5.3/assets/brand/bootstrap-logo-shadow.png' class='d-block w-100' alt='Lets see if it works'>
			    </div>
			    <div class='carousel-item'>
			      	<img src='https://getbootstrap.com/docs/5.3/assets/img/webpack.svg' class='d-block w-100' alt='yes'>
			    </div>
			    <div class='carousel-item'>
			      	<img src='https://getbootstrap.com/docs/5.3/assets/img/vite.svg' class='d-block w-100' alt='yes2'>
			    </div>
	  	</div>
		<button class='carousel-control-prev' type='button' data-bs-target='#carouselExampleIndicators' data-bs-slide='prev'>
	        <span class='carousel-control-prev-icon' aria-hidden='true'></span>
			<span class='visually-hidden'>Previous</span>
		</button>
	  	<button class='carousel-control-next' type='button' data-bs-target='#carouselExampleIndicators' data-bs-slide='next'>
		    <span class='carousel-control-next-icon' aria-hidden='true'></span>
		    <span class='visually-hidden'>Next</span>
	  	</button>
		</div>
	</div>
");

# ======== Footer ========
OGSyncTools::htmlDetailFooter();