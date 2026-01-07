<?php
/**
 * HAIIA記事詳細（投稿用テンプレート）
 *
 * 「HAIIA記事」カテゴリ（スラッグ: haiia-article）の投稿に自動適用されます。
 * LLMO最適化: EEAT、構造化データ、FAQ対応
 */

// SEO用構造化データ（Article + FAQPage + Organization）
add_action( 'wp_head', function() {
	if ( ! is_singular() ) return;

	$post_id = get_the_ID();

	// Article Schema
	$article_schema = array(
		'@context' => 'https://schema.org',
		'@type' => 'Article',
		'headline' => get_the_title( $post_id ),
		'datePublished' => get_the_date( 'c', $post_id ),
		'dateModified' => get_the_modified_date( 'c', $post_id ),
		'author' => array(
			'@type' => 'Organization',
			'name' => '一般社団法人 健全AI教育協会（HAIIA）',
			'url' => 'https://haiia.org',
			'logo' => array(
				'@type' => 'ImageObject',
				'url' => 'https://haiia.org/wp-content/uploads/haiia-logo.png'
			)
		),
		'publisher' => array(
			'@type' => 'Organization',
			'name' => '一般社団法人 健全AI教育協会（HAIIA）',
			'url' => 'https://haiia.org',
			'logo' => array(
				'@type' => 'ImageObject',
				'url' => 'https://haiia.org/wp-content/uploads/haiia-logo.png'
			)
		),
		'description' => get_the_excerpt( $post_id ),
		'mainEntityOfPage' => array(
			'@type' => 'WebPage',
			'@id' => get_permalink( $post_id )
		),
		'isAccessibleForFree' => true,
		'inLanguage' => 'ja'
	);

	if ( has_post_thumbnail( $post_id ) ) {
		$article_schema['image'] = get_the_post_thumbnail_url( $post_id, 'large' );
	}

	echo '<script type="application/ld+json">' . wp_json_encode( $article_schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";

	// BreadcrumbList Schema
	$breadcrumb_schema = array(
		'@context' => 'https://schema.org',
		'@type' => 'BreadcrumbList',
		'itemListElement' => array(
			array(
				'@type' => 'ListItem',
				'position' => 1,
				'name' => 'Home',
				'item' => home_url( '/' )
			),
			array(
				'@type' => 'ListItem',
				'position' => 2,
				'name' => 'AI教育記事',
				'item' => home_url( '/articles/' )
			),
			array(
				'@type' => 'ListItem',
				'position' => 3,
				'name' => get_the_title( $post_id ),
				'item' => get_permalink( $post_id )
			)
		)
	);

	echo '<script type="application/ld+json">' . wp_json_encode( $breadcrumb_schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";

	// Organization Schema (EEAT強化)
	$org_schema = array(
		'@context' => 'https://schema.org',
		'@type' => 'Organization',
		'name' => '一般社団法人 健全AI教育協会（HAIIA）',
		'alternateName' => 'HAIIA',
		'url' => 'https://haiia.org',
		'description' => 'AI時代に必要な4つの力（コミュニケーション力・言語力・セルフコーチング力・プロジェクトマネジメント力）を体系的に育成する教育を推進する一般社団法人です。',
		'foundingDate' => '2024',
		'areaServed' => 'JP',
		'sameAs' => array(
			'https://twitter.com/haiia_org'
		)
	);

	echo '<script type="application/ld+json">' . wp_json_encode( $org_schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}, 5 );

// HTMLヘッド部分
lightning_get_template_part( 'header' );

// サイトヘッダー
do_action( 'lightning_site_header_before', 'lightning_site_header_before' );
if ( apply_filters( 'lightning_is_site_header', true, 'site_header' ) ) {
	lightning_get_template_part( 'template-parts/site-header' );
}
do_action( 'lightning_site_header_after', 'lightning_site_header_after' );

// パンくずリスト
do_action( 'lightning_breadcrumb_before', 'lightning_breadcrumb_before' );
$article_category = get_category_by_slug( 'haiia-article' );
$category_url = $article_category ? get_category_link( $article_category->term_id ) : home_url( '/articles/' );
$category_name = $article_category ? $article_category->name : 'AI教育記事';
?>
<div id="breadcrumb" class="breadcrumb">
	<div class="container">
		<ol class="breadcrumb-list">
			<li class="breadcrumb-list__item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
			<li class="breadcrumb-list__item"><a href="<?php echo esc_url( $category_url ); ?>"><?php echo esc_html( $category_name ); ?></a></li>
			<li class="breadcrumb-list__item"><?php the_title(); ?></li>
		</ol>
	</div>
</div>
<?php
do_action( 'lightning_breadcrumb_after', 'lightning_breadcrumb_after' );

do_action( 'lightning_site_body_before', 'lightning_site_body_before' );
?>

<div class="<?php lightning_the_class_name( 'site-body' ); ?>">
	<?php do_action( 'lightning_site_body_prepend', 'lightning_site_body_prepend' ); ?>
	<div class="<?php lightning_the_class_name( 'site-body-container' ); ?> container">

		<div class="<?php lightning_the_class_name( 'main-section' ); ?>" id="main" role="main">
			<?php do_action( 'lightning_main_section_prepend', 'lightning_main_section_prepend' ); ?>

			<?php while ( have_posts() ) : the_post(); ?>
			<?php
			// ACFフィールドを取得
			$article_category_label = get_field( 'article_category_label' ) ?: 'AI教育';
			$article_read_time = get_field( 'article_read_time' ) ?: '5分';
			$article_excerpt = get_field( 'article_excerpt' ) ?: get_the_excerpt();
			$article_keywords = get_field( 'article_keywords' );
			?>
			<article <?php post_class( 'haiia-article-single' ); ?>>

				<!-- 記事ヘッダー -->
				<header class="haiia-article-header-single">
					<div class="haiia-article-meta-top">
						<span class="haiia-article-category"><?php echo esc_html( $article_category_label ); ?></span>
						<span class="haiia-article-read-time">
							<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
								<circle cx="12" cy="12" r="10"></circle>
								<polyline points="12 6 12 12 16 14"></polyline>
							</svg>
							読了時間：<?php echo esc_html( $article_read_time ); ?>
						</span>
					</div>
					<h1 class="haiia-article-title"><?php the_title(); ?></h1>
					<?php if ( $article_excerpt ) : ?>
					<p class="haiia-article-excerpt"><?php echo esc_html( $article_excerpt ); ?></p>
					<?php endif; ?>
					<div class="haiia-article-meta-bottom">
						<div class="haiia-article-dates">
							<span>
								<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
									<rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
									<line x1="16" y1="2" x2="16" y2="6"></line>
									<line x1="8" y1="2" x2="8" y2="6"></line>
									<line x1="3" y1="10" x2="21" y2="10"></line>
								</svg>
								公開：<?php echo get_the_date( 'Y年n月j日' ); ?>
							</span>
							<?php if ( get_the_date() !== get_the_modified_date() ) : ?>
							<span>
								<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
									<path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
									<path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
								</svg>
								更新：<?php echo get_the_modified_date( 'Y年n月j日' ); ?>
							</span>
							<?php endif; ?>
						</div>
					</div>
				</header>

				<?php if ( has_post_thumbnail() ) : ?>
				<div class="haiia-article-featured-image">
					<?php the_post_thumbnail( 'large' ); ?>
				</div>
				<?php endif; ?>

				<!-- 著者情報（EEAT） -->
				<div class="haiia-article-author-box">
					<div class="haiia-article-author-top">
						<div class="haiia-author-avatar-text"><?php echo mb_substr( get_the_author(), 0, 1 ); ?></div>
						<div class="haiia-author-info">
							<span class="haiia-author-label">執筆・監修</span>
							<span class="haiia-author-name"><?php the_author(); ?></span>
							<span class="haiia-author-title">一般社団法人 健全AI教育協会（HAIIA）</span>
						</div>
					</div>
				</div>

				<!-- 目次 -->
				<nav class="haiia-article-toc">
					<div class="haiia-toc-header">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<line x1="8" y1="6" x2="21" y2="6"></line>
							<line x1="8" y1="12" x2="21" y2="12"></line>
							<line x1="8" y1="18" x2="21" y2="18"></line>
							<line x1="3" y1="6" x2="3.01" y2="6"></line>
							<line x1="3" y1="12" x2="3.01" y2="12"></line>
							<line x1="3" y1="18" x2="3.01" y2="18"></line>
						</svg>
						目次
					</div>
					<div class="haiia-toc-content" id="toc-content">
						<!-- JavaScriptで自動生成 -->
					</div>
				</nav>

				<!-- 本文（WordPressエディタ） -->
				<div class="haiia-article-content" id="article-content">
					<?php the_content(); ?>
				</div>

				<!-- まとめ -->
				<?php $article_summary = get_field( 'article_summary' ); ?>
				<?php if ( $article_summary ) : ?>
				<div class="haiia-article-summary">
					<h2>この記事のまとめ</h2>
					<div class="haiia-summary-content">
						<?php echo $article_summary; ?>
					</div>
				</div>
				<?php endif; ?>

				<!-- FAQ -->
				<?php $article_faq = get_field( 'article_faq' ); ?>
				<?php if ( $article_faq ) : ?>
				<section class="haiia-article-faq">
					<h2>よくある質問</h2>
					<div class="haiia-faq-list">
						<?php foreach ( $article_faq as $index => $faq ) : ?>
						<details class="haiia-faq-item">
							<summary class="haiia-faq-question">
								<span class="haiia-faq-q-icon">Q</span>
								<span class="haiia-faq-q-text"><?php echo esc_html( $faq['question'] ); ?></span>
								<svg class="haiia-faq-toggle" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
									<polyline points="6 9 12 15 18 9"></polyline>
								</svg>
							</summary>
							<div class="haiia-faq-answer">
								<span class="haiia-faq-a-icon">A</span>
								<span class="haiia-faq-a-text"><?php echo wp_kses_post( $faq['answer'] ); ?></span>
							</div>
						</details>
						<?php endforeach; ?>
					</div>
				</section>

				<!-- FAQ構造化データ -->
				<script type="application/ld+json">
				{
					"@context": "https://schema.org",
					"@type": "FAQPage",
					"mainEntity": [
						<?php foreach ( $article_faq as $index => $faq ) : ?>
						{
							"@type": "Question",
							"name": <?php echo wp_json_encode( $faq['question'] ); ?>,
							"acceptedAnswer": {
								"@type": "Answer",
								"text": <?php echo wp_json_encode( strip_tags( $faq['answer'] ) ); ?>
							}
						}<?php echo ( $index < count( $article_faq ) - 1 ) ? ',' : ''; ?>
						<?php endforeach; ?>
					]
				}
				</script>
				<?php endif; ?>

				<!-- 関連記事 -->
				<?php
				$related_posts = get_posts( array(
					'category__in' => wp_get_post_categories( $post_id ),
					'numberposts' => 3,
					'post__not_in' => array( $post_id ),
				) );
				if ( $related_posts ) :
				?>
				<section class="haiia-article-related">
					<h2>関連記事</h2>
					<div class="haiia-related-grid">
						<?php foreach ( $related_posts as $related ) : ?>
						<a href="<?php echo get_permalink( $related->ID ); ?>" class="haiia-related-item">
							<?php if ( has_post_thumbnail( $related->ID ) ) : ?>
							<div class="haiia-related-thumb">
								<?php echo get_the_post_thumbnail( $related->ID, 'medium' ); ?>
							</div>
							<?php endif; ?>
							<h4><?php echo esc_html( $related->post_title ); ?></h4>
						</a>
						<?php endforeach; ?>
					</div>
				</section>
				<?php endif; ?>

				<!-- CTA -->
				<div class="haiia-article-cta">
					<h3>AI教育の最新情報をお届けします</h3>
					<p>HAIIAでは、次世代AI教育に関する最新の知見やイベント情報を発信しています。会員登録（無料）で、すべてのコンテンツにアクセスいただけます。</p>
					<div class="haiia-cta-buttons">
						<a href="<?php echo esc_url( wp_registration_url() ); ?>" class="haiia-cta-primary">無料会員登録</a>
						<a href="<?php echo esc_url( home_url( '/about/' ) ); ?>" class="haiia-cta-secondary">HAIIAについて</a>
					</div>
				</div>

				<!-- 詳細な著者情報（EEAT強化） -->
				<div class="haiia-article-author-box haiia-article-author-bottom">
					<h3>この記事を執筆・監修した組織</h3>
					<div class="haiia-author-detail">
						<div class="haiia-author-avatar-large">
							<img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/images/haiia-logo.png" alt="HAIIA" width="120" height="120" onerror="this.style.display='none'">
						</div>
						<div class="haiia-author-bio">
							<h4>一般社団法人 健全AI教育協会（HAIIA）</h4>
							<p>AI時代に必要な「4つの力」（コミュニケーション力・言語力・セルフコーチング力・プロジェクトマネジメント力）を体系的に育成する教育を推進しています。「誰一人取り残さない」AI教育の実現を目指し、次世代AI教育スタンダードの策定・普及活動を行っています。</p>
							<div class="haiia-author-credentials-list">
								<span>次世代AI教育スタンダード策定</span>
								<span>P-A-I-Cサイクル開発</span>
								<span>ユニバーサルプロンプティング</span>
							</div>
							<a href="<?php echo esc_url( home_url( '/about/' ) ); ?>" class="haiia-author-link">協会について詳しく見る →</a>
						</div>
					</div>
				</div>

				<!-- 個人著者情報（投稿者別） -->
				<?php get_template_part( 'template-parts/author-box' ); ?>

				<!-- フッターナビゲーション -->
				<footer class="haiia-article-footer">
					<a href="<?php echo esc_url( $category_url ); ?>" class="back-to-list">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<line x1="19" y1="12" x2="5" y2="12"></line>
							<polyline points="12 19 5 12 12 5"></polyline>
						</svg>
						AI教育記事一覧に戻る
					</a>
				</footer>

			</article>
			<?php endwhile; ?>

		</div><!-- [ /.main-section ] -->

		<?php
		do_action( 'lightning_sub_section_before', 'lightning_sub_section_before' );
		if ( function_exists( 'lightning_is_subsection' ) && lightning_is_subsection() ) {
			lightning_get_template_part( 'sidebar', get_post_type() );
		}
		do_action( 'lightning_sub_section_after', 'lightning_sub_section_after' );
		?>

	</div><!-- [ /.site-body-container ] -->

	<?php do_action( 'lightning_site_body_append', 'lightning_site_body_append' ); ?>

</div><!-- [ /.site-body ] -->

<style>
/* HAIIA記事個別ページ */
.haiia-article-single {
	max-width: 800px;
	margin: 0 auto;
}

/* VK系プラグインの要素を非表示 */
.haiia-article-single .veu_socialSet,
.haiia-article-single .veu_followSet,
.veu_socialSet-position-after,
.veu_contentAddSection {
	display: none !important;
}

/* 記事ヘッダー */
.haiia-article-header-single {
	background: linear-gradient(135deg, #1a365d 0%, #2c5282 50%, #3182ce 100%);
	padding: 3rem 2rem;
	color: #fff;
	border-radius: 1rem;
	margin-bottom: 2rem;
}

.haiia-article-meta-top {
	display: flex;
	align-items: center;
	gap: 1rem;
	margin-bottom: 1.25rem;
	flex-wrap: wrap;
}

.haiia-article-category {
	background: rgba(255, 255, 255, 0.2);
	padding: 0.375rem 1rem;
	border-radius: 2rem;
	font-size: 0.875rem;
	font-weight: 600;
}

.haiia-article-read-time {
	font-size: 0.875rem;
	opacity: 0.9;
	display: flex;
	align-items: center;
	gap: 0.375rem;
}

.haiia-article-title {
	font-size: clamp(1.5rem, 4vw, 2rem);
	font-weight: 800;
	line-height: 1.35;
	margin: 0 0 1rem;
}

.haiia-article-excerpt {
	font-size: 1rem;
	line-height: 1.7;
	opacity: 0.95;
	margin-bottom: 1.25rem;
}

.haiia-article-meta-bottom {
	display: flex;
	align-items: center;
	justify-content: space-between;
	flex-wrap: wrap;
	gap: 1rem;
}

.haiia-article-dates {
	display: flex;
	align-items: center;
	gap: 1.25rem;
	font-size: 0.875rem;
	opacity: 0.9;
	flex-wrap: wrap;
}

.haiia-article-dates span {
	display: flex;
	align-items: center;
	gap: 0.375rem;
}

/* アイキャッチ画像 */
.haiia-article-featured-image {
	margin-bottom: 2rem;
	border-radius: 1rem;
	overflow: hidden;
}

.haiia-article-featured-image img {
	width: 100%;
	height: auto;
	display: block;
}

/* 著者ボックス */
.haiia-article-author-box {
	background: #fff;
	border-radius: 1rem;
	padding: 1.5rem;
	margin-bottom: 2rem;
	box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
}

.haiia-article-author-top {
	display: flex;
	align-items: center;
	gap: 1rem;
	padding-left: 1rem;
	border-left: 4px solid #3182ce;
}

.haiia-author-avatar img {
	border-radius: 50%;
	object-fit: cover;
}

.haiia-author-avatar-text {
	width: 48px;
	height: 48px;
	background: linear-gradient(135deg, #3182ce 0%, #2c5282 100%);
	border-radius: 50%;
	display: flex;
	align-items: center;
	justify-content: center;
	color: #fff;
	font-size: 1.25rem;
	font-weight: 700;
	flex-shrink: 0;
}

.haiia-author-info {
	display: flex;
	flex-direction: column;
	gap: 0.125rem;
}

.haiia-author-label {
	font-size: 0.75rem;
	color: #fff;
}

.haiia-author-name {
	font-weight: 700;
	color: #1e293b;
}

.haiia-author-title {
	font-size: 0.875rem;
	color: #475569;
}

.haiia-author-credentials {
	font-size: 0.75rem;
	color: #3182ce;
}

/* 目次 */
.haiia-article-toc {
	background: #fff;
	border-radius: 1rem;
	padding: 1.5rem;
	margin-bottom: 2rem;
	box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
}

.haiia-toc-header {
	display: flex;
	align-items: center;
	gap: 0.5rem;
	font-weight: 700;
	color: #1e293b;
	margin-bottom: 1rem;
	padding-bottom: 0.75rem;
	border-bottom: 2px solid #e2e8f0;
}

.haiia-toc-content ul {
	list-style: none;
	padding: 0;
	margin: 0;
}

.haiia-toc-content li a {
	display: block;
	padding: 0.5rem 0;
	color: #475569;
	text-decoration: none;
	border-bottom: 1px solid #f1f5f9;
	transition: all 0.2s;
}

.haiia-toc-content li a:hover {
	color: #3182ce;
	padding-left: 0.5rem;
}

.haiia-toc-content .toc-h3 a {
	padding-left: 1.5rem;
	font-size: 0.9375rem;
}

/* 本文 */
.haiia-article-content {
	background: #fff;
	line-height: 1.85;
	color: #334155;
}

.haiia-article-content h2 {
	font-size: 1.5rem;
	font-weight: 800;
	color: #1e293b;
	margin: 2.5rem 0 1.25rem;
	padding-bottom: 0.75rem;
	border-bottom: 3px solid #3182ce;
}

.haiia-article-content h2:first-child {
	margin-top: 0;
}

.haiia-article-content h3 {
	font-size: 1.25rem;
	font-weight: 700;
	color: #1e293b;
	margin: 2rem 0 1rem;
	padding-left: 1rem;
	border-left: 4px solid #3182ce;
}

.haiia-article-content p {
	margin-bottom: 1.5rem;
}

.haiia-article-content ul,
.haiia-article-content ol {
	margin: 1.5rem 0;
	padding-left: 1.5rem;
}

.haiia-article-content li {
	margin-bottom: 0.5rem;
}

.haiia-article-content blockquote {
	background: #f0f9ff;
	border-left: 4px solid #3182ce;
	padding: 1.5rem;
	margin: 2rem 0;
	border-radius: 0 0.75rem 0.75rem 0;
	font-style: italic;
	color: #1e40af;
}

/* まとめ */
.haiia-article-summary {
	background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
	border-radius: 1rem;
	padding: 2rem;
	margin-top: 2rem;
	border: 2px solid #3182ce;
}

.haiia-article-summary h2 {
	font-size: 1.25rem;
	font-weight: 800;
	color: #1e40af;
	margin: 0 0 1rem;
}

.haiia-summary-content {
	color: #1e40af;
	line-height: 1.7;
}

/* FAQ */
.haiia-article-faq {
	background: #fff;
	border-radius: 1rem;
	padding: 2rem;
	margin-top: 2rem;
	box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
}

.haiia-article-faq h2 {
	font-size: 1.25rem;
	font-weight: 800;
	color: #1e293b;
	margin: 0 0 1.25rem;
}

.haiia-faq-list {
	display: flex;
	flex-direction: column;
	gap: 0.75rem;
}

.haiia-faq-item {
	background: #f8fafc;
	border-radius: 0.75rem;
	border: 1px solid #e2e8f0;
	overflow: hidden;
	padding: 1rem;
}

.haiia-faq-question {
	display: flex;
	align-items: center;
	gap: 1rem;
	padding: 1.25rem;
	cursor: pointer;
	font-weight: 600;
	color: #1e293b;
	list-style: none;
}

.haiia-faq-question::-webkit-details-marker {
	display: none;
}

.haiia-faq-q-icon {
	flex-shrink: 0;
	width: 2rem;
	height: 2rem;
	background: #3182ce;
	color: #fff;
	border-radius: 50%;
	display: flex;
	align-items: center;
	justify-content: center;
	font-weight: 800;
	font-size: 0.875rem;
}

.haiia-faq-q-text {
	flex: 1;
}

.haiia-faq-toggle {
	flex-shrink: 0;
	transition: transform 0.2s;
	color: #64748b;
}

.haiia-faq-item[open] .haiia-faq-toggle {
	transform: rotate(180deg);
}

.haiia-faq-answer {
	display: flex;
	gap: 1rem;
	padding: 0 1.25rem 1.25rem;
	color: #475569;
	line-height: 1.7;
}

.haiia-faq-a-icon {
	flex-shrink: 0;
	width: 2rem;
	height: 2rem;
	background: #f59e0b;
	color: #fff;
	border-radius: 50%;
	display: flex;
	align-items: center;
	justify-content: center;
	font-weight: 800;
	font-size: 0.875rem;
}

/* 関連記事 */
.haiia-article-related {
	margin-top: 2.5rem;
}

.haiia-article-related h2 {
	font-size: 1.25rem;
	font-weight: 700;
	color: #1e293b;
	margin: 0 0 1.25rem;
}

.haiia-related-grid {
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
	gap: 1.25rem;
}

.haiia-related-item {
	background: #fff;
	border-radius: 0.75rem;
	overflow: hidden;
	text-decoration: none;
	box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
	transition: all 0.2s;
}

.haiia-related-item:hover {
	transform: translateY(-4px);
	box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
}

.haiia-related-thumb img {
	width: 100%;
	height: 140px;
	object-fit: cover;
}

.haiia-related-item h4 {
	padding: 1rem;
	margin: 0;
	font-size: 0.9375rem;
	font-weight: 600;
	color: #1e293b;
	line-height: 1.5;
}

/* CTA */
.haiia-article-cta {
	background: linear-gradient(135deg, #1a365d 0%, #2c5282 100%);
	border-radius: 1rem;
	padding: 2.5rem;
	margin-top: 2.5rem;
	text-align: center;
	color: #fff;
}

.haiia-article-cta h3 {
	font-size: 1.375rem;
	font-weight: 800;
	margin: 0 0 0.75rem;
}

.haiia-article-cta p {
	opacity: 0.95;
	max-width: 560px;
	margin: 0 auto 1.5rem;
	line-height: 1.7;
}

.haiia-cta-buttons {
	display: flex;
	justify-content: center;
	gap: 1rem;
	flex-wrap: wrap;
}

.haiia-cta-primary {
	background: #fff;
	color: #1a365d;
	padding: 0.875rem 2rem;
	border-radius: 0.5rem;
	font-weight: 700;
	text-decoration: none;
	transition: all 0.2s;
}

.haiia-cta-primary:hover {
	transform: translateY(-2px);
	box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.haiia-cta-secondary {
	background: transparent;
	color: #fff;
	padding: 0.875rem 2rem;
	border-radius: 0.5rem;
	font-weight: 600;
	text-decoration: none;
	border: 2px solid rgba(255, 255, 255, 0.5);
	transition: all 0.2s;
}

.haiia-cta-secondary:hover {
	background: rgba(255, 255, 255, 0.1);
	border-color: #fff;
}

/* 詳細著者情報 */
.haiia-article-author-bottom {
	margin-top: 2.5rem;
	background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
}

.haiia-article-author-bottom h3 {
	font-size: 0.875rem;
	color: #64748b;
	margin: 0 0 1rem;
	font-weight: 600;
}

.haiia-author-detail {
	display: flex;
	gap: 1.5rem;
	align-items: flex-start;
}

.haiia-author-avatar-large img {
	border-radius: 0.75rem;
	object-fit: contain;
}

.haiia-author-bio h4 {
	font-size: 1.125rem;
	margin: 0 0 0.75rem;
	color: #1e293b;
}

.haiia-author-bio p {
	font-size: 0.9375rem;
	line-height: 1.7;
	color: #475569;
	margin-bottom: 1rem;
}

.haiia-author-credentials-list {
	display: flex;
	flex-wrap: wrap;
	gap: 0.5rem;
	margin-bottom: 1rem;
}

.haiia-author-credentials-list span {
	background: #dbeafe;
	color: #1e40af;
	padding: 0.25rem 0.75rem;
	border-radius: 1rem;
	font-size: 0.75rem;
	font-weight: 500;
}

.haiia-author-link {
	color: #3182ce;
	font-weight: 600;
	font-size: 0.9375rem;
	text-decoration: none;
}

.haiia-author-link:hover {
	text-decoration: underline;
}

/* フッター */
.haiia-article-footer {
	margin-top: 2rem;
	padding-top: 1.5rem;
	border-top: 1px solid #e2e8f0;
}

.back-to-list {
	display: inline-flex;
	align-items: center;
	gap: 0.5rem;
	color: #3182ce;
	text-decoration: none;
	font-weight: 500;
}

.back-to-list:hover {
	text-decoration: underline;
}

/* レスポンシブ */
@media (max-width: 768px) {
	.haiia-article-header-single {
		padding: 2rem 1.5rem;
	}

	.haiia-article-content {
		padding: 1.5rem;
	}

	.haiia-article-faq,
	.haiia-article-summary {
		padding: 1.5rem;
	}

	.haiia-article-cta {
		padding: 2rem 1.5rem;
	}

	.haiia-author-detail {
		flex-direction: column;
		align-items: center;
		text-align: center;
	}

	.haiia-author-credentials-list {
		justify-content: center;
	}
}
</style>

<script>
// 目次の自動生成
document.addEventListener('DOMContentLoaded', function() {
	const content = document.getElementById('article-content');
	const tocContent = document.getElementById('toc-content');

	if (!content || !tocContent) return;

	const headings = content.querySelectorAll('h2, h3');
	if (headings.length === 0) {
		document.querySelector('.haiia-article-toc').style.display = 'none';
		return;
	}

	const tocList = document.createElement('ul');

	headings.forEach(function(heading, index) {
		const id = 'section-' + (index + 1);
		heading.id = id;

		const li = document.createElement('li');
		li.className = 'toc-' + heading.tagName.toLowerCase();

		const a = document.createElement('a');
		a.href = '#' + id;
		a.textContent = heading.textContent;

		li.appendChild(a);
		tocList.appendChild(li);
	});

	tocContent.appendChild(tocList);
});
</script>

<?php
do_action( 'lightning_site_footer_before', 'lightning_site_footer_before' );
if ( apply_filters( 'lightning_is_site_footer', true, 'site_footer' ) ) {
	lightning_get_template_part( 'template-parts/site-footer' );
}
do_action( 'lightning_site_footer_after', 'lightning_site_footer_after' );

lightning_get_template_part( 'footer' );
?>
