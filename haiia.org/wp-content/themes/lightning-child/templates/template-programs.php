<?php
/**
 * Template Name: 教育・研修プログラム
 * Description: HAIIAの教育・研修プログラムページ専用テンプレート
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
        <h1 class="haiia-page-title">教育・研修プログラム</h1>
        <p class="haiia-page-subtitle">Education & Training Programs</p>
    </div>
</div>

<?php do_action( 'lightning_site_body_before', 'lightning_site_body_before' ); ?>

<div class="<?php lightning_the_class_name( 'site-body' ); ?> haiia-programs">
    <?php do_action( 'lightning_site_body_prepend', 'lightning_site_body_prepend' ); ?>

    <div class="<?php lightning_the_class_name( 'site-body-container' ); ?> container">

        <div class="<?php lightning_the_class_name( 'main-section' ); ?> main-section--margin-bottom--on" id="main" role="main">
            <?php do_action( 'lightning_main_section_prepend', 'lightning_main_section_prepend' ); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class( 'entry entry-full' ); ?>>
                <div class="entry-body haiia-programs-content">

                    <!-- 導入セクション -->
                    <section class="haiia-programs-section haiia-programs-intro">
                        <h2 class="haiia-programs-h2">次世代AI教育プログラム</h2>
                        <p class="haiia-programs-lead">このプログラムは、年齢や職業に関係なく「AIと共に学び、創造する力」を育てるための<br>ユニバーサルな教育体系です。生成AIを"拡張知能"として安全かつ効果的に活用する力を身につけます。</p>
                    </section>

                    <!-- 目的 -->
                    <section class="haiia-programs-section" id="purpose">
                        <h3 class="haiia-programs-h3">
                            <span class="haiia-programs-icon">&#x1f3af;</span>
                            目的
                        </h3>

                        <ul class="haiia-programs-list">
                            <li>「AI時代に必要な４つの力」を段階的に育成<br><span class="haiia-programs-note">（コミュニケーション力・言語力・セルフコーチング力・プロジェクトマネジメント力）</span></li>
                            <li>AIリテラシー・倫理・安全活用を実践的に学ぶ</li>
                            <li>個別最適学習と協働学習を両立する"ハイブリッド教育"を推進</li>
                        </ul>
                    </section>

                    <!-- カリキュラム構成（3層モデル） -->
                    <section class="haiia-programs-section" id="curriculum">
                        <h3 class="haiia-programs-h3">
                            <span class="haiia-programs-icon">&#x1f9e9;</span>
                            カリキュラム構成（３層モデル）
                        </h3>

                        <!-- 基礎ユニット -->
                        <div class="haiia-programs-unit">
                            <h4 class="haiia-programs-h4">
                                <span class="haiia-programs-unit-num">1</span>
                                基礎ユニット：生成AIの仕組みと使い方
                            </h4>
                            <p class="haiia-programs-target">対象：学生・社会人・初心者（Lv1〜2）</p>
                            <ul class="haiia-programs-list haiia-programs-list-compact">
                                <li>生成AIの原理と安全利用（著作権・個人情報保護・バイアス）</li>
                                <li>プロンプト基礎（目的・条件・文脈・出力形式）</li>
                                <li>要約・校正・言い換えワーク</li>
                                <li>自己調整型学習（セルフモニタリング・振り返り）</li>
                            </ul>
                        </div>

                        <!-- 応用ユニット -->
                        <div class="haiia-programs-unit">
                            <h4 class="haiia-programs-h4">
                                <span class="haiia-programs-unit-num">2</span>
                                応用ユニット：仕事・学習でのAI活用スキル
                            </h4>
                            <p class="haiia-programs-target">対象：社会人・教育者・研究者（Lv2〜4）</p>
                            <ul class="haiia-programs-list haiia-programs-list-compact">
                                <li>Chain-of-Thought（思考の連鎖）を用いた課題解決</li>
                                <li>資料再構成・論理的表現・多言語化</li>
                                <li>プロジェクト管理（WBS・ガント・KPI設計）</li>
                                <li>自動化ツール（Notion／Zapier等）の実践</li>
                            </ul>
                        </div>

                        <!-- 探究・プロジェクト型学習 -->
                        <div class="haiia-programs-unit haiia-programs-unit-paic">
                            <h4 class="haiia-programs-h4">
                                <span class="haiia-programs-unit-num">3</span>
                                探究・プロジェクト型学習「P-A-I-C」
                            </h4>
                            <p class="haiia-programs-paic-desc"><strong>Prompt → Ask → Iterate → Create</strong><br>AIを循環的に活用し、現実の課題解決プロジェクトを実施します。</p>
                            <ul class="haiia-programs-list haiia-programs-list-compact">
                                <li><strong>学校版：</strong>地域課題・環境・福祉・SDGsなどをテーマに探究</li>
                                <li><strong>企業版：</strong>DX推進・新規事業立案・業務改善プロジェクト</li>
                                <li><strong>成果発表：</strong>AIポートフォリオ＋ピアレビュー＋デジタルバッジ認定</li>
                            </ul>
                        </div>
                    </section>

                    <!-- 教育者・講師育成プログラム -->
                    <section class="haiia-programs-section" id="educator">
                        <h3 class="haiia-programs-h3">
                            <span class="haiia-programs-icon">&#x1f469;&#x200d;&#x1f3eb;</span>
                            教育者・講師育成プログラム
                        </h3>

                        <p class="haiia-programs-desc">AIを教える教育者・講師・管理職のためのステップアップ制度を運用しています。</p>

                        <div class="haiia-programs-table-wrapper">
                            <table class="haiia-programs-table">
                                <thead>
                                    <tr>
                                        <th>レベル</th>
                                        <th>概要</th>
                                        <th>主な成果物</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><span class="haiia-programs-level">L0</span></td>
                                        <td>ICT・AI基礎理解</td>
                                        <td>倫理チェックシート</td>
                                    </tr>
                                    <tr>
                                        <td><span class="haiia-programs-level">L1</span></td>
                                        <td>単発授業導入</td>
                                        <td>授業設計書・15分授業動画</td>
                                    </tr>
                                    <tr>
                                        <td><span class="haiia-programs-level">L2</span></td>
                                        <td>年間設計・評価ルーブリック作成</td>
                                        <td>学期シラバス</td>
                                    </tr>
                                    <tr>
                                        <td><span class="haiia-programs-level">L3</span></td>
                                        <td>校内・社内リーダー養成</td>
                                        <td>AI運用ハンドブック</td>
                                    </tr>
                                    <tr>
                                        <td><span class="haiia-programs-level">L4</span></td>
                                        <td>政策提言・研究発表</td>
                                        <td>白書・オープン教材</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <!-- 評価と認定 -->
                    <section class="haiia-programs-section" id="evaluation">
                        <h3 class="haiia-programs-h3">
                            <span class="haiia-programs-icon">&#x1f4ca;</span>
                            評価と認定
                        </h3>

                        <p class="haiia-programs-desc">学習成果は「知識」だけでなく「行動変容」を重視して評価します。</p>

                        <ul class="haiia-programs-list">
                            <li>Lv1〜5評価ルーブリック</li>
                            <li>AIログ・自己評価・相互評価を統合した形成的評価</li>
                            <li>OpenBadge（デジタル認定証）発行</li>
                            <li>成果物ポートフォリオをオンラインで可視化</li>
                        </ul>
                    </section>

                    <!-- 年間スケジュール例 -->
                    <section class="haiia-programs-section" id="schedule">
                        <h3 class="haiia-programs-h3">
                            <span class="haiia-programs-icon">&#x1f4c5;</span>
                            年間スケジュール例
                        </h3>

                        <div class="haiia-programs-table-wrapper">
                            <table class="haiia-programs-table haiia-programs-schedule-table">
                                <thead>
                                    <tr>
                                        <th>学期</th>
                                        <th>主な内容</th>
                                        <th>連携機関</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><span class="haiia-programs-season haiia-programs-spring">春（4〜6月）</span></td>
                                        <td>基礎ユニット＋行動計画ワークショップ</td>
                                        <td>学校・保護者</td>
                                    </tr>
                                    <tr>
                                        <td><span class="haiia-programs-season haiia-programs-summer">夏（7〜9月）</span></td>
                                        <td>応用ユニット：情報再構成・リテラシー</td>
                                        <td>図書館・地域施設</td>
                                    </tr>
                                    <tr>
                                        <td><span class="haiia-programs-season haiia-programs-autumn">秋（10〜12月）</span></td>
                                        <td>探究・協働プロジェクト＋AI倫理週間</td>
                                        <td>教育委員会・企業</td>
                                    </tr>
                                    <tr>
                                        <td><span class="haiia-programs-season haiia-programs-winter">冬（1〜3月）</span></td>
                                        <td>成果発表会・地域報告・認定授与</td>
                                        <td>地域社会・メディア</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <!-- 連携・サポート体制 -->
                    <section class="haiia-programs-section" id="support">
                        <h3 class="haiia-programs-h3">
                            <span class="haiia-programs-icon">&#x1f310;</span>
                            連携・サポート体制
                        </h3>

                        <ul class="haiia-programs-list">
                            <li>オンライン相談室（初心者・教育者向け）</li>
                            <li>教育ラボ（教材開発・共同研究）</li>
                            <li>ピアコミュニティ（Slack／Discord）</li>
                            <li>外部エキスパートによるメンタリングプログラム</li>
                        </ul>
                    </section>

                    <!-- 引用メッセージ -->
                    <section class="haiia-programs-section haiia-programs-quote-section">
                        <blockquote class="haiia-programs-quote">
                            <p><strong>AIと人が共創する学びへ。</strong><br>健全AI教育協会のプログラムは、未来の教育と社会をつなぐ架け橋です。</p>
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
