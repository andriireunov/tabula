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
<body>
<header>
    <?php if(has_custom_logo()): ?>
    <?php the_custom_logo(); ?>
    <?php endif ?>
    header</header>
<main>
    <div class="container">
        content
    </div>
</main>
<footer>footer</footer>
</body>
</html>