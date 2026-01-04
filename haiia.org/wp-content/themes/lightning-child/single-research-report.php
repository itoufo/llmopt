<?php
/**
 * 調査レポート詳細（投稿用テンプレート）
 *
 * 「調査レポート」カテゴリ（スラッグ: research-report）の投稿に自動適用されます。
 */

use VektorInc\VK_Breadcrumb\VkBreadcrumb;

// SEO用構造化データ（ペイウォールコンテンツ対応）
add_action( 'wp_head', function() {
	if ( ! is_singular() ) return;

	$post_id = get_the_ID();
	$schema = array(
		'@context' => 'https://schema.org',
		'@type' => 'Article',
		'headline' => get_the_title( $post_id ),
		'datePublished' => get_the_date( 'c', $post_id ),
		'dateModified' => get_the_modified_date( 'c', $post_id ),
		'author' => array(
			'@type' => 'Organization',
			'name' => '一般社団法人 健全AI教育協会',
			'url' => 'https://haiia.org'
		),
		'publisher' => array(
			'@type' => 'Organization',
			'name' => '一般社団法人 健全AI教育協会',
			'url' => 'https://haiia.org'
		),
		'description' => get_the_excerpt( $post_id ),
		'isAccessibleForFree' => false,
		'hasPart' => array(
			array(
				'@type' => 'WebPageElement',
				'isAccessibleForFree' => true,
				'cssSelector' => '.report-introduction, .report-body, .report-summary'
			),
			array(
				'@type' => 'WebPageElement',
				'isAccessibleForFree' => false,
				'cssSelector' => '.report-references, .report-review, .report-about, .report-attachments'
			)
		)
	);

	if ( has_post_thumbnail( $post_id ) ) {
		$schema['image'] = get_the_post_thumbnail_url( $post_id, 'large' );
	}

	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}, 5 );

// HTMLヘッド部分
lightning_get_template_part( 'header' );

// サイトヘッダー
do_action( 'lightning_site_header_before', 'lightning_site_header_before' );
if ( apply_filters( 'lightning_is_site_header', true, 'site_header' ) ) {
	lightning_get_template_part( 'template-parts/site-header' );
}
do_action( 'lightning_site_header_after', 'lightning_site_header_after' );

