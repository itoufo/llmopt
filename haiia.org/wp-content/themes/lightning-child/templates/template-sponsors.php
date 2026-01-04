<?php
/**
 * Template Name: 法人賛助会員
 * Description: 法人賛助会員のロゴを掲載するページ専用テンプレート
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<?php
do_action( 'lightning_site_header_before', 'lightning_site_header_before' );
if ( apply_filters( 'lightning_is_site_header', true, 'site_header' ) ) {
    lightning_get_template_part( 'template-parts/site-header' );
}
do_action( 'lightning_site_header_after', 'lightning_site_header_after' );
?>

<?php do_action( 'lightning_site_body_before', 'lightning_site_body_before' ); ?>

<div class="<?php lightning_the_class_name( 'site-body' ); ?> haiia-sponsors">
    <?php do_action( 'lightning_site_body_prepend', 'lightning_site_body_prepend' ); ?>

    <!-- ページヘッダー -->
    <div class="haiia-page-header">
        <div class="container">
            <h1 class="haiia-page-title"><?php the_title(); ?></h1>
            <?php
            $subtitle = get_field( 'sponsors_subtitle' );
            if ( $subtitle ) : ?>
                <p class="haiia-page-subtitle"><?php echo esc_html( $subtitle ); ?></p>
            <?php else : ?>
                <p class="haiia-page-subtitle">Corporate Sponsors</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="<?php lightning_the_class_name( 'site-body-container' ); ?> container">

        <div class="<?php lightning_the_class_name( 'main-section' ); ?> main-section--margin-bottom--on" id="main" role="main">
            <?php do_action( 'lightning_main_section_prepend', 'lightning_main_section_prepend' ); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class( 'entry entry-full' ); ?>>
                <div class="entry-body haiia-sponsors-content">

                    <!-- イントロダクション -->
                    <?php
                    $intro = get_field( 'sponsors_introduction' );
                    if ( $intro ) : ?>
                    <section class="haiia-sponsors-intro">
                        <div class="haiia-intro-text">
                            <?php echo wp_kses_post( $intro ); ?>
                        </div>
                    </section>
                    <?php endif; ?>

                    <!-- プラチナスポンサー -->
                    <?php
                    $platinum_logos = get_field( 'sponsors_platinum' );
                    if ( $platinum_logos ) : ?>
                    <section class="haiia-sponsors-section haiia-sponsors-platinum" id="platinum">
                        <h2 class="haiia-sponsors-h2">
                            <span class="haiia-sponsor-tier platinum">Platinum</span>
                            プラチナスポンサー
                        </h2>
                        <div class="haiia-sponsors-grid haiia-sponsors-grid--platinum">
                            <?php foreach ( $platinum_logos as $logo ) :
                                $url = $logo['caption'] ? esc_url( $logo['caption'] ) : '';
                                $name = $logo['title'] ? esc_attr( $logo['title'] ) : '';
                            ?>
                            <div class="haiia-sponsor-item">
                                <?php if ( $url ) : ?>
                                <a href="<?php echo $url; ?>" target="_blank" rel="noopener noreferrer" class="haiia-sponsor-link">
                                <?php endif; ?>
                                    <img src="<?php echo esc_url( $logo['url'] ); ?>" alt="<?php echo $name; ?>" class="haiia-sponsor-logo">
                                    <?php if ( $name ) : ?>
                                    <span class="haiia-sponsor-name"><?php echo esc_html( $name ); ?></span>
                                    <?php endif; ?>
                                <?php if ( $url ) : ?>
                                </a>
                                <?php endif; ?>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                    <?php endif; ?>

                    <!-- ゴールドスポンサー -->
                    <?php
                    $gold_logos = get_field( 'sponsors_gold' );
                    if ( $gold_logos ) : ?>
                    <section class="haiia-sponsors-section haiia-sponsors-gold" id="gold">
                        <h2 class="haiia-sponsors-h2">
                            <span class="haiia-sponsor-tier gold">Gold</span>
                            ゴールドスポンサー
                        </h2>
                        <div class="haiia-sponsors-grid haiia-sponsors-grid--gold">
                            <?php foreach ( $gold_logos as $logo ) :
                                $url = $logo['caption'] ? esc_url( $logo['caption'] ) : '';
                                $name = $logo['title'] ? esc_attr( $logo['title'] ) : '';
                            ?>
                            <div class="haiia-sponsor-item">
                                <?php if ( $url ) : ?>
                                <a href="<?php echo $url; ?>" target="_blank" rel="noopener noreferrer" class="haiia-sponsor-link">
                                <?php endif; ?>
                                    <img src="<?php echo esc_url( $logo['url'] ); ?>" alt="<?php echo $name; ?>" class="haiia-sponsor-logo">
                                    <?php if ( $name ) : ?>
                                    <span class="haiia-sponsor-name"><?php echo esc_html( $name ); ?></span>
                                    <?php endif; ?>
                                <?php if ( $url ) : ?>
                                </a>
                                <?php endif; ?>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                    <?php endif; ?>

                    <!-- シルバースポンサー -->
                    <?php
                    $silver_logos = get_field( 'sponsors_silver' );
                    if ( $silver_logos ) : ?>
                    <section class="haiia-sponsors-section haiia-sponsors-silver" id="silver">
                        <h2 class="haiia-sponsors-h2">
                            <span class="haiia-sponsor-tier silver">Silver</span>
                            シルバースポンサー
                        </h2>
                        <div class="haiia-sponsors-grid haiia-sponsors-grid--silver">
                            <?php foreach ( $silver_logos as $logo ) :
                                $url = $logo['caption'] ? esc_url( $logo['caption'] ) : '';
                                $name = $logo['title'] ? esc_attr( $logo['title'] ) : '';
                            ?>
                            <div class="haiia-sponsor-item">
                                <?php if ( $url ) : ?>
                                <a href="<?php echo $url; ?>" target="_blank" rel="noopener noreferrer" class="haiia-sponsor-link">
                                <?php endif; ?>
                                    <img src="<?php echo esc_url( $logo['url'] ); ?>" alt="<?php echo $name; ?>" class="haiia-sponsor-logo">
                                    <?php if ( $name ) : ?>
                                    <span class="haiia-sponsor-name"><?php echo esc_html( $name ); ?></span>
                                    <?php endif; ?>
                                <?php if ( $url ) : ?>
                                </a>
                                <?php endif; ?>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                    <?php endif; ?>

                    <!-- ブロンズスポンサー -->
                    <?php
                    $bronze_logos = get_field( 'sponsors_bronze' );
                    if ( $bronze_logos ) : ?>
                    <section class="haiia-sponsors-section haiia-sponsors-bronze" id="bronze">
                        <h2 class="haiia-sponsors-h2">
                            <span class="haiia-sponsor-tier bronze">Bronze</span>
                            ブロンズスポンサー
                        </h2>
                        <div class="haiia-sponsors-grid haiia-sponsors-grid--bronze">
                            <?php foreach ( $bronze_logos as $logo ) :
                                $url = $logo['caption'] ? esc_url( $logo['caption'] ) : '';
                                $name = $logo['title'] ? esc_attr( $logo['title'] ) : '';
                            ?>
                            <div class="haiia-sponsor-item">
                                <?php if ( $url ) : ?>
                                <a href="<?php echo $url; ?>" target="_blank" rel="noopener noreferrer" class="haiia-sponsor-link">
                                <?php endif; ?>
                                    <img src="<?php echo esc_url( $logo['url'] ); ?>" alt="<?php echo $name; ?>" class="haiia-sponsor-logo">
                                    <?php if ( $name ) : ?>
                                    <span class="haiia-sponsor-name"><?php echo esc_html( $name ); ?></span>
                                    <?php endif; ?>
                                <?php if ( $url ) : ?>
                                </a>
                                <?php endif; ?>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                    <?php endif; ?>

                    <!-- 一般法人賛助会員 -->
                    <?php
                    $general_logos = get_field( 'sponsors_general' );
                    if ( $general_logos ) : ?>
                    <section class="haiia-sponsors-section haiia-sponsors-general" id="general">
                        <h2 class="haiia-sponsors-h2">法人賛助会員</h2>
                        <div class="haiia-sponsors-grid haiia-sponsors-grid--general">
                            <?php foreach ( $general_logos as $logo ) :
                                $url = $logo['caption'] ? esc_url( $logo['caption'] ) : '';
                                $name = $logo['title'] ? esc_attr( $logo['title'] ) : '';
                            ?>
                            <div class="haiia-sponsor-item">
                                <?php if ( $url ) : ?>
                                <a href="<?php echo $url; ?>" target="_blank" rel="noopener noreferrer" class="haiia-sponsor-link">
                                <?php endif; ?>
                                    <img src="<?php echo esc_url( $logo['url'] ); ?>" alt="<?php echo $name; ?>" class="haiia-sponsor-logo">
                                    <?php if ( $name ) : ?>
                                    <span class="haiia-sponsor-name"><?php echo esc_html( $name ); ?></span>
                                    <?php endif; ?>
                                <?php if ( $url ) : ?>
                                </a>
                                <?php endif; ?>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                    <?php endif; ?>

                    <!-- 賛助会員募集CTA -->
                    <?php
                    $cta_text = get_field( 'sponsors_cta_text' );
                    $cta_button_text = get_field( 'sponsors_cta_button' );
                    $cta_url = get_field( 'sponsors_cta_url' );
                    ?>
                    <section class="haiia-sponsors-cta">
                        <div class="haiia-cta-content">
                            <?php if ( $cta_text ) : ?>
                                <p><?php echo wp_kses_post( $cta_text ); ?></p>
                            <?php else : ?>
                                <p>HAIIAの活動にご賛同いただける法人様を募集しています。<br>法人賛助会員として、AI教育の普及にご協力ください。</p>
                            <?php endif; ?>
                            <?php if ( $cta_url ) : ?>
                            <a href="<?php echo esc_url( $cta_url ); ?>" class="haiia-cta-btn">
                                <?php echo $cta_button_text ? esc_html( $cta_button_text ) : '賛助会員のご案内'; ?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                            </a>
                            <?php endif; ?>
                        </div>
                    </section>

                </div><!-- .entry-body -->
            </article>

            <?php do_action( 'lightning_main_section_append', 'lightning_main_section_append' ); ?>
        </div><!-- [ /.main-section ] -->

    </div><!-- [ /.site-body-container ] -->

    <?php do_action( 'lightning_site_body_append', 'lightning_site_body_append' ); ?>

</div><!-- [ /.site-body ] -->

<?php if ( is_active_sidebar( 'footer-before-widget' ) ) : ?>
<div class="site-body-bottom">
    <div class="container">
        <?php dynamic_sidebar( 'footer-before-widget' ); ?>
    </div>
</div>
<?php endif; ?>

<?php
do_action( 'lightning_site_footer_before', 'lightning_site_footer_before' );
if ( apply_filters( 'lightning_is_site_footer', true, 'site_footer' ) ) {
    lightning_get_template_part( 'template-parts/site-footer' );
}
do_action( 'lightning_site_footer_after', 'lightning_site_footer_after' );

get_footer();
?>
