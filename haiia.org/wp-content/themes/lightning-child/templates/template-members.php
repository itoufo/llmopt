<?php
/**
 * Template Name: 会員限定
 * Description: HAIIA会員限定コンテンツページ
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

<!-- ページヘッダー -->
<div class="haiia-page-header">
    <div class="container">
        <h1 class="haiia-page-title">会員限定</h1>
        <p class="haiia-page-subtitle">Members Only</p>
    </div>
</div>

<?php do_action( 'lightning_site_body_before', 'lightning_site_body_before' ); ?>

<div class="<?php lightning_the_class_name( 'site-body' ); ?> haiia-members">
    <?php do_action( 'lightning_site_body_prepend', 'lightning_site_body_prepend' ); ?>

    <div class="<?php lightning_the_class_name( 'site-body-container' ); ?> container">

        <div class="<?php lightning_the_class_name( 'main-section' ); ?> main-section--margin-bottom--on" id="main" role="main">
            <?php do_action( 'lightning_main_section_prepend', 'lightning_main_section_prepend' ); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class( 'entry entry-full' ); ?>>
                <div class="entry-body haiia-activities-content">

                    <?php if ( function_exists( 'pmpro_hasMembershipLevel' ) && pmpro_hasMembershipLevel() ) : ?>
                        <!-- 会員向けコンテンツ -->
                        <?php the_content(); ?>

                    <?php else : ?>
                        <!-- 非会員向けメッセージ -->
                        <section class="haiia-activities-section haiia-members-guest">
                            <div class="haiia-members-lock-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                            </div>
                            <h2 class="haiia-members-title">会員限定コンテンツです</h2>
                            <p class="haiia-members-desc">
                                このページは会員様専用のコンテンツです。<br>
                                会員登録いただくと、限定レポートやオンライン学習プラットフォームへのアクセスが可能になります。
                            </p>
                            <div class="haiia-members-cta">
                                <a href="/membership-account/membership-levels/" class="haiia-btn-primary-large">会員登録はこちら</a>
                                <a href="/membership-account/membership-login/" class="haiia-btn-outline-large">ログイン</a>
                            </div>
                        </section>

                        <!-- 会員特典の紹介 -->
                        <section class="haiia-activities-section">
                            <h3 class="haiia-activities-h3">会員特典</h3>
                            <div class="haiia-activities-mvv-grid">
                                <div class="haiia-activities-mvv-item">
                                    <span class="haiia-activities-mvv-label">限定レポート</span>
                                    <p>AI教育に関する<strong>調査レポート</strong>の全文が閲覧可能</p>
                                </div>
                                <div class="haiia-activities-mvv-item">
                                    <span class="haiia-activities-mvv-label">学習プラットフォーム</span>
                                    <p><strong>HAIIA School</strong>でオンライン学習コンテンツにアクセス</p>
                                </div>
                                <div class="haiia-activities-mvv-item">
                                    <span class="haiia-activities-mvv-label">イベント優先</span>
                                    <p>セミナーやワークショップへの<strong>優先参加</strong></p>
                                </div>
                            </div>
                        </section>
                    <?php endif; ?>

                </div>
            </article>

            <?php do_action( 'lightning_main_section_append', 'lightning_main_section_append' ); ?>
        </div>

    </div>

    <?php do_action( 'lightning_site_body_append', 'lightning_site_body_append' ); ?>
</div>

<?php do_action( 'lightning_site_body_after', 'lightning_site_body_after' ); ?>

<?php get_footer(); ?>