// パンくずリスト（調査レポート用カスタム）
do_action( 'lightning_breadcrumb_before', 'lightning_breadcrumb_before' );
$report_category = get_category_by_slug( 'research-report' );
$category_url = $report_category ? get_category_link( $report_category->term_id ) : home_url( '/category/research-report/' );
$category_name = $report_category ? $report_category->name : '調査レポート';
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
			$report_author = get_field( 'report_author' );
			$report_introduction = get_field( 'report_introduction' );
			$report_summary = get_field( 'report_summary' );
			$report_references = get_field( 'report_references' );
			$report_author_review = get_field( 'report_author_review' );
			$report_haiia_opinion = get_field( 'report_haiia_opinion' );
			$report_ai_info = get_field( 'report_ai_info' );
			$report_attachments = get_field( 'report_attachments' );
			?>
			<article <?php post_class( 'research-report-single' ); ?>>

				<!-- レポートヘッダー -->
				<header class="report-header">
					<h1 class="report-title"><?php the_title(); ?></h1>
					<p class="report-org">一般社団法人 健全AI教育協会</p>
					<?php if ( $report_author ) : ?>
						<p class="report-author"><?php echo esc_html( $report_author ); ?></p>
					<?php endif; ?>
					<div class="report-meta">
						<time datetime="<?php echo get_the_date( 'c' ); ?>">
							<?php echo get_the_date( 'Y年n月j日' ); ?>
						</time>
					</div>
				</header>

				<?php if ( has_post_thumbnail() ) : ?>
				<div class="report-featured-image">
					<?php the_post_thumbnail( 'large' ); ?>
				</div>
				<?php endif; ?>

				<!-- はじめに -->
				<?php if ( $report_introduction ) : ?>
				<section class="report-section report-introduction">
					<h2>はじめに</h2>
					<div class="section-content">
						<?php echo $report_introduction; ?>
					</div>
				</section>
				<?php endif; ?>

				<!-- 本文（WordPressエディタ） -->
				<div class="entry-body report-body">
					<?php the_content(); ?>
				</div>

				<!-- まとめ -->
				<?php if ( $report_summary ) : ?>
				<section class="report-section report-summary">
					<h2>まとめ</h2>
					<div class="section-content">
						<?php echo $report_summary; ?>
					</div>
				</section>
				<?php endif; ?>

				<?php
				// ここから会員限定コンテンツ
				$has_members_content = $report_references || $report_author_review || $report_haiia_opinion || $report_ai_info || $report_attachments;

				if ( $has_members_content ) :
					if ( is_user_logged_in() ) :
				?>

				<!-- 参考資料 -->
				<?php if ( $report_references ) : ?>
				<section class="report-section report-references">
					<h2>参考資料</h2>
					<ul class="references-list">
						<?php
						// テキストエリアを行ごとに分割
						$lines = array_filter( array_map( 'trim', explode( "\n", $report_references ) ) );
						foreach ( $lines as $line ) :
							// 「タイトル|URL」形式をパース
							if ( strpos( $line, '|' ) !== false ) {
								list( $title, $url ) = array_map( 'trim', explode( '|', $line, 2 ) );
							} else {
								// URLのみの場合
								$title = '';
								$url = trim( $line );
							}
						?>
							<li>
								<?php if ( preg_match( '#^https?://#i', $url ) ) : ?>
									<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer">
										<?php echo esc_html( $title ?: $url ); ?>
									</a>
								<?php else : ?>
									<?php echo esc_html( $title ?: $line ); ?>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ul>
				</section>
				<?php endif; ?>

				<!-- 執筆者レビュー -->
				<?php if ( $report_author_review || $report_haiia_opinion ) : ?>
				<section class="report-section report-review">
					<h2>執筆者レビュー（健全AI教育協会）</h2>

					<?php if ( $report_author_review ) : ?>
					<div class="review-block">
						<div class="section-content">
							<?php echo $report_author_review; ?>
						</div>
					</div>
					<?php endif; ?>

					<?php if ( $report_haiia_opinion ) : ?>
					<div class="review-block haiia-opinion">
						<div class="section-content">
							<?php echo $report_haiia_opinion; ?>
						</div>
					</div>
					<?php endif; ?>
				</section>
				<?php endif; ?>

				<!-- 本レポートについて -->
				<?php if ( $report_ai_info ) : ?>
				<section class="report-section report-about">
					<h2>本レポートについて</h2>
					<p class="about-text">
						本文は<strong><?php echo esc_html( $report_ai_info ); ?></strong>を用いて作成し、執筆者が事実確認・編集・加筆を行いました。末尾のレビューは執筆者による考察です。
					</p>
				</section>
				<?php endif; ?>

				<!-- 関連資料（ACFフィールドから取得） -->
				<?php if ( $report_attachments ) : ?>
				<section class="report-section report-attachments">
					<h2>関連資料</h2>
					<div class="attachments-list">
						<?php
						$lines = array_filter( array_map( 'trim', explode( "\n", $report_attachments ) ) );
						foreach ( $lines as $line ) :
							if ( strpos( $line, '|' ) !== false ) {
								list( $title, $file_url ) = array_map( 'trim', explode( '|', $line, 2 ) );
							} else {
								$title = '';
								$file_url = trim( $line );
							}

							// URLの簡易チェック（日本語ファイル名対応）
							if ( ! preg_match( '#^https?://#i', $file_url ) ) continue;

							$file_type = wp_check_filetype( $file_url );
							$file_ext = strtoupper( $file_type['ext'] );
							if ( ! $title ) {
								$title = basename( $file_url );
							}
						?>
						<div class="attachment-item">
							<div class="attachment-icon">
								<?php if ( $file_ext === 'PDF' ) : ?>
									<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#e74c3c" stroke-width="1.5">
										<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
										<polyline points="14 2 14 8 20 8"></polyline>
									</svg>
								<?php else : ?>
									<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#3498db" stroke-width="1.5">
										<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
										<polyline points="14 2 14 8 20 8"></polyline>
									</svg>
								<?php endif; ?>
							</div>
							<div class="attachment-info">
								<span class="attachment-title"><?php echo esc_html( $title ); ?></span>
								<span class="attachment-meta">
									<span class="file-type"><?php echo esc_html( $file_ext ?: 'FILE' ); ?></span>
								</span>
							</div>
							<a href="<?php echo esc_url( $file_url ); ?>" class="attachment-download" target="_blank" download>
								<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
									<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
									<polyline points="7 10 12 15 17 10"></polyline>
									<line x1="12" y1="15" x2="12" y2="3"></line>
								</svg>
								ダウンロード
							</a>
						</div>
						<?php endforeach; ?>
					</div>
				</section>
				<?php endif; ?>

				<?php else : // 非ログインユーザー ?>

				<!-- フェードアウト演出 -->
				<div class="content-fade-overlay">
					<div class="fade-text">
						<p>参考資料、執筆者レビュー、HAIIAとしての見解・提言、関連資料のダウンロードなど、さらに詳しい内容が続きます...</p>
					</div>
				</div>

				<section class="members-only-notice">
					<div class="members-only-inner">
						<h2>会員限定コンテンツ</h2>
						<p>参考資料、執筆者レビュー、HAIIAの見解など、続きをご覧いただくには会員登録（無料）が必要です。</p>
						<div class="members-only-actions">
							<a href="<?php echo esc_url( wp_login_url( get_permalink() ) ); ?>" class="btn-login">ログイン</a>
							<a href="<?php echo esc_url( wp_registration_url() ); ?>" class="btn-register">新規会員登録（無料）</a>
						</div>
					</div>
				</section>

				<?php endif; // is_user_logged_in ?>
				<?php endif; // has_members_content ?>

				<!-- レポートフッター（固定） -->
				<div class="report-credit">
					<div class="credit-divider"></div>
					<p>発行：一般社団法人 健全AI教育協会（HAIIA）</p>
					<p>URL：<a href="https://haiia.org" target="_blank">https://haiia.org</a></p>
					<p>お問い合わせ：<a href="mailto:info@haiia.org">info@haiia.org</a></p>
					<p class="copyright-notice">本レポートの無断転載・複製を禁じます。引用の際は出典を明記してください。</p>
				</div>

				<footer class="report-footer">
					<?php
					// 調査レポート一覧へのリンク（カテゴリアーカイブまたは固定ページ）
					$report_category = get_category_by_slug( 'research-report' );
					$back_url = $report_category ? get_category_link( $report_category->term_id ) : home_url( '/research-reports/' );
					?>
					<a href="<?php echo esc_url( $back_url ); ?>" class="back-to-list">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<line x1="19" y1="12" x2="5" y2="12"></line>
							<polyline points="12 19 5 12 12 5"></polyline>
						</svg>
						調査レポート一覧に戻る
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
/* 調査レポート個別ページ */
.research-report-single {
	max-width: 800px;
	margin: 0 auto;
}

