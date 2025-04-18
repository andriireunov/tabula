<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri() ?>/assets/css/theme.css" />
	<?php wp_head(); ?>
</head>
<body <?php  body_class(); ?> >
    <header>
	<div class="container">
		<?php if(has_custom_logo()): ?>
			<?php the_custom_logo(); ?>
		<?php else: ?>
            <h1 class="site-title">
				<?php bloginfo('name'); ?>
            </h1>
		<?php endif; ?>
    </div>
	</header>