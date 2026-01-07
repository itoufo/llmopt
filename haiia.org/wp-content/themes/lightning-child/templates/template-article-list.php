<?php
/**
 * Template Name: AI教育記事一覧
 *
 * HAIIA AI教育記事の一覧ページテンプレート
 * LLMO最適化: 構造化データ、カテゴリナビゲーション対応
 */

// SEO用構造化データ
add_action( 'wp_head', function() {
	$schema = array(
		'@context' => 'https://schema.org',
		'@type' => 'CollectionPage',
		'name' => 'AI教育記事一覧',
		'description' => 'HAIIAが発信するAI教育に関する記事・コラム一覧。次世代AI教育スタンダードに基づく実践的な情報をお届けします。',
		'url' => get_permalink(),
		'isPartOf' => array(
			'@type' => 'WebSite',
			'name' => '一般社団法人 健全AI教育協会（HAIIA）',
			'url' => 'https://haiia.org'
		),
		'publisher' => array(
			'@type' => 'Organization',
			'name' => '一般社団法人 健全AI教育協会（HAIIA）',
			'url' => 'https://haiia.org'
		)
	);

	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}, 5 );

get_header();
?>

<div class="haiia-article-list-page">

	<!-- ページヘッダー -->
	<header class="haiia-list-header">
		<div class="container">
			<div class="haiia-list-header-content">
				<span class="haiia-list-subtitle">AI Education Articles</span>
				<h1 class="haiia-list-title">AI教育記事</h1>
				<p class="haiia-list-description">
					次世代AI教育スタンダードに基づく実践的な知見をお届けします。<br>
					AI時代に必要な「4つの力」を育むためのヒントが満載です。
				</p>
			</div>
		</div>
	</header>

	<!-- カテゴリナビゲーション -->
	<nav class="haiia-list-categories">
		<div class="container">
			<div class="haiia-category-tabs">
				<button class="haiia-category-tab active" data-category="all">すべて</button>
				<button class="haiia-category-tab" data-category="4つの力">4つの力</button>
				<button class="haiia-category-tab" data-category="理念思想">理念・思想</button>
				<button class="haiia-category-tab" data-category="実践ガイド">実践ガイド</button>
				<button class="haiia-category-tab" data-category="対象別">対象別</button>
				<button class="haiia-category-tab" data-category="倫理">倫理</button>
			</div>
		</div>
	</nav>

	<!-- 記事一覧 -->
	<main class="haiia-list-main">
		<div class="container">

			<!-- 特集記事 -->
			<?php
			$featured_args = array(
				'category_name' => 'haiia-article',
				'posts_per_page' => 1,
				'meta_key' => 'article_featured',
				'meta_value' => '1',
			);
			$featured_query = new WP_Query( $featured_args );

			if ( $featured_query->have_posts() ) :
				while ( $featured_query->have_posts() ) : $featured_query->the_post();
				$category_label = get_field( 'article_category_label' ) ?: 'AI教育';
				$read_time = get_field( 'article_read_time' ) ?: '5分';
			?>
			<article class="haiia-featured-article">
				<div class="haiia-featured-content">
					<div class="haiia-featured-badge">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
						</svg>
						特集記事
					</div>
					<span class="haiia-article-category"><?php echo esc_html( $category_label ); ?></span>
					<h2 class="haiia-featured-title">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h2>
					<p class="haiia-featured-excerpt"><?php echo wp_trim_words( get_the_excerpt(), 80, '...' ); ?></p>
					<div class="haiia-featured-meta">
						<span class="haiia-article-date">
							<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
								<rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
								<line x1="16" y1="2" x2="16" y2="6"></line>
								<line x1="8" y1="2" x2="8" y2="6"></line>
								<line x1="3" y1="10" x2="21" y2="10"></line>
							</svg>
							<?php echo get_the_date( 'Y.m.d' ); ?>
						</span>
						<span class="haiia-article-read-time">
							<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
								<circle cx="12" cy="12" r="10"></circle>
								<polyline points="12 6 12 12 16 14"></polyline>
							</svg>
							<?php echo esc_html( $read_time ); ?>
						</span>
					</div>
					<a href="<?php the_permalink(); ?>" class="haiia-featured-link">
						記事を読む
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<line x1="5" y1="12" x2="19" y2="12"></line>
							<polyline points="12 5 19 12 12 19"></polyline>
						</svg>
					</a>
				</div>
				<?php if ( has_post_thumbnail() ) : ?>
				<div class="haiia-featured-image">
					<a href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail( 'large' ); ?>
					</a>
				</div>
				<?php endif; ?>
			</article>
			<?php
				endwhile;
				wp_reset_postdata();
			endif;
			?>

			<!-- 記事グリッド -->
			<div class="haiia-articles-grid">
				<?php
				$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
				$articles_args = array(
					'category_name' => 'haiia-article',
					'posts_per_page' => 12,
					'paged' => $paged,
				);
				$articles_query = new WP_Query( $articles_args );

				if ( $articles_query->have_posts() ) :
					while ( $articles_query->have_posts() ) : $articles_query->the_post();
					$category_label = get_field( 'article_category_label' ) ?: 'AI教育';
					$read_time = get_field( 'article_read_time' ) ?: '5分';
				?>
				<article class="haiia-article-card" data-category="<?php echo esc_attr( $category_label ); ?>">
					<?php if ( has_post_thumbnail() ) : ?>
					<a href="<?php the_permalink(); ?>" class="haiia-card-image">
						<?php the_post_thumbnail( 'medium_large' ); ?>
					</a>
					<?php else : ?>
					<a href="<?php the_permalink(); ?>" class="haiia-card-image haiia-card-image-placeholder">
						<svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
							<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
							<polyline points="14 2 14 8 20 8"></polyline>
							<line x1="16" y1="13" x2="8" y2="13"></line>
							<line x1="16" y1="17" x2="8" y2="17"></line>
							<polyline points="10 9 9 9 8 9"></polyline>
						</svg>
					</a>
					<?php endif; ?>
					<div class="haiia-card-content">
						<div class="haiia-card-meta-top">
							<span class="haiia-article-category"><?php echo esc_html( $category_label ); ?></span>
							<span class="haiia-article-read-time"><?php echo esc_html( $read_time ); ?></span>
						</div>
						<h3 class="haiia-card-title">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h3>
						<p class="haiia-card-excerpt"><?php echo wp_trim_words( get_the_excerpt(), 40, '...' ); ?></p>
						<div class="haiia-card-meta-bottom">
							<span class="haiia-article-date"><?php echo get_the_date( 'Y.m.d' ); ?></span>
						</div>
					</div>
				</article>
				<?php
					endwhile;
				else :
				?>
				<div class="haiia-no-articles">
					<svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
						<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
						<polyline points="14 2 14 8 20 8"></polyline>
					</svg>
					<p>記事が見つかりませんでした。</p>
				</div>
				<?php endif; ?>
			</div>

			<!-- ページネーション -->
			<?php if ( $articles_query->max_num_pages > 1 ) : ?>
			<nav class="haiia-pagination">
				<?php
				echo paginate_links( array(
					'total' => $articles_query->max_num_pages,
					'current' => $paged,
					'prev_text' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>',
					'next_text' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>',
				) );
				?>
			</nav>
			<?php endif; ?>

			<?php wp_reset_postdata(); ?>

		</div>
	</main>

	<!-- CTA -->
	<section class="haiia-list-cta">
		<div class="container">
			<div class="haiia-list-cta-inner">
				<h2>AI教育の最新情報を受け取る</h2>
				<p>HAIIAでは、次世代AI教育に関する最新の知見やイベント情報を発信しています。<br>会員登録（無料）で、すべてのコンテンツにアクセスいただけます。</p>
				<div class="haiia-list-cta-buttons">
					<a href="<?php echo esc_url( wp_registration_url() ); ?>" class="haiia-cta-primary">無料会員登録</a>
					<a href="<?php echo esc_url( home_url( '/about/' ) ); ?>" class="haiia-cta-secondary">HAIIAについて</a>
				</div>
			</div>
		</div>
	</section>

