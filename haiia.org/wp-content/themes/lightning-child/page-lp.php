<?php
/**
 * Template Name: Healthy AI Education LP
 *
 * Standalone React LP - no WordPress hooks to avoid React conflicts.
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title><?php echo get_the_title(); ?> | <?php bloginfo( 'name' ); ?></title>
    <meta property="og:image" content="<?php echo get_stylesheet_directory_uri(); ?>/templates/lp-assets/images/ogp.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;500&family=Zen+Old+Mincho:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/templates/lp-assets/assets/index-DF6hphYx.css">
</head>
<body>
    <div id="root"></div>
    <script type="module" src="<?php echo get_stylesheet_directory_uri(); ?>/templates/lp-assets/assets/index-DsoYQrzB.js"></script>
</body>
</html>
