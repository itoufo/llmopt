<?php
/**
 * Template Name: 協会活動
 * Description: HAIIAの協会活動ページ専用テンプレート
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

<div class="<?php lightning_the_class_name( 'site-body' ); ?> haiia-activities">
    <?php do_action( 'lightning_site_body_prepend', 'lightning_site_body_prepend' ); ?>

    <!-- ページヘッダー -->
    <div class="haiia-page-header">
        <div class="container">
            <h1 class="haiia-page-title">協会活動</h1>
            <p class="haiia-page-subtitle">Our Activities</p>
        </div>
    </div>

    <div class="<?php lightning_the_class_name( 'site-body-container' ); ?> container">

        <div class="<?php lightning_the_class_name( 'main-section' ); ?> main-section--margin-bottom--on" id="main" role="main">
            <?php do_action( 'lightning_main_section_prepend', 'lightning_main_section_prepend' ); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class( 'entry entry-full' ); ?>>
                <div class="entry-body haiia-activities-content">

                    <!-- 導入セクション -->
                    <section class="haiia-activities-section haiia-activities-intro">
                        <h2 class="haiia-activities-h2">一般社団法人 健全AI教育協会の活動</h2>
                        <p class="haiia-activities-lead">「生成AI時代にふさわしい"健全な教育"を広める」ことを使命に、<br>私たちは教育・企業・地域社会が連携し、AIと人間が共に成長する仕組みを構築しています。</p>
                    </section>

                    <!-- ミッション・ビジョン -->
                    <section class="haiia-activities-section" id="mvv">
                        <h3 class="haiia-activities-h3">
                            <span class="haiia-activities-icon">&#x1f9ed;</span>
                            ミッション・ビジョン
                        </h3>

                        <div class="haiia-activities-mvv-grid">
                            <div class="haiia-activities-mvv-item">
                                <span class="haiia-activities-mvv-label">Mission（使命）</span>
                                <p>生成AI時代にふさわしい「健全な教育」を普及すること。</p>
                            </div>
                            <div class="haiia-activities-mvv-item">
                                <span class="haiia-activities-mvv-label">Vision（未来像）</span>
                                <p>誰一人取り残さないAI社会を実現する。</p>
                            </div>
                            <div class="haiia-activities-mvv-item">
                                <span class="haiia-activities-mvv-label">Values（価値観）</span>
                                <p>人間中心・倫理・共創・包摂性・透明性</p>
                            </div>
                        </div>
                    </section>

                    <!-- 1. 教育のスタンダード策定と普及 -->
                    <section class="haiia-activities-section" id="standard">
                        <h3 class="haiia-activities-h3">
                            <span class="haiia-activities-icon">&#x1f3eb;</span>
                            1．教育のスタンダード策定と普及
                        </h3>

                        <p class="haiia-activities-desc">協会では、全国の教育現場・企業・自治体が共通して使える<br>「次世代AI教育スタンダード（2025）」を策定し、実践モデルを提供しています。</p>

                        <ul class="haiia-activities-list">
                            <li>生成AIを活用した新しい学習パラダイムの提唱</li>
                            <li>「AI時代に必要な４つの力」の体系化<br><span class="haiia-activities-note">（コミュニケーション力／言語力／セルフコーチング力／プロジェクトマネジメント力）</span></li>
                            <li>カリキュラム・マネジメントと評価ルーブリックの開発</li>
                            <li>ユニバーサルデザイン教育・インクルーシブ教育の推進</li>
                        </ul>
                    </section>

                    <!-- 2. 教育者支援と資格認定制度 -->
                    <section class="haiia-activities-section" id="certification">
                        <h3 class="haiia-activities-h3">
                            <span class="haiia-activities-icon">&#x1f469;&#x200d;&#x1f3eb;</span>
                            2．教育者支援と資格認定制度
                        </h3>

                        <p class="haiia-activities-desc">AI時代の教育を担う"教える人"を支えるため、教育者・講師・企業研修担当者向けに<br>体系的な研修と資格制度を運営しています。</p>

                        <ul class="haiia-activities-list">
                            <li>教員・講師・ファシリテーター向けのスキルマップ（L0〜L4）</li>
                            <li>ハンズオン研修・eラーニング・PBL形式の実践講座</li>
                            <li>OpenBadgeによる認定証・修了証のデジタル発行</li>
                            <li>全国教育者コミュニティ（オンラインサロン／Slack／研究会）の運営</li>
                        </ul>
                    </section>

                    <!-- 3. 社会連携・研究・政策提言 -->
                    <section class="haiia-activities-section" id="collaboration">
                        <h3 class="haiia-activities-h3">
                            <span class="haiia-activities-icon">&#x1f91d;</span>
                            3．社会連携・研究・政策提言
                        </h3>

                        <p class="haiia-activities-desc">AIの普及がもたらす社会変化（教育格差・雇用構造・倫理課題など）に対し、<br>実証研究・共同プロジェクト・政策提言を通じて社会実装を進めています。</p>

                        <ul class="haiia-activities-list">
                            <li>教育委員会・大学・企業・自治体との連携事業</li>
                            <li>AI倫理・情報リテラシー・セキュリティ啓発活動</li>
                            <li>AIリテラシー普及キャンペーン／ワークショップ開催</li>
                            <li>地域・世代を超えた生涯学習モデルの構築</li>
                        </ul>
                    </section>

                    <!-- 4. 国際協働と普及活動 -->
                    <section class="haiia-activities-section" id="international">
                        <h3 class="haiia-activities-h3">
                            <span class="haiia-activities-icon">&#x1f30d;</span>
                            4．国際協働と普及活動
                        </h3>

                        <p class="haiia-activities-desc">国際的なAI教育ネットワークとも連携し、研究成果を世界へ発信しています。</p>

                        <ul class="haiia-activities-list">
                            <li>OECD／UNESCO／ISTEなどとの情報交換・登壇</li>
                            <li>国際シンポジウム・海外教育機関連携</li>
                            <li>多言語教材・オープンリソースの発行</li>
                        </ul>
                    </section>

                    <!-- 5. これからの取り組み -->
                    <section class="haiia-activities-section" id="future">
                        <h3 class="haiia-activities-h3">
                            <span class="haiia-activities-icon">&#x1f4ac;</span>
                            5．これからの取り組み
                        </h3>

                        <ul class="haiia-activities-list haiia-activities-future-list">
                            <li>学校・企業・行政が共同で運営する「AI教育ラボ」の設立</li>
                            <li>AI時代に対応した評価ダッシュボード・ポートフォリオの開発</li>
                            <li>各地域での「AI×教育フェス」「リテラシー・ワークショップ」の開催</li>
                        </ul>
                    </section>

                    <!-- 引用メッセージ -->
                    <section class="haiia-activities-section haiia-activities-quote-section">
                        <blockquote class="haiia-activities-quote">
                            <p><strong>AIは人を代替するものではなく、人を拡張するもの。</strong><br>健全AI教育協会は、すべての人がAIと共に成長できる社会の実現を目指します。</p>
                        </blockquote>
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
