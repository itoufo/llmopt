<?php
/**
 * Template Name: 調査レポート一覧
 *
 * 健全AI教育協会の調査レポートを一覧表示するテンプレート。
 * 子ページとして作成されたレポートを表示します。
 */

use VektorInc\VK_Breadcrumb\VkBreadcrumb;

// HTMLヘッド部分
lightning_get_template_part( 'header' );

// サイトヘッダー
do_action( 'lightning_site_header_before', 'lightning_site_header_before' );
if ( apply_filters( 'lightning_is_site_header', true, 'site_header' ) ) {
	lightning_get_template_part( 'template-parts/site-header' );
}
do_action( 'lightning_site_header_after', 'lightning_site_header_after' );

// ページヘッダー（タイトルバー）
do_action( 'lightning_page_header_before', 'lightning_page_header_before' );
if ( apply_filters( 'lightning_is_page_header', true, 'page_header' ) ) {
	lightning_get_template_part( 'template-parts/page-header' );
}
do_action( 'lightning_page_header_after', 'lightning_page_header_after' );

// パンくずリスト
do_action( 'lightning_breadcrumb_before', 'lightning_breadcrumb_before' );
if ( apply_filters( 'lightning_is_breadcrumb_position_normal', true, 'breadcrumb_position_normal' ) ) {
	if ( apply_filters( 'lightning_is_breadcrumb', true, 'breadcrumb' ) ) {
		if ( class_exists( 'VektorInc\VK_Breadcrumb\VkBreadcrumb' ) ) {
			$vk_breadcrumb      = new VkBreadcrumb();
			$breadcrumb_options = array(
				'id_outer'        => 'breadcrumb',
				'class_outer'     => 'breadcrumb',
				'class_inner'     => 'container',
				'class_list'      => 'breadcrumb-list',
				'class_list_item' => 'breadcrumb-list__item',
			);
			$vk_breadcrumb->the_breadcrumb( $breadcrumb_options );
		}
	}
}
do_action( 'lightning_breadcrumb_after', 'lightning_breadcrumb_after' );

do_action( 'lightning_site_body_before', 'lightning_site_body_before' );
?>

