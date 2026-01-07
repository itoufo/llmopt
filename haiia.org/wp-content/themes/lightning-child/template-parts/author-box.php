<?php
/**
 * 著者情報ボックス
 * 投稿者に応じて著者情報を表示
 */

$author_id = get_the_author_meta('ID');
$author_email = get_the_author_meta('user_email');
?>

<aside class="haiia-author-section">
	<div class="haiia-author-header">
		<span class="haiia-author-label">この記事を執筆・監修した人</span>
		<span class="haiia-author-name-badge"><?php the_author(); ?></span>
	</div>

	<?php if ( $author_email === 'yuho132@haiia.org' || $author_email === 'contact@walker.co.jp' ) : ?>
	<!-- 伊東雄歩 -->
	<div class="haiia-author-card">
		<div class="haiia-author-profile">
			<div class="haiia-author-avatar">伊東</div>
			<div class="haiia-author-info">
				<h4>伊東雄歩<span class="haiia-reading">（いとう ゆうほ）</span></h4>
				<p class="haiia-author-titles">株式会社ウォーカー 代表取締役 ／ 健全AI教育協会（HAIIA）理事</p>
			</div>
		</div>
		<div class="haiia-author-bio">
			<p>生成AIの非エンジニア・初心者向け活用と教育を専門とし、企業研修・イベント・コミュニティ運営を通じて「AIが苦手な人でも、仕事や思考に使える状態」を作る支援を行っている。</p>
			<p>生成AIを「効率化ツール」にとどめず、思考力・学び方・成長設計まで含めた教育設計を得意とする。</p>
			<div class="haiia-author-achievements">
				<p><strong>主な実績</strong></p>
				<ul>
					<li>生成AI・デジタル教育イベント／研修を多数企画・登壇</li>
					<li>全国規模の教育プロジェクト「Digitech Quest」を展開</li>
					<li>AI教材「StoQ」を開発・提供</li>
					<li>大規模基幹システム構築プロジェクト（150人月超）に参画</li>
					<li>JDLA認定講座 講師（2017年）</li>
				</ul>
			</div>
			<p><strong>経歴</strong><br>
			横須賀高校 → 東北大学 → ソフトバンク（2013-2015）→ 株式会社ウォーカー設立（2015年〜）</p>
			<div class="haiia-author-themes">
				<p><strong>活動テーマ</strong></p>
				<ul>
					<li>生成AI × 非エンジニア</li>
					<li>AI時代の学び方・思考力</li>
					<li>AI初心者の心理的ハードル設計</li>
					<li>教育・コミュニティによる技術普及</li>
				</ul>
			</div>
		</div>
	</div>

	<?php else : ?>
	<!-- その他の著者（デフォルト表示） -->
	<div class="haiia-author-card">
		<div class="haiia-author-profile">
			<div class="haiia-author-avatar"><?php echo mb_substr(get_the_author(), 0, 1); ?></div>
			<div class="haiia-author-info">
				<h4><?php the_author(); ?></h4>
				<p class="haiia-author-titles"><?php echo get_the_author_meta('description') ?: '健全AI教育協会（HAIIA）'; ?></p>
			</div>
		</div>
	</div>
	<?php endif; ?>

</aside>