/* VK系プラグインの要素を非表示 */
.research-report-single .veu_socialSet,
.research-report-single .veu_followSet,
.veu_socialSet-position-after,
.veu_contentAddSection {
	display: none !important;
}

/* レポートヘッダー */
.report-header {
	text-align: center;
	margin-bottom: 2rem;
	padding-bottom: 1.5rem;
	border-bottom: 1px solid #eee;
}

.report-title {
	font-size: 1.75rem;
	font-weight: 700;
	line-height: 1.4;
	color: #111;
	margin: 0 0 1.25rem;
}

@media (min-width: 768px) {
	.report-title {
		font-size: 2rem;
	}
}

.report-org {
	font-size: 0.9rem;
	color: #666;
	margin-bottom: 0.5rem;
}

.report-author {
	font-size: 1rem;
	color: #333;
	margin-bottom: 0.5rem;
}

.report-meta time {
	font-size: 0.9rem;
	color: #888;
}

.report-featured-image {
	margin-bottom: 2rem;
	border-radius: 8px;
	overflow: hidden;
}

.report-featured-image img {
	width: 100%;
	height: auto;
	display: block;
}

/* セクション共通 */
.report-section {
	margin-bottom: 2.5rem;
}

.report-section h2 {
	font-size: 1.25rem;
	font-weight: 600;
	margin-bottom: 1rem;
	padding-bottom: 0.5rem;
	border-bottom: 2px solid #0066cc;
	color: #222;
}