<div class="<?php lightning_the_class_name( 'site-body' ); ?>">
	<?php do_action( 'lightning_site_body_prepend', 'lightning_site_body_prepend' ); ?>
	<div class="<?php lightning_the_class_name( 'site-body-container' ); ?> container">

		<div class="<?php lightning_the_class_name( 'main-section' ); ?>" id="main" role="main">
			<?php do_action( 'lightning_main_section_prepend', 'lightning_main_section_prepend' ); ?>

		<article <?php post_class(); ?>>
			<div class="entry-body">
				<?php
				// 固定ページ本文
				while ( have_posts() ) :
					the_post();
					the_content();
				endwhile;
				?>

				<?php
				// 公開資料セクション（添付ファイルを取得）
				$attachments = get_posts( array(
					'post_type'      => 'attachment',
					'posts_per_page' => -1,
					'post_parent'    => get_the_ID(),
					'orderby'        => 'menu_order',
					'order'          => 'ASC',
				) );

				if ( $attachments ) :
				?>
				<section class="public-materials-section">
					<h2>公開資料</h2>
					<p class="section-description">健全AI教育協会が作成・公開している資料です。ご自由にダウンロードしてご活用ください。</p>

					<div class="materials-grid">
						<?php foreach ( $attachments as $attachment ) :
							$file_url = wp_get_attachment_url( $attachment->ID );
							$file_type = wp_check_filetype( $file_url );
							$file_ext = strtoupper( $file_type['ext'] );
							$file_path = get_attached_file( $attachment->ID );
							$file_size = file_exists( $file_path ) ? filesize( $file_path ) : 0;
							$file_size_formatted = size_format( $file_size );

							// PDFサムネイルを取得（複数の方法を試す）
							$pdf_thumbnail_url = '';

							// 方法1: _thumbnail_id メタデータ
							$pdf_thumbnail_id = get_post_meta( $attachment->ID, '_thumbnail_id', true );
							if ( $pdf_thumbnail_id ) {
								$pdf_thumbnail_url = wp_get_attachment_image_url( $pdf_thumbnail_id, 'medium' );
							}

							// 方法2: attachment metadata から取得
							if ( ! $pdf_thumbnail_url && $file_ext === 'PDF' ) {
								$metadata = wp_get_attachment_metadata( $attachment->ID );
								if ( ! empty( $metadata['sizes']['full']['file'] ) ) {
									$upload_dir = wp_upload_dir();
									$pdf_dir = dirname( get_post_meta( $attachment->ID, '_wp_attached_file', true ) );
									$pdf_thumbnail_url = $upload_dir['baseurl'] . '/' . $pdf_dir . '/' . $metadata['sizes']['full']['file'];
								} elseif ( ! empty( $metadata['file'] ) ) {
									$upload_dir = wp_upload_dir();
									$pdf_thumbnail_url = $upload_dir['baseurl'] . '/' . $metadata['file'];
								}
							}
						?>
							<article class="material-card">
								<div class="material-thumbnail">
									<?php if ( $pdf_thumbnail_url ) : ?>
										<img src="<?php echo esc_url( $pdf_thumbnail_url ); ?>" alt="<?php echo esc_attr( $attachment->post_title ); ?>">
									<?php elseif ( $file_ext === 'PDF' ) : ?>
										<div class="material-icon-fallback">
											<svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#e74c3c" stroke-width="1.5">
												<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
												<polyline points="14 2 14 8 20 8"></polyline>
												<path d="M9 15h6"></path>
												<path d="M9 11h6"></path>
											</svg>
											<span>PDF</span>
										</div>
									<?php else : ?>
										<div class="material-icon-fallback">
											<svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#3498db" stroke-width="1.5">
												<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
												<polyline points="14 2 14 8 20 8"></polyline>
											</svg>
											<span><?php echo esc_html( $file_ext ); ?></span>
										</div>
									<?php endif; ?>
								</div>

								<div class="material-content">
									<h3 class="material-title">
										<?php echo esc_html( $attachment->post_title ); ?>
									</h3>

									<?php if ( $attachment->post_excerpt ) : ?>
										<p class="material-description">
											<?php echo esc_html( $attachment->post_excerpt ); ?>
										</p>
									<?php endif; ?>

									<div class="material-meta">
										<span class="file-type"><?php echo esc_html( $file_ext ); ?></span>
										<span class="file-size"><?php echo esc_html( $file_size_formatted ); ?></span>
									</div>

									<a href="<?php echo esc_url( $file_url ); ?>" class="material-download" target="_blank" download>
										ダウンロード
									</a>
								</div>
							</article>
						<?php endforeach; ?>
					</div>
				</section>
				<?php endif; ?>

				<section class="research-policy-section">
					<div class="policy-box">
						<h2>調査ポリシー</h2>
						<p>健全AI教育協会は、AI教育に関する調査を以下のポリシーに基づき実施しています。</p>
						<ul>
							<li><strong>客観性</strong>：データに基づいた客観的な分析を行います</li>
							<li><strong>透明性</strong>：調査方法と結果を明確に開示します</li>
							<li><strong>倫理性</strong>：個人情報保護と研究倫理を遵守します</li>
							<li><strong>公益性</strong>：社会全体の利益を考慮した調査を実施します</li>
						</ul>
					</div>
				</section>

				<section class="research-reports-list">
					<h2>調査レポート</h2>

					<?php
					// 「調査レポート」カテゴリの投稿を取得
					$report_query = new WP_Query( array(
						'post_type'      => 'post',
						'category_name'  => 'research-report',
						'posts_per_page' => -1,
						'orderby'        => 'date',
						'order'          => 'DESC',
					) );

					if ( $report_query->have_posts() ) :
					?>
						<div class="reports-grid">
							<?php while ( $report_query->have_posts() ) : $report_query->the_post(); ?>
								<article class="report-card">
									<?php if ( has_post_thumbnail() ) : ?>
										<div class="report-thumbnail">
											<a href="<?php the_permalink(); ?>">
												<?php the_post_thumbnail( 'medium' ); ?>
											</a>
										</div>
									<?php endif; ?>

									<div class="report-content">
										<h3 class="report-title">
											<a href="<?php the_permalink(); ?>">
												<?php the_title(); ?>
											</a>
										</h3>

										<div class="report-meta">
											<time datetime="<?php echo get_the_date( 'c' ); ?>">
												<?php echo get_the_date( 'Y年n月j日' ); ?>
											</time>
										</div>

										<p class="report-excerpt">
											<?php
											if ( has_excerpt() ) {
												echo esc_html( get_the_excerpt() );
											} else {
												echo wp_trim_words( get_the_content(), 80, '...' );
											}
											?>
										</p>

										<a href="<?php the_permalink(); ?>" class="report-link">
											レポートを読む
										</a>
									</div>
								</article>
							<?php endwhile; ?>
						</div>
					<?php wp_reset_postdata(); ?>
					<?php else : ?>
						<p class="no-reports">現在公開中の調査レポートはありません。</p>
					<?php endif; ?>
				</section>

			</div>
		</article>

			<?php do_action( 'lightning_main_section_append', 'lightning_main_section_append' ); ?>
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
/* 公開資料セクション */
.public-materials-section {
    margin-bottom: 3.5rem;
}

