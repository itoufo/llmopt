<?php
/**
 * Template Name: 協会について
 * Description: HAIIAの協会概要ページ専用テンプレート
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

<div class="<?php lightning_the_class_name( 'site-body' ); ?> haiia-about">
    <?php do_action( 'lightning_site_body_prepend', 'lightning_site_body_prepend' ); ?>

    <!-- ページヘッダー -->
    <div class="haiia-page-header">
        <div class="container">
            <h1 class="haiia-page-title">協会について</h1>
            <p class="haiia-page-subtitle">About HAIIA</p>
        </div>
    </div>

    <div class="<?php lightning_the_class_name( 'site-body-container' ); ?> container">

        <div class="<?php lightning_the_class_name( 'main-section' ); ?> main-section--margin-bottom--on" id="main" role="main">
            <?php do_action( 'lightning_main_section_prepend', 'lightning_main_section_prepend' ); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class( 'entry entry-full' ); ?>>
                <div class="entry-body haiia-about-content">

                    <!-- Mission・Vision・Values -->
                    <section class="haiia-about-section" id="mvv">
                        <h2 class="haiia-about-h2">Mission・Vision・Values</h2>

                        <div class="haiia-mvv-grid">
                            <!-- Mission -->
                            <div class="haiia-mvv-item haiia-mission">
                                <div class="haiia-mvv-label">Mission</div>
                                <h3>使命</h3>
                                <p class="haiia-mvv-lead"><strong>生成AI時代にふさわしい<br>"健全な教育"を普及する</strong></p>
                                <p>「健全」とは、技術偏重ではなく、人間中心であること。<br>倫理を欠いたAI活用ではなく、社会の持続性を考えたAI活用であること。</p>
                                <p>私たちは、AIを「人間を豊かにする道具」として位置づけ、<br>すべての人が健全にAIを学び、活用できる社会を実現します。</p>
                            </div>

                            <!-- Vision -->
                            <div class="haiia-mvv-item haiia-vision">
                                <div class="haiia-mvv-label">Vision</div>
                                <h3>展望</h3>
                                <p class="haiia-mvv-lead"><strong>誰一人取り残さないAI社会へ</strong></p>
                                <ul>
                                    <li>経済格差が、教育格差にならない社会</li>
                                    <li>年齢や職業に関係なく、誰もがAIを学べる社会</li>
                                    <li>技術の進歩が、人間の幸福につながる社会</li>
                                </ul>
                                <p class="haiia-mvv-goal"><strong>2030年までに、10万人にAI教育を届ける。</strong></p>
                            </div>
                        </div>

                        <!-- Values -->
                        <div class="haiia-values-section">
                            <div class="haiia-values-header">
                                <div class="haiia-mvv-label">Values</div>
                                <h3>価値観</h3>
                            </div>
                            <div class="haiia-values-grid">
                                <div class="haiia-value-item">
                                    <span class="haiia-value-num">1</span>
                                    <h4>人間中心<span>Human-Centered</span></h4>
                                    <p>AIは人間を支援するツールであり、人間を置き換えるものではない。</p>
                                </div>
                                <div class="haiia-value-item">
                                    <span class="haiia-value-num">2</span>
                                    <h4>倫理<span>Ethics</span></h4>
                                    <p>技術的に可能なことと、やるべきことは違う。常に倫理的判断を優先する。</p>
                                </div>
                                <div class="haiia-value-item">
                                    <span class="haiia-value-num">3</span>
                                    <h4>共創<span>Co-Creation</span></h4>
                                    <p>AIと人間、人間と人間が協働することで、より良い未来を創る。</p>
                                </div>
                                <div class="haiia-value-item">
                                    <span class="haiia-value-num">4</span>
                                    <h4>包摂性<span>Universal Design</span></h4>
                                    <p>年齢、性別、職業、地域、経済状況に関係なく、すべての人に学びの機会を。</p>
                                </div>
                                <div class="haiia-value-item">
                                    <span class="haiia-value-num">5</span>
                                    <h4>継続性<span>Sustainability</span></h4>
                                    <p>短期的な技術トレンドではなく、長期的に社会を豊かにする教育を。次世代に負の遺産を残さない、持続可能なAI活用を推進する。</p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- 目的・事業内容 -->
                    <section class="haiia-about-section" id="business">
                        <h2 class="haiia-about-h2">目的・事業内容</h2>
                        <p class="haiia-about-intro">当協会は以下の取り組みを中心に活動しています。</p>

                        <div class="haiia-business-grid">
                            <div class="haiia-business-item haiia-business-main">
                                <h4>AI時代に必要な7つの力の育成</h4>
                                <div class="haiia-skills-tags">
                                    <span>思考力</span>
                                    <span>セルフコーチング力</span>
                                    <span>言語化力</span>
                                    <span>コミュニケーション力</span>
                                    <span>リーダーシップ力</span>
                                    <span>チームビルド力</span>
                                    <span>プロジェクトマネジメント力</span>
                                </div>
                            </div>
                            <div class="haiia-business-item">
                                <h4>教育事業</h4>
                                <p>人財育成や教育者支援、資格認定</p>
                            </div>
                            <div class="haiia-business-item">
                                <h4>普及啓発</h4>
                                <p>AI倫理、情報リテラシー、安全な活用の推進</p>
                            </div>
                            <div class="haiia-business-item">
                                <h4>研究・開発</h4>
                                <p>学習評価・ダッシュボード、教育DXの実装支援</p>
                            </div>
                            <div class="haiia-business-item">
                                <h4>ユニバーサルデザイン教育・インクルーシブ教育</h4>
                                <p>障がいの有無や年齢、国籍に関わらず学べる環境づくり</p>
                            </div>
                            <div class="haiia-business-item">
                                <h4>生涯教育支援</h4>
                                <p>高齢者や外国人を含む多様な学習者へのサポート</p>
                            </div>
                            <div class="haiia-business-item">
                                <h4>社会貢献</h4>
                                <p>調査研究や政策提言を通じた教育・社会課題の解決</p>
                            </div>
                        </div>
                    </section>

                    <!-- 三本柱 -->
                    <section class="haiia-about-section haiia-pillars-section" id="pillars">
                        <h2 class="haiia-about-h2">三本柱</h2>
                        <p class="haiia-about-intro">協会の活動は、次の理念を土台としています。</p>

                        <div class="haiia-pillars-grid">
                            <div class="haiia-pillar-item">
                                <div class="haiia-pillar-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="m9 12 2 2 4-4"></path></svg>
                                </div>
                                <h4>倫理観</h4>
                                <p>人間中心・公正で透明性のあるAI活用</p>
                            </div>
                            <div class="haiia-pillar-item">
                                <div class="haiia-pillar-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path><path d="m7 10 3 3 7-7"></path><path d="M12 22v-6"></path></svg>
                                </div>
                                <h4>社会的持続性</h4>
                                <p>誰もが学び続けられる仕組みづくり</p>
                            </div>
                            <div class="haiia-pillar-item">
                                <div class="haiia-pillar-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                </div>
                                <h4>ユニバーサルデザイン</h4>
                                <p>多様な人に開かれた学習環境</p>
                            </div>
                        </div>
                    </section>

                    <!-- 沿革・設立背景 -->
                    <section class="haiia-about-section" id="history">
                        <h2 class="haiia-about-h2">沿革・設立背景</h2>

                        <div class="haiia-info-card">
                            <dl class="haiia-info-list">
                                <div class="haiia-info-row">
                                    <dt>設立</dt>
                                    <dd>2025年 6月 26日</dd>
                                </div>
                                <div class="haiia-info-row">
                                    <dt>初年度事業年度</dt>
                                    <dd>令和7年6月〜令和8年5月</dd>
                                </div>
                            </dl>
                        </div>
                    </section>

                    <!-- 役員 -->
                    <section class="haiia-about-section" id="officers">
                        <h2 class="haiia-about-h2">役員</h2>

                        <div class="haiia-officers-grid">
                            <div class="haiia-officer-item haiia-officer-representative">
                                <span class="haiia-officer-role">代表理事</span>
                                <span class="haiia-officer-name">伊藤 哲也</span>
                            </div>
                            <div class="haiia-officer-item">
                                <span class="haiia-officer-role">副理事</span>
                                <span class="haiia-officer-name">松元 春秋</span>
                            </div>
                            <div class="haiia-officer-item">
                                <span class="haiia-officer-role">理事</span>
                                <span class="haiia-officer-name">平井 哲哉</span>
                            </div>
                            <div class="haiia-officer-item">
                                <span class="haiia-officer-role">理事</span>
                                <span class="haiia-officer-name">伊東 雄歩</span>
                            </div>
                        </div>
                    </section>

                    <!-- アクセス -->
                    <section class="haiia-about-section" id="access">
                        <h2 class="haiia-about-h2">アクセス</h2>

                        <div class="haiia-access-content">
                            <div class="haiia-address">
                                <p class="haiia-postal">〒105-0004</p>
                                <p class="haiia-address-text">東京都港区新橋4-14-1 新橋AUNBLDG.4F</p>
                            </div>
                            <div class="haiia-map">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3241.4936565223875!2d139.75239523488767!3d35.6648449!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60188bbbd2955d91%3A0xe362337d40d56e0d!2z5paw5qmL77yh77y177yu44OT44Or!5e0!3m2!1sja!2sjp!4v1759250088861!5m2!1sja!2sjp" width="100%" height="400" style="border:0;border-radius:16px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        </div>
                    </section>

                    <!-- 定款PDF -->
                    <section class="haiia-about-section haiia-document-section" id="document">
                        <div class="haiia-document-cta">
                            <p>協会の定款など詳細資料をご覧いただけます。</p>
                            <a href="https://haiia.org/wp-content/uploads/2025/10/定款_一般社団法人健全AI教育協会_v1.0.pdf" class="haiia-document-btn" target="_blank" rel="noopener noreferrer">
                                定款を見る（PDF）
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                            </a>
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