.report-section .section-content {
	font-size: 1rem;
	line-height: 1.85;
	color: #333;
}

.report-section .section-content p {
	margin-bottom: 1rem;
}

/* 本文エリア */
.report-body {
	font-size: 1rem;
	line-height: 1.85;
	color: #333;
	margin-bottom: 2.5rem;
}

.report-body h2 {
	font-size: 1.35rem;
	font-weight: 600;
	margin: 2.5rem 0 1rem;
	padding-bottom: 0.5rem;
	border-bottom: 2px solid #eee;
}

.report-body h3 {
	font-size: 1.15rem;
	font-weight: 600;
	margin: 2rem 0 0.75rem;
}

.report-body p {
	margin-bottom: 1.25rem;
}

.report-body ul,
.report-body ol {
	margin-bottom: 1.25rem;
	padding-left: 1.5rem;
}

.report-body li {
	margin-bottom: 0.5rem;
}

.report-body blockquote {
	margin: 1.5rem 0;
	padding: 1rem 1.5rem;
	background: #f8f9fa;
	border-left: 4px solid #0066cc;
	font-style: italic;
	color: #555;
}

.report-body table {
	width: 100%;
	border-collapse: collapse;
	margin: 1.5rem 0;
}

.report-body th,
.report-body td {
	padding: 0.75rem 1rem;
	border: 1px solid #ddd;
	text-align: left;
}

.report-body th {
	background: #f5f5f5;
	font-weight: 600;
}

/* 参考資料 */
.references-list {
	list-style: none;
	padding: 0;
	margin: 0;
}

.references-list li {
	padding: 0.5rem 0;
	border-bottom: 1px solid #f0f0f0;
}

.references-list li:last-child {
	border-bottom: none;
}

.references-list a {
	color: #0066cc;
	text-decoration: none;
}

.references-list a:hover {
	text-decoration: underline;
}

/* 執筆者レビュー */
.report-review .review-block {
	background: #f8f9fa;
	padding: 1.5rem;
	border-radius: 8px;
	margin-bottom: 1rem;
}

.report-review .haiia-opinion {
	background: #e8f4fd;
	border-left: 4px solid #0066cc;
}

/* 本レポートについて */
.report-about {
	background: #fafafa;
	padding: 1.5rem;
	border-radius: 8px;
}

.report-about h2 {
	margin-top: 0;
}

.about-text {
	font-size: 0.95rem;
	color: #555;
	margin: 0;
}

/* 添付ファイルセクション */
.report-attachments h2 {
	border-bottom-color: #28a745;
}

.attachments-list {
	display: flex;
	flex-direction: column;
	gap: 0.75rem;
}

.attachment-item {
	display: flex;
	align-items: center;
	gap: 1rem;
	padding: 1rem 1.25rem;
	background: #f8f9fa;
	border-radius: 8px;
	transition: background 0.2s ease;
}

.attachment-item:hover {
	background: #f0f1f3;
}

.attachment-icon {
	flex-shrink: 0;
	width: 40px;
	height: 40px;
	display: flex;
	align-items: center;
	justify-content: center;
}

.attachment-info {
	flex: 1;
	min-width: 0;
}

.attachment-title {
	display: block;
	font-weight: 500;
	color: #222;
	margin-bottom: 0.25rem;
	white-space: nowrap;
	overflow: hidden;
	text-overflow: ellipsis;
}

.attachment-meta {
	font-size: 0.8rem;
	color: #888;
}

.attachment-meta .file-type {
	background: #e9ecef;
	padding: 0.1rem 0.4rem;
	border-radius: 3px;
	margin-right: 0.5rem;
	font-weight: 500;
}

