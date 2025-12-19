<?php
/**
 * Template Name: Healthy AI Education LP
 *
 * This template displays the React-based Landing Page.
 */

// WordPressのヘッダーを読み込まない場合（完全なLPとして表示する場合）はコメントアウトを外してください
// get_header(); 
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <?php wp_head(); ?>
    
    <!-- React App CSS -->
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/templates/lp-assets/assets/index-D_urytMH.css">
</head>
<body <?php body_class(); ?>>

    <!-- React App Root -->
    <div id="root"></div>

    <!-- React App JS -->
    <script type="module" src="<?php echo get_stylesheet_directory_uri(); ?>/templates/lp-assets/assets/index-Cat39Wn_.js"></script>

    <?php wp_footer(); ?>
</body>
</html>
