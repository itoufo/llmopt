<?php
/**
 * Template Name: HAIIA記事テンプレート
 * Description: LLMO最適化済み記事テンプレート（EEAT対応、構造化データ、FAQ含む）
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// 記事メタ情報（カスタムフィールドから取得）
$article_category = get_post_meta( get_the_ID(), 'haiia_article_category', true ) ?: 'AI教育';
$article_author_name = get_post_meta( get_the_ID(), 'haiia_author_name', true ) ?: '健全AI教育協会';
$article_author_title = get_post_meta( get_the_ID(), 'haiia_author_title', true ) ?: 'HAIIA編集部';
$article_author_credentials = get_post_meta( get_the_ID(), 'haiia_author_credentials', true ) ?: '';
$article_read_time = get_post_meta( get_the_ID(), 'haiia_read_time', true ) ?: '5';
$article_updated = get_the_modified_date( 'Y-m-d' );
$article_published = get_the_date( 'Y-m-d' );

// FAQ データ（カスタムフィールドから取得、JSON形式）
$faq_json = get_post_meta( get_the_ID(), 'haiia_faq_data', true );
$faq_data = $faq_json ? json_decode( $faq_json, true ) : array();

get_header();
?>

<!-- 構造化データ: Article Schema -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Article",
    "headline": "<?php echo esc_js( get_the_title() ); ?>",
    "description": "<?php echo esc_js( get_the_excerpt() ); ?>",
    "image": "<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'full' ) ?: get_template_directory_uri() . '/assets/images/ogp-default.png' ); ?>",
    "datePublished": "<?php echo esc_attr( $article_published ); ?>",
    "dateModified": "<?php echo esc_attr( $article_updated ); ?>",
    "author": {
        "@type": "Organization",
        "name": "<?php echo esc_js( $article_author_name ); ?>",
        "url": "https://haiia.or.jp"
    },
    "publisher": {
        "@type": "Organization",
        "name": "一般社団法人 健全AI教育協会（HAIIA）",
        "logo": {
            "@type": "ImageObject",
            "url": "https://haiia.or.jp/wp-content/themes/lightning-child/assets/images/logo.png"
        }
    },
    "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "<?php echo esc_url( get_permalink() ); ?>"
    }
}
</script>

<!-- 構造化データ: Organization Schema -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "一般社団法人 健全AI教育協会",
    "alternateName": "HAIIA",
    "url": "https://haiia.or.jp",
    "description": "生成AI時代にふさわしい健全な教育を普及する一般社団法人",
    "foundingDate": "2025-06-26",
    "address": {
        "@type": "PostalAddress",
        "streetAddress": "新橋4-14-1 新橋AUNBLDG.4F",
        "addressLocality": "港区",
        "addressRegion": "東京都",
        "postalCode": "105-0004",
        "addressCountry": "JP"
    },
    "sameAs": [
        "https://twitter.com/haiia_org"
    ]
}
</script>

<!-- 構造化データ: BreadcrumbList -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
        {
            "@type": "ListItem",
            "position": 1,
            "name": "ホーム",
            "item": "https://haiia.or.jp"
        },
        {
            "@type": "ListItem",
            "position": 2,
            "name": "記事一覧",
            "item": "https://haiia.or.jp/articles/"
        },
        {
            "@type": "ListItem",
            "position": 3,
            "name": "<?php echo esc_js( get_the_title() ); ?>",
            "item": "<?php echo esc_url( get_permalink() ); ?>"
        }
    ]
}
</script>

<?php if ( ! empty( $faq_data ) ) : ?>
<!-- 構造化データ: FAQPage Schema -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
        <?php
        $faq_items = array();
        foreach ( $faq_data as $faq ) {
            $faq_items[] = '{
                "@type": "Question",
                "name": "' . esc_js( $faq['question'] ) . '",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "' . esc_js( $faq['answer'] ) . '"
                }
            }';
        }
        echo implode( ",\n        ", $faq_items );
        ?>
    ]
}
</script>
<?php endif; ?>

<?php
do_action( 'lightning_site_header_before', 'lightning_site_header_before' );
if ( apply_filters( 'lightning_is_site_header', true, 'site_header' ) ) {
    lightning_get_template_part( 'template-parts/site-header' );
}
do_action( 'lightning_site_header_after', 'lightning_site_header_after' );
?>

<!-- ページヘッダー -->
<div class="haiia-article-header">
    <div class="container">
        <div class="haiia-article-meta-top">
            <span class="haiia-article-category"><?php echo esc_html( $article_category ); ?></span>
            <span class="haiia-article-read-time"><?php echo esc_html( $article_read_time ); ?>分で読める</span>
        </div>
        <h1 class="haiia-article-title"><?php the_title(); ?></h1>
        <p class="haiia-article-excerpt"><?php echo get_the_excerpt(); ?></p>
        <div class="haiia-article-meta-bottom">
            <div class="haiia-article-dates">
                <span class="haiia-article-published">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                    公開: <?php echo esc_html( get_the_date( 'Y年n月j日' ) ); ?>
                </span>
                <?php if ( get_the_modified_date() !== get_the_date() ) : ?>
                <span class="haiia-article-updated">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.5 2v6h-6M2.5 22v-6h6M2 11.5a10 10 0 0 1 18.8-4.3M22 12.5a10 10 0 0 1-18.8 4.2"/></svg>
                    更新: <?php echo esc_html( get_the_modified_date( 'Y年n月j日' ) ); ?>
                </span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php do_action( 'lightning_site_body_before', 'lightning_site_body_before' ); ?>

<div class="<?php lightning_the_class_name( 'site-body' ); ?> haiia-article">
    <?php do_action( 'lightning_site_body_prepend', 'lightning_site_body_prepend' ); ?>

    <div class="<?php lightning_the_class_name( 'site-body-container' ); ?> container">

        <div class="<?php lightning_the_class_name( 'main-section' ); ?> main-section--margin-bottom--on" id="main" role="main">
            <?php do_action( 'lightning_main_section_prepend', 'lightning_main_section_prepend' ); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class( 'entry entry-full haiia-article-entry' ); ?>>

                <!-- EEAT: 著者情報（冒頭） -->
                <aside class="haiia-article-author-box haiia-article-author-top">
                    <div class="haiia-author-avatar">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/haiia-logo-icon.png" alt="<?php echo esc_attr( $article_author_name ); ?>" width="48" height="48" loading="lazy">
                    </div>
                    <div class="haiia-author-info">
                        <span class="haiia-author-label">この記事の執筆者</span>
                        <span class="haiia-author-name"><?php echo esc_html( $article_author_name ); ?></span>
                        <?php if ( $article_author_title ) : ?>
                        <span class="haiia-author-title"><?php echo esc_html( $article_author_title ); ?></span>
                        <?php endif; ?>
                        <?php if ( $article_author_credentials ) : ?>
                        <span class="haiia-author-credentials"><?php echo esc_html( $article_author_credentials ); ?></span>
                        <?php endif; ?>
                    </div>
                </aside>

                <!-- 目次 -->
                <nav class="haiia-article-toc" aria-label="目次">
                    <div class="haiia-toc-header">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                        <span>目次</span>
                    </div>
                    <div class="haiia-toc-content" id="haiia-toc-list">
                        <!-- JavaScript で自動生成 -->
                    </div>
                </nav>

                <!-- 記事本文 -->
                <div class="entry-body haiia-article-content">
                    <?php the_content(); ?>
                </div>

                <!-- FAQ セクション -->
                <?php if ( ! empty( $faq_data ) ) : ?>
                <section class="haiia-article-faq" id="faq">
                    <h2>よくある質問（FAQ）</h2>
                    <div class="haiia-faq-list">
                        <?php foreach ( $faq_data as $index => $faq ) : ?>
                        <details class="haiia-faq-item" <?php echo $index === 0 ? 'open' : ''; ?>>
                            <summary class="haiia-faq-question">
                                <span class="haiia-faq-q-icon">Q</span>
                                <span class="haiia-faq-q-text"><?php echo esc_html( $faq['question'] ); ?></span>
                                <svg class="haiia-faq-toggle" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                            </summary>
                            <div class="haiia-faq-answer">
                                <span class="haiia-faq-a-icon">A</span>
                                <div class="haiia-faq-a-text"><?php echo wp_kses_post( $faq['answer'] ); ?></div>
                            </div>
                        </details>
                        <?php endforeach; ?>
                    </div>
                </section>
                <?php endif; ?>

                <!-- まとめセクション -->
                <section class="haiia-article-summary" id="summary">
                    <h2>まとめ</h2>
                    <div class="haiia-summary-content">
                        <?php
                        $summary = get_post_meta( get_the_ID(), 'haiia_article_summary', true );
                        if ( $summary ) {
                            echo wp_kses_post( $summary );
                        }
                        ?>
                    </div>
                </section>

                <!-- EEAT: 著者情報（詳細版・記事末尾） -->
                <aside class="haiia-article-author-box haiia-article-author-bottom">
                    <h3>この記事を書いた組織</h3>
                    <div class="haiia-author-detail">
                        <div class="haiia-author-avatar-large">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/haiia-logo.png" alt="健全AI教育協会" width="120" height="120" loading="lazy">
                        </div>
                        <div class="haiia-author-bio">
                            <h4>一般社団法人 健全AI教育協会（HAIIA）</h4>
                            <p>2025年設立。「生成AI時代にふさわしい健全な教育を普及する」をミッションに、AI時代に必要な4つの力（コミュニケーション力・言語力・セルフコーチング力・プロジェクトマネジメント力）の育成を推進。誰一人取り残さないインクルーシブなAI教育の実現を目指しています。</p>
                            <div class="haiia-author-credentials-list">
                                <span>次世代AI教育スタンダード策定</span>
                                <span>AI倫理5原則の提唱</span>
                                <span>P-A-I-Cサイクル学習フレーム開発</span>
                            </div>
                            <a href="/about/" class="haiia-author-link">協会について詳しく見る →</a>
                        </div>
                    </div>
                </aside>

                <!-- 関連記事 -->
                <section class="haiia-article-related">
                    <h2>関連記事</h2>
                    <div class="haiia-related-grid">
                        <?php
                        $related_posts = get_posts( array(
                            'numberposts' => 3,
                            'post__not_in' => array( get_the_ID() ),
                            'orderby' => 'rand',
                        ) );
                        foreach ( $related_posts as $post ) : setup_postdata( $post );
                        ?>
                        <a href="<?php the_permalink(); ?>" class="haiia-related-item">
                            <?php if ( has_post_thumbnail() ) : ?>
                            <div class="haiia-related-thumb"><?php the_post_thumbnail( 'medium' ); ?></div>
                            <?php endif; ?>
                            <h4><?php the_title(); ?></h4>
                        </a>
                        <?php endforeach; wp_reset_postdata(); ?>
                    </div>
                </section>

                <!-- CTA セクション -->
                <section class="haiia-article-cta">
                    <div class="haiia-cta-content">
                        <h3>AI教育について相談する</h3>
                        <p>HAIIAでは、教育機関・企業・個人向けにAI教育のコンサルティング・研修を提供しています。お気軽にお問い合わせください。</p>
                        <div class="haiia-cta-buttons">
                            <a href="/contact/" class="haiia-cta-primary">お問い合わせ</a>
                            <a href="/programs/" class="haiia-cta-secondary">プログラム一覧</a>
                        </div>
                    </div>
                </section>

            </article>

            <?php do_action( 'lightning_main_section_append', 'lightning_main_section_append' ); ?>
        </div><!-- [ /.main-section ] -->

    </div><!-- [ /.site-body-container ] -->

    <?php do_action( 'lightning_site_body_append', 'lightning_site_body_append' ); ?>

</div><!-- [ /.site-body ] -->

<!-- 目次自動生成スクリプト -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const content = document.querySelector('.haiia-article-content');
    const tocList = document.getElementById('haiia-toc-list');
    if (!content || !tocList) return;

    const headings = content.querySelectorAll('h2, h3');
    if (headings.length === 0) {
        document.querySelector('.haiia-article-toc').style.display = 'none';
        return;
    }

    let tocHTML = '<ul>';
    headings.forEach(function(heading, index) {
        const id = 'section-' + index;
        heading.id = id;
        const level = heading.tagName === 'H2' ? 'toc-h2' : 'toc-h3';
        tocHTML += '<li class="' + level + '"><a href="#' + id + '">' + heading.textContent + '</a></li>';
    });
    tocHTML += '</ul>';
    tocList.innerHTML = tocHTML;
});
</script>

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