.attachment-download {
	display: inline-flex;
	align-items: center;
	gap: 0.4rem;
	padding: 0.5rem 1rem;
	background: #0066cc;
	color: #fff;
	text-decoration: none;
	border-radius: 6px;
	font-size: 0.875rem;
	font-weight: 500;
	transition: background 0.2s ease;
}

.attachment-download:hover {
	background: #0052a3;
	color: #fff;
}

/* レポートクレジット */
.report-credit {
	margin-top: 3rem;
	padding: 1.5rem;
	background: #f5f5f5;
	border-radius: 8px;
	font-size: 0.9rem;
	color: #555;
	text-align: center;
}

.report-credit .credit-divider {
	width: 60px;
	height: 2px;
	background: #ccc;
	margin: 0 auto 1rem;
}

.report-credit p {
	margin: 0.25rem 0;
}

.report-credit a {
	color: #0066cc;
	text-decoration: none;
}

.report-credit a:hover {
	text-decoration: underline;
}

.report-credit .copyright-notice {
	margin-top: 1rem;
	font-size: 0.8rem;
	color: #888;
}

/* フッター */
.report-footer {
	margin-top: 2rem;
	padding-top: 1.5rem;
	border-top: 1px solid #eee;
}

.back-to-list {
	display: inline-flex;
	align-items: center;
	gap: 0.5rem;
	color: #0066cc;
	text-decoration: none;
	font-weight: 500;
}

.back-to-list:hover {
	text-decoration: underline;
}

/* フェードアウト演出 */
.content-fade-overlay {
	position: relative;
	margin-top: -3rem;
	padding-top: 4rem;
	background: linear-gradient(to bottom,
		rgba(255,255,255,0) 0%,
		rgba(255,255,255,0.8) 30%,
		rgba(255,255,255,1) 60%
	);
}

.fade-text {
	position: relative;
	color: #999;
	font-size: 0.95rem;
	line-height: 1.7;
	text-align: center;
	padding: 1rem 0;
}

.fade-text p {
	margin: 0;
	opacity: 0.7;
}

/* 会員限定通知 */
.members-only-notice {
	margin: 2.5rem 0;
	padding: 2.5rem;
	background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
	border-radius: 12px;
	text-align: center;
	border: 1px solid #dee2e6;
}

.members-only-inner h2 {
	font-size: 1.25rem;
	font-weight: 600;
	color: #333;
	margin: 0 0 1rem;
}

.members-only-inner p {
	color: #555;
	margin-bottom: 1.5rem;
	line-height: 1.6;
}

.members-only-actions {
	display: flex;
	gap: 1rem;
	justify-content: center;
	flex-wrap: wrap;
}

.members-only-actions .btn-login,
.members-only-actions .btn-register {
	display: inline-block;
	padding: 0.75rem 2rem;
	border-radius: 6px;
	font-weight: 500;
	text-decoration: none;
	transition: all 0.2s ease;
}

.members-only-actions .btn-login {
	background: #fff;
	color: #0066cc;
	border: 1px solid #0066cc;
}

.members-only-actions .btn-login:hover {
	background: #f0f7ff;
}

.members-only-actions .btn-register {
	background: #0066cc;
	color: #fff;
	border: 1px solid #0066cc;
}

.members-only-actions .btn-register:hover {
	background: #0052a3;
}

/* レスポンシブ対応 */
@media (max-width: 768px) {
	.attachment-item {
		flex-wrap: wrap;
	}

	.attachment-info {
		flex: 1 1 calc(100% - 56px);
	}

	.attachment-download {
		width: 100%;
		justify-content: center;
		margin-top: 0.5rem;
	}

	.report-review .review-block {
		padding: 1rem;
	}
}
</style>

<?php
do_action( 'lightning_site_footer_before', 'lightning_site_footer_before' );
if ( apply_filters( 'lightning_is_site_footer', true, 'site_footer' ) ) {
	lightning_get_template_part( 'template-parts/site-footer' );
}
do_action( 'lightning_site_footer_after', 'lightning_site_footer_after' );

lightning_get_template_part( 'footer' );
?>