</div>

<style>
/* 記事一覧ページ */
.haiia-article-list-page {
	background: #f8fafc;
}

/* ヘッダー */
.haiia-list-header {
	background: linear-gradient(135deg, #1a365d 0%, #2c5282 50%, #3182ce 100%);
	padding: 4rem 0 3rem;
	color: #fff;
}

.haiia-list-header-content {
	text-align: center;
}

.haiia-list-subtitle {
	display: inline-block;
	font-size: 0.875rem;
	font-weight: 600;
	letter-spacing: 0.1em;
	opacity: 0.8;
	margin-bottom: 0.75rem;
}

.haiia-list-title {
	font-size: clamp(2rem, 5vw, 3rem);
	font-weight: 900;
	margin: 0 0 1rem;
	letter-spacing: -0.02em;
}

.haiia-list-description {
	font-size: 1.125rem;
	line-height: 1.7;
	opacity: 0.95;
	max-width: 600px;
	margin: 0 auto;
}

/* カテゴリナビゲーション */
.haiia-list-categories {
	background: #fff;
	border-bottom: 1px solid #e2e8f0;
	position: sticky;
	top: 0;
	z-index: 100;
}

.haiia-category-tabs {
	display: flex;
	gap: 0.5rem;
	padding: 1rem 0;
	overflow-x: auto;
	scrollbar-width: none;
	-ms-overflow-style: none;
}

.haiia-category-tabs::-webkit-scrollbar {
	display: none;
}

.haiia-category-tab {
	flex-shrink: 0;
	background: #f1f5f9;
	border: none;
	padding: 0.625rem 1.25rem;
	border-radius: 2rem;
	font-size: 0.9375rem;
	font-weight: 600;
	color: #475569;
	cursor: pointer;
	transition: all 0.2s;
}

.haiia-category-tab:hover {
	background: #e2e8f0;
}

.haiia-category-tab.active {
	background: #3182ce;
	color: #fff;
}

/* メインコンテンツ */
.haiia-list-main {
	padding: 3rem 0;
}

/* 特集記事 */
.haiia-featured-article {
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 2rem;
	background: #fff;
	border-radius: 1.5rem;
	overflow: hidden;
	box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
	margin-bottom: 3rem;
}

.haiia-featured-content {
	padding: 2.5rem;
	display: flex;
	flex-direction: column;
}

.haiia-featured-badge {
	display: inline-flex;
	align-items: center;
	gap: 0.375rem;
	background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
	color: #fff;
	padding: 0.375rem 1rem;
	border-radius: 2rem;
	font-size: 0.8125rem;
	font-weight: 700;
	width: fit-content;
	margin-bottom: 1rem;
}

.haiia-featured-content .haiia-article-category {
	background: #e0f2fe;
	color: #0369a1;
	padding: 0.25rem 0.75rem;
	border-radius: 1rem;
	font-size: 0.75rem;
	font-weight: 600;
	width: fit-content;
	margin-bottom: 1rem;
}

.haiia-featured-title {
	font-size: 1.75rem;
	font-weight: 800;
	line-height: 1.35;
	margin: 0 0 1rem;
}

.haiia-featured-title a {
	color: #1e293b;
	text-decoration: none;
}

.haiia-featured-title a:hover {
	color: #3182ce;
}

.haiia-featured-excerpt {
	color: #475569;
	line-height: 1.7;
	margin-bottom: 1.5rem;
	flex: 1;
}

.haiia-featured-meta {
	display: flex;
	gap: 1.25rem;
	margin-bottom: 1.5rem;
	color: #64748b;
	font-size: 0.875rem;
}

.haiia-featured-meta span {
	display: flex;
	align-items: center;
	gap: 0.375rem;
}

.haiia-featured-link {
	display: inline-flex;
	align-items: center;
	gap: 0.5rem;
	background: #3182ce;
	color: #fff;
	padding: 0.875rem 1.5rem;
	border-radius: 0.5rem;
	font-weight: 700;
	text-decoration: none;
	width: fit-content;
	transition: all 0.2s;
}

.haiia-featured-link:hover {
	background: #2563eb;
	transform: translateY(-2px);
}

.haiia-featured-image {
	position: relative;
}

.haiia-featured-image img {
	width: 100%;
	height: 100%;
	object-fit: cover;
}

/* 記事グリッド */
.haiia-articles-grid {
	display: grid;
	grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
	gap: 1.5rem;
}

/* 記事カード */
.haiia-article-card {
	background: #fff;
	border-radius: 1rem;
	overflow: hidden;
	box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
	transition: all 0.2s;
}

.haiia-article-card:hover {
	transform: translateY(-4px);
	box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
}

.haiia-card-image {
	display: block;
	aspect-ratio: 16 / 9;
	overflow: hidden;
}

.haiia-card-image img {
	width: 100%;
	height: 100%;
	object-fit: cover;
	transition: transform 0.3s;
}

.haiia-article-card:hover .haiia-card-image img {
	transform: scale(1.05);
}

.haiia-card-image-placeholder {
	background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
	display: flex;
	align-items: center;
	justify-content: center;
	color: #94a3b8;
}

.haiia-card-content {
	padding: 1.25rem;
}

.haiia-card-meta-top {
	display: flex;
	align-items: center;
	gap: 0.75rem;
	margin-bottom: 0.75rem;
}

.haiia-card-meta-top .haiia-article-category {
	background: #e0f2fe;
	color: #0369a1;
	padding: 0.25rem 0.625rem;
	border-radius: 0.25rem;
	font-size: 0.6875rem;
	font-weight: 600;
}

.haiia-card-meta-top .haiia-article-read-time {
	color: #64748b;
	font-size: 0.75rem;
}

.haiia-card-title {
	font-size: 1.0625rem;
	font-weight: 700;
	line-height: 1.5;
	margin: 0 0 0.75rem;
}

.haiia-card-title a {
	color: #1e293b;
	text-decoration: none;
}

.haiia-card-title a:hover {
	color: #3182ce;
}

.haiia-card-excerpt {
	font-size: 0.875rem;
	color: #64748b;
	line-height: 1.6;
	margin-bottom: 1rem;
}

.haiia-card-meta-bottom {
	padding-top: 0.75rem;
	border-top: 1px solid #f1f5f9;
}

.haiia-article-date {
	color: #94a3b8;
	font-size: 0.8125rem;
}

/* 記事なし */
.haiia-no-articles {
	grid-column: 1 / -1;
	text-align: center;
	padding: 4rem 0;
	color: #94a3b8;
}

.haiia-no-articles svg {
	margin-bottom: 1rem;
}

/* ページネーション */
.haiia-pagination {
	display: flex;
	justify-content: center;
	gap: 0.5rem;
	margin-top: 3rem;
}

.haiia-pagination .page-numbers {
	display: flex;
	align-items: center;
	justify-content: center;
	min-width: 2.5rem;
	height: 2.5rem;
	padding: 0 0.75rem;
	background: #fff;
	color: #475569;
	text-decoration: none;
	border-radius: 0.5rem;
	font-weight: 600;
	transition: all 0.2s;
}

.haiia-pagination .page-numbers:hover {
	background: #3182ce;
	color: #fff;
}

.haiia-pagination .page-numbers.current {
	background: #3182ce;
	color: #fff;
}

/* CTA */
.haiia-list-cta {
	background: linear-gradient(135deg, #1a365d 0%, #2c5282 100%);
	padding: 4rem 0;
}

.haiia-list-cta-inner {
	text-align: center;
	color: #fff;
}

.haiia-list-cta h2 {
	font-size: 1.75rem;
	font-weight: 800;
	margin: 0 0 1rem;
}

.haiia-list-cta p {
	opacity: 0.95;
	line-height: 1.7;
	max-width: 600px;
	margin: 0 auto 2rem;
}

.haiia-list-cta-buttons {
	display: flex;
	justify-content: center;
	gap: 1rem;
	flex-wrap: wrap;
}

.haiia-list-cta .haiia-cta-primary {
	background: #fff;
	color: #1a365d;
	padding: 0.875rem 2rem;
	border-radius: 0.5rem;
	font-weight: 700;
	text-decoration: none;
	transition: all 0.2s;
}

.haiia-list-cta .haiia-cta-primary:hover {
	transform: translateY(-2px);
	box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.haiia-list-cta .haiia-cta-secondary {
	background: transparent;
	color: #fff;
	padding: 0.875rem 2rem;
	border-radius: 0.5rem;
	font-weight: 600;
	text-decoration: none;
	border: 2px solid rgba(255, 255, 255, 0.5);
	transition: all 0.2s;
}

.haiia-list-cta .haiia-cta-secondary:hover {
	background: rgba(255, 255, 255, 0.1);
	border-color: #fff;
}

/* レスポンシブ */
@media (max-width: 992px) {
	.haiia-featured-article {
		grid-template-columns: 1fr;
	}

	.haiia-featured-image {
		order: -1;
		aspect-ratio: 16 / 9;
	}
}

@media (max-width: 768px) {
	.haiia-list-header {
		padding: 3rem 0 2rem;
	}

	.haiia-articles-grid {
		grid-template-columns: 1fr;
	}

	.haiia-featured-content {
		padding: 1.5rem;
	}

	.haiia-featured-title {
		font-size: 1.375rem;
	}

	.haiia-list-cta {
		padding: 3rem 0;
	}
}
</style>

<script>
// カテゴリフィルター
document.addEventListener('DOMContentLoaded', function() {
	const tabs = document.querySelectorAll('.haiia-category-tab');
	const cards = document.querySelectorAll('.haiia-article-card');

	tabs.forEach(function(tab) {
		tab.addEventListener('click', function() {
			// アクティブタブの切り替え
			tabs.forEach(function(t) { t.classList.remove('active'); });
			this.classList.add('active');

			const category = this.dataset.category;

			// カードのフィルタリング
			cards.forEach(function(card) {
				if (category === 'all' || card.dataset.category === category) {
					card.style.display = '';
				} else {
					card.style.display = 'none';
				}
			});
		});
	});
});
</script>

<?php get_footer(); ?>