.public-materials-section h2 {
    font-size: 1.35rem;
    margin-bottom: 0.75rem;
    color: #222;
    font-weight: 600;
}

.public-materials-section .section-description {
    color: #666;
    margin-bottom: 1.5rem;
    font-size: 0.95rem;
}

.materials-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 1.5rem;
}

.material-card {
    display: flex;
    gap: 1.25rem;
    padding: 1.5rem;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06);
    transition: box-shadow 0.2s ease;
}

.material-card:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,0.08);
}

.material-thumbnail {
    flex-shrink: 0;
    width: 120px;
}

.material-thumbnail img {
    width: 100%;
    height: auto;
    border-radius: 4px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.material-icon-fallback {
    width: 120px;
    height: 160px;
    background: #f5f5f5;
    border-radius: 4px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.material-icon-fallback span {
    font-size: 0.75rem;
    font-weight: 600;
    color: #888;
}

.material-content {
    flex: 1;
    min-width: 0;
}

.material-title {
    font-size: 1rem;
    font-weight: 600;
    color: #222;
    margin: 0 0 0.5rem;
    line-height: 1.4;
}

.material-description {
    font-size: 0.875rem;
    color: #555;
    line-height: 1.5;
    margin-bottom: 0.75rem;
}

.material-meta {
    display: flex;
    gap: 0.75rem;
    margin-bottom: 0.75rem;
    font-size: 0.8rem;
}

.material-meta .file-type {
    background: #f0f0f0;
    color: #666;
    padding: 0.2rem 0.5rem;
    border-radius: 4px;
    font-weight: 500;
}

.material-meta .file-size {
    color: #888;
}

.material-download {
    display: inline-block;
    font-size: 0.875rem;
    color: #0066cc;
    text-decoration: none;
    font-weight: 500;
}

.material-download:hover {
    text-decoration: underline;
}

/* 調査レポート一覧スタイル */
.research-policy-section {
    margin: 2.5rem 0 3.5rem;
}

.policy-box {
    background: #fafafa;
    padding: 2rem 2.5rem;
    border-radius: 12px;
}

.policy-box h2 {
    font-size: 1.2rem;
    color: #333;
    margin-bottom: 1rem;
    font-weight: 600;
}

.policy-box > p {
    color: #555;
    margin-bottom: 1.25rem;
}

.policy-box ul {
    margin: 0;
    padding: 0;
    list-style: none;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0.75rem 2rem;
}

.policy-box li {
    color: #444;
    line-height: 1.5;
    font-size: 0.95rem;
}

.policy-box li strong {
    color: #222;
}

.research-reports-list h2 {
    font-size: 1.35rem;
    margin-bottom: 1.75rem;
    color: #222;
    font-weight: 600;
}

.reports-grid {
    display: grid;
    gap: 2rem;
}

.report-card {
    display: flex;
    gap: 2rem;
    padding: 1.75rem 2rem;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06);
    transition: box-shadow 0.2s ease;
}

.report-card:hover {
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
}

.report-thumbnail {
    flex-shrink: 0;
    width: 180px;
}

.report-thumbnail img {
    width: 100%;
    height: auto;
    border-radius: 6px;
    object-fit: cover;
}

.report-content {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.report-title {
    font-size: 1.15rem;
    margin: 0 0 0.5rem;
    line-height: 1.5;
    font-weight: 600;
}

.report-title a {
    color: #222;
    text-decoration: none;
}

.report-title a:hover {
    color: #0066cc;
}

.report-meta {
    font-size: 0.85rem;
    color: #888;
    margin-bottom: 0.85rem;
}

.report-excerpt {
    font-size: 0.95rem;
    color: #555;
    line-height: 1.7;
    margin-bottom: 1.25rem;
    flex: 1;
}

.report-link {
    font-size: 0.9rem;
    color: #0066cc;
    text-decoration: none;
    font-weight: 500;
    align-self: flex-start;
}

.report-link:hover {
    text-decoration: underline;
}

.no-reports {
    padding: 3rem;
    text-align: center;
    color: #888;
    background: #fafafa;
    border-radius: 10px;
}

/* レスポンシブ対応 */
@media (max-width: 768px) {
    .report-card {
        flex-direction: column;
        padding: 1.5rem;
    }

    .report-thumbnail {
        width: 100%;
    }

    .policy-box {
        padding: 1.5rem;
    }

    .policy-box ul {
        grid-template-columns: 1fr;
    }

    .materials-grid {
        grid-template-columns: 1fr;
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
