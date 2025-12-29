<?php
/**
 * Template Name: TOPページ
 * Description: HAIIAのトップページ専用テンプレート
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

use VektorInc\VK_Breadcrumb\VkBreadcrumb;

get_header();
?>

<?php
do_action( 'lightning_site_header_before', 'lightning_site_header_before' );
if ( apply_filters( 'lightning_is_site_header', true, 'site_header' ) ) {
    lightning_get_template_part( 'template-parts/site-header' );
}
do_action( 'lightning_site_header_after', 'lightning_site_header_after' );
?>

<?php
// スライダー表示
if ( apply_filters( 'lightning_default_slide_display', true ) ) {
    if ( class_exists( 'LTG_G3_Slider' ) ) {
        LTG_G3_Slider::display_html();
    }
}
?>

<?php do_action( 'lightning_site_body_before', 'lightning_site_body_before' ); ?>

<div class="<?php lightning_the_class_name( 'site-body' ); ?> haiia-home">
    <?php do_action( 'lightning_site_body_prepend', 'lightning_site_body_prepend' ); ?>
    <div class="<?php lightning_the_class_name( 'site-body-container' ); ?> container">

        <div class="<?php lightning_the_class_name( 'main-section' ); ?> main-section--margin-bottom--on" id="main" role="main">
            <?php do_action( 'lightning_main_section_prepend', 'lightning_main_section_prepend' ); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class( 'entry entry-full' ); ?>>
                <div class="entry-body haiia-home-content">

                    <!-- セクション1: 導入 -->
                    <section class="haiia-section haiia-intro">
                        <h3 class="haiia-section-title"><strong>AIは、もう"未来"ではない。</strong></h3>

                        <ul class="haiia-list">
                            <li>オフィスでは、ChatGPTが企画書を書き、議事録を要約している。</li>
                            <li>教育現場では、生徒がAIで宿題を解き、教師がその対応に悩んでいる。</li>
                            <li>医療・金融・製造・物流──あらゆる産業でAIが意思決定を支援し始めている。</li>
                        </ul>

                        <p><strong>しかし、多くの人が取り残されている。</strong></p>

                        <p>経済産業省の調査によれば、2030年までに<strong>AI人材が約79万人不足</strong>すると予測されています。<br>
                        これは単なる「エンジニア不足」の話ではありません。</p>

                        <p><strong>すべての職種で、AIを理解し、活用できるかどうかが、キャリアの分かれ道になる時代です。</strong></p>
                    </section>

                    <hr class="wp-block-separator has-alpha-channel-opacity">

                    <!-- セクション2: 3つの深刻な格差 -->
                    <section class="haiia-section haiia-gaps">
                        <h3 class="haiia-section-title">3つの深刻な格差</h3>

                        <div class="haiia-gap-item">
                            <h4>1. 教育格差</h4>
                            <ul class="haiia-list">
                                <li>AI教育を受けられる子どもと、受けられない子ども</li>
                                <li>都市部の進学校と地方校、公立と私立の間で広がる情報格差</li>
                                <li>親のリテラシーによって決まる子どもの未来</li>
                            </ul>
                        </div>

                        <div class="haiia-gap-item">
                            <h4>2. 雇用格差</h4>
                            <ul class="haiia-list">
                                <li>AIを使いこなせる人材は年収650万円以上</li>
                                <li>使えない人材は年収400万円以下に集中</li>
                                <li>企業の87%が「AI人材育成が急務」と回答（2024年調査）</li>
                            </ul>
                        </div>

                        <div class="haiia-gap-item">
                            <h4>3. 倫理の空白</h4>
                            <ul class="haiia-list">
                                <li>フェイクニュースの氾濫、AIによる差別、著作権侵害</li>
                                <li>「技術は進んだが、人間の判断力は追いついていない」</li>
                            </ul>
                        </div>
                    </section>

                    <hr class="wp-block-separator has-alpha-channel-opacity">

                    <!-- メッセージ -->
                    <section class="haiia-section haiia-message">
                        <h3 class="haiia-section-title haiia-highlight"><strong>AIの進化は止められない。</strong><br><strong>止めるべきは、「人間の思考停止」。</strong></h3>
                    </section>

                    <hr class="wp-block-separator has-alpha-channel-opacity">

                    <!-- セクション3: 2つの未来 -->
                    <section class="haiia-section haiia-futures">
                        <h2 class="haiia-main-title">このままではどんな未来になるのか？</h2>
                        <h3 class="haiia-section-title"><strong>2030年、あなたの子どもはどちらの世界で生きていますか？</strong></h3>

                        <h3 class="haiia-subtitle">左右比較：2つの未来</h3>

                        <div class="haiia-comparison-table">
                            <table class="has-fixed-layout">
                                <thead>
                                    <tr>
                                        <th class="has-text-align-center"><strong>未来A：AIに支配される社会</strong></th>
                                        <th class="has-text-align-center"><strong>未来B：AIと共に創造する社会</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="has-text-align-center future-a">🚨 富が少数のAIエリートに集中</td>
                                        <td class="has-text-align-center future-b">✨ すべての人がAIを"学びの相棒"に</td>
                                    </tr>
                                    <tr>
                                        <td class="has-text-align-center future-a">🚨 AIリテラシーのない人材は低賃金労働へ</td>
                                        <td class="has-text-align-center future-b">✨ AI活用で創造的な仕事に集中できる</td>
                                    </tr>
                                    <tr>
                                        <td class="has-text-align-center future-a">🚨 フェイクと分断が社会を蝕む</td>
                                        <td class="has-text-align-center future-b">✨ 多世代・多文化の協働が進む</td>
                                    </tr>
                                    <tr>
                                        <td class="has-text-align-center future-a">🚨 倫理が欠落し、監視社会が進行</td>
                                        <td class="has-text-align-center future-b">✨ 人間中心・倫理的なAI社会が実現</td>
                                    </tr>
                                    <tr>
                                        <td class="has-text-align-center future-a">🚨 教育格差が固定化し、階層が分断</td>
                                        <td class="has-text-align-center future-b">✨ すべての子どもに質の高い教育が届く</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <hr class="wp-block-separator has-alpha-channel-opacity">

                    <!-- 未来Aの詳細 -->
                    <section class="haiia-section haiia-future-detail">
                        <h3 class="haiia-section-title">詳細解説</h3>

                        <div class="haiia-future-box haiia-future-a">
                            <h4>未来A：AIに支配される社会（放置した場合）</h4>
                            <p><strong>2030年のある日常──</strong></p>
                            <p>あなたの同僚は、AIを使って2時間で終わらせた仕事を、あなたは8時間かけている。<br>昇進の機会は、当然「AI活用できる人材」に集中する。</p>
                            <p>子どもの学校では、プログラミングやAIリテラシーを学べる家庭の子どもが進学し、<br>そうでない家庭の子どもは「AIに使われる側」の仕事に就く。</p>
                            <p>SNSには、AIが生成したフェイクニュースが溢れ、何が真実か分からなくなる。<br>企業は利益最優先でAIを導入し、倫理的配慮は後回しに。</p>
                            <p><strong>これは、SF映画の話ではありません。</strong><br><strong>今、何もしなければ訪れる、現実のシナリオです。</strong></p>
                        </div>

                        <hr class="wp-block-separator has-alpha-channel-opacity">

                        <div class="haiia-future-box haiia-future-b">
                            <h4>未来B：AIと共に創造する社会（HAIIAが目指す未来）</h4>
                            <p><strong>2030年のある日常──</strong></p>
                            <p>あなたは、単純作業をAIに任せ、創造的な仕事に集中している。<br>AIが企画のたたき台を作り、あなたがそれを磨き上げ、チームで議論する。</p>
                            <p>子どもの学校では、すべての生徒が「AIとの協働」を学んでいる。<br>家庭の経済状況に関係なく、質の高いAI教育が届いている。</p>
                            <p>企業は「人間中心のAI活用」を掲げ、倫理的な判断を重視している。<br>AIは人間を支援するツールであり、決して人間を支配しない。</p>
                            <p><strong>この未来は、今、行動すれば実現できます。</strong></p>
                        </div>
                    </section>

                    <hr class="wp-block-separator has-alpha-channel-opacity">

                    <section class="haiia-section haiia-message">
                        <h3 class="haiia-section-title haiia-highlight"><strong>未来は、選べる。</strong><br><strong>今、あなたが何を学び、どう行動するかで決まる。</strong></h3>
                    </section>

                    <hr class="wp-block-separator has-alpha-channel-opacity">

                    <!-- セクション4: 何が必要か -->
                    <section class="haiia-section haiia-needs">
                        <h2 class="haiia-main-title">より良い未来にするために ― 何が必要か？</h2>
                        <h3 class="haiia-section-title"><strong>AIは"敵"ではない。人間の創造性を映す"鏡"だ。</strong></h3>

                        <h3 class="haiia-subtitle">AIを恐れる必要はありません。<br>AIは、あなたの指示通りに動くツールです。</h3>
                        <p><strong>問題は、「何を指示すればいいか分からない」こと。</strong></p>
                        <p>多くの人が、AIを「魔法の箱」だと思っています。<br>しかし、AIは魔法ではありません。</p>
                        <p>AIは、<strong>あなたの思考を拡張する道具</strong>です。</p>
                    </section>

                    <hr class="wp-block-separator has-alpha-channel-opacity">

                    <!-- 必要な力 -->
                    <section class="haiia-section haiia-skills">
                        <h3 class="haiia-section-title">必要なのは「操作力」ではなく「共に生きる力」</h3>
                        <p>HAIIAが重視するのは、単なる「AIツールの使い方」ではありません。</p>

                        <h4>私たちが育てるのは、こんな力です：</h4>

                        <div class="haiia-skill-grid">
                            <div class="haiia-skill-item">
                                <h5><strong>1. AIに何を問うべきか、考える力</strong></h5>
                                <ul class="haiia-list">
                                    <li>問題の本質を見抜く思考力</li>
                                    <li>AIが答えられる問いに変換する言語化力</li>
                                </ul>
                            </div>

                            <div class="haiia-skill-item">
                                <h5><strong>2. AIの出力を評価・判断する力</strong></h5>
                                <ul class="haiia-list">
                                    <li>AIの回答が正しいか検証する批判的思考</li>
                                    <li>倫理的に問題ないか判断する価値観</li>
                                </ul>
                            </div>

                            <div class="haiia-skill-item">
                                <h5><strong>3. AIと人間が協働するデザイン力</strong></h5>
                                <ul class="haiia-list">
                                    <li>業務フローを再設計する構造化思考</li>
                                    <li>チームでAIを活用するコミュニケーション力</li>
                                </ul>
                            </div>

                            <div class="haiia-skill-item">
                                <h5><strong>4. 人間としての倫理観・哲学</strong></h5>
                                <ul class="haiia-list">
                                    <li>AIに何をさせるべきか、させるべきでないかを判断する倫理観</li>
                                    <li>社会の持続性を考えるマインドセット</li>
                                </ul>
                            </div>
                        </div>
                    </section>

                    <hr class="wp-block-separator has-alpha-channel-opacity">

                    <!-- 能力の階層図 -->
                    <section class="haiia-section haiia-pyramid">
                        <h3 class="haiia-section-title">図解：AI時代の能力の階層</h3>
                        <?php
                        // カスタムフィールドから画像を取得、なければデフォルト画像を使用
                        $pyramid_image = get_field( 'pyramid_image' );
                        if ( ! $pyramid_image ) {
                            // メディアライブラリから画像を検索
                            $pyramid_image = 'https://haiia.org/wp-content/uploads/2025/10/生成AIを活用するための思考力～考えるってなに？～-1.png';
                        }
                        ?>
                        <figure class="haiia-pyramid-image">
                            <img src="<?php echo esc_url( $pyramid_image ); ?>" alt="AI時代の能力の階層" class="aligncenter" style="width:100%;max-width:998px;height:auto;">
                        </figure>
                        <p class="has-text-align-center"><strong>土台がなければ、どんなツールも使いこなせない。</strong><br><strong>HAIIAは、土台から育てます。</strong></p>
                    </section>

                    <hr class="wp-block-separator has-alpha-channel-opacity">

                    <!-- 各層の詳細解説 -->
                    <section class="haiia-section haiia-layers">
                        <h3 class="haiia-section-title">各層の詳細解説</h3>

                        <div class="haiia-layer-item">
                            <h4><strong>ベース層：マインド・人としての在り方</strong></h4>
                            <p><strong>なぜAIを使うのか？誰のために使うのか？</strong></p>
                            <p>この問いに答えられない人は、AIを使いこなせません。</p>
                            <ul class="haiia-list">
                                <li><strong>倫理観</strong>：AIに何をさせるべきか、させるべきでないか</li>
                                <li><strong>哲学</strong>：AI時代における人間の役割とは何か</li>
                                <li><strong>社会持続性</strong>：AIが社会に与える影響を考える</li>
                                <li><strong>ユニバーサルデザイン</strong>：すべての人がAIの恩恵を受けられるように</li>
                            </ul>
                            <p><strong>HAIIAの全てのプログラムは、この層から始まります。</strong></p>
                        </div>

                        <hr class="wp-block-separator has-alpha-channel-opacity">

                        <div class="haiia-layer-item">
                            <h4><strong>第2層-1：個人スキル</strong></h4>
                            <p><strong>AIに何を問い、どう判断するか</strong></p>
                            <ul class="haiia-list">
                                <li><strong>思考力</strong>：問題の本質を見抜く構造化思考</li>
                                <li><strong>言語化力</strong>：AIに的確な指示を出すプロンプト設計</li>
                                <li><strong>批判的思考</strong>：AIの出力を鵜呑みにせず、検証する</li>
                                <li><strong>セルフコーチング</strong>：自分の学びを最適化する</li>
                            </ul>
                        </div>

                        <hr class="wp-block-separator has-alpha-channel-opacity">

                        <div class="haiia-layer-item">
                            <h4><strong>第2層-2：実現スキル</strong></h4>
                            <p><strong>チームでAIを活用し、プロジェクトを成功させる</strong></p>
                            <ul class="haiia-list">
                                <li><strong>プロジェクトマネジメント</strong>：AI活用を計画・実行・評価</li>
                                <li><strong>リーダーシップ</strong>：AI時代のチームを導く</li>
                                <li><strong>チームビルディング</strong>：AIと人間の役割分担を設計</li>
                                <li><strong>コミュニケーション</strong>：非技術者にAIを説明する</li>
                            </ul>
                        </div>

                        <hr class="wp-block-separator has-alpha-channel-opacity">

                        <div class="haiia-layer-item">
                            <h4><strong>第3層-1：専門スキル（開発系）</strong></h4>
                            <p><strong>Webアプリ開発AI専門コース</strong></p>
                            <ol class="haiia-numbered-list">
                                <li><strong>要件定義</strong>：現状分析ヒアリングから要件の本質を定義</li>
                                <li><strong>基本設計</strong>：UI/UX、セキュリティ、ログイン認証、データベース設計</li>
                                <li><strong>AI開発</strong>：Lovableを使ったWebアプリ開発</li>
                                <li><strong>デプロイ</strong>：環境構築（AWS・GCP・Azure・オンプレ）</li>
                            </ol>
                        </div>

                        <hr class="wp-block-separator has-alpha-channel-opacity">

                        <div class="haiia-layer-item">
                            <h4><strong>第3層-2：専門スキル（業務改善系）</strong></h4>
                            <p><strong>AIエージェント業務改善コース</strong></p>
                            <ol class="haiia-numbered-list">
                                <li><strong>業務プロセス分析</strong>：現状の業務フローを可視化・分析</li>
                                <li><strong>改善計画・設計</strong>：To-Beプロセスの設計・ROI算出</li>
                                <li><strong>AI実装</strong>：GPTBotsによるAIエージェント作成</li>
                                <li><strong>導入・評価</strong>：組織への定着と効果測定</li>
                            </ol>
                        </div>
                    </section>

                    <hr class="wp-block-separator has-alpha-channel-opacity">

                    <!-- セクション5: 今やるべきこと -->
                    <section class="haiia-section haiia-action">
                        <h2 class="haiia-main-title">今、あなたがやるべきこと</h2>
                        <h3 class="haiia-section-title"><strong>まず、知ることから始めよう。</strong></h3>

                        <div class="haiia-steps">
                            <div class="haiia-step">
                                <h3>ステップ1：自分の立ち位置を知る</h3>
                                <p><strong>あなたは今、AIリテラシーのどの段階にいますか？</strong></p>
                                <ul class="haiia-level-list">
                                    <li><strong>Level 0：AIを使ったことがない</strong><br>→ 基礎講座から始めましょう</li>
                                    <li><strong>Level 1：ChatGPTを使ったことがある</strong><br>→ プロンプトエンジニアリングを学びましょう</li>
                                    <li><strong>Level 2：業務でAIを活用している</strong><br>→ 専門スキルを体系的に習得しましょう</li>
                                    <li><strong>Level 3：AIを使いこなしている</strong><br>→ 他者に教える側へステップアップしましょう</li>
                                </ul>
                                <p><a href="<?php echo home_url('/aitaskananalysis/'); ?>" class="haiia-cta-link"><strong>AIリテラシーレベル診断（3分）</strong></a></p>
                            </div>

                            <hr class="wp-block-separator has-alpha-channel-opacity">

                            <div class="haiia-step">
                                <h3>ステップ2：学び、実践し、共に考える</h3>
                                <p><strong>一人で学ぶのは、限界があります。</strong></p>
                                <p>HAIIAは、単なる「オンライン講座」ではありません。</p>
                                <ul class="haiia-list">
                                    <li><strong>実務家による指導</strong>：現役のシステムコンサルタント、企業幹部が直接教えます</li>
                                    <li><strong>実プロジェクトで学ぶ</strong>：架空の課題ではなく、実在する企業の課題を解決します</li>
                                    <li><strong>コミュニティで成長</strong>：同じ目標を持つ仲間と、切磋琢磨できます</li>
                                </ul>
                            </div>

                            <hr class="wp-block-separator has-alpha-channel-opacity">

                            <div class="haiia-step">
                                <h3>ステップ3：協会に参加し、社会を変える側へ</h3>
                                <p><strong>AI教育を変えるのは、あなたの一歩。</strong></p>
                                <p>HAIIAは、「教育を受ける場」であると同時に、「教育を変える活動」に参加する場です。</p>
                                <ul class="haiia-list">
                                    <li>正会員として、協会の方針決定に参加できます</li>
                                    <li>認定講師として、次世代に教える側になれます</li>
                                    <li>法人会員として、企業のDX推進を支援できます</li>
                                </ul>
                            </div>
                        </div>
                    </section>

                    <hr class="wp-block-separator has-alpha-channel-opacity">

                    <!-- セクション6: 参加・協働 -->
                    <section class="haiia-section haiia-join">
                        <h2 class="haiia-main-title">参加・協働</h2>
                        <h3 class="haiia-section-title"><strong>AI教育を変えるのは、あなたの一歩。</strong></h3>

                        <h3 class="haiia-subtitle">HAIIAは、単なる「教育サービス」ではありません。</h3>
                        <p>私たちは、<strong>日本のAI教育を根本から変革する運動体</strong>です。</p>
                        <p>あなたがHAIIAに参加することは、<br>自分自身の成長であると同時に、<br>次世代のために、より良い教育環境を創ることでもあります。</p>
                    </section>

                    <hr class="wp-block-separator has-alpha-channel-opacity">

                    <!-- 会員区分テーブル -->
                    <section class="haiia-section haiia-membership">
                        <h3 class="haiia-section-title">会員区分と参加方法</h3>

                        <div class="haiia-table-wrapper">
                            <table class="has-fixed-layout haiia-membership-table">
                                <thead>
                                    <tr>
                                        <th>会員区分</th>
                                        <th>内容</th>
                                        <th>年会費</th>
                                        <th>特典</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>正会員</strong></td>
                                        <td>協会の活動主体<br>社員総会での議決権あり</td>
                                        <td><strong>年10,000円</strong><br>または<strong>月1,000円</strong></td>
                                        <td>・教育プログラム優待<br>・認定試験受験資格<br>・オンラインコミュニティ参加<br>・会員証発行</td>
                                    </tr>
                                    <tr>
                                        <td><strong>賛助会員</strong></td>
                                        <td>協会を支援（個人・法人）</td>
                                        <td><strong>年30,000円〜</strong></td>
                                        <td>・イベント優先招待<br>・年次報告書送付<br>・公式サイトに支援者として掲載（希望者）</td>
                                    </tr>
                                    <tr>
                                        <td><strong>法人会員</strong></td>
                                        <td>企業・学校として参加<br>従業員向け研修提供</td>
                                        <td><strong>別途規程</strong></td>
                                        <td>・法人向け研修プログラム<br>・従業員のスキル可視化<br>・導入支援・効果測定</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <hr class="wp-block-separator has-alpha-channel-opacity">

                    <!-- なぜ今参加すべきか -->
                    <section class="haiia-section haiia-why-now">
                        <h3 class="haiia-section-title">なぜ今、参加すべきか？</h3>

                        <div class="haiia-reason-grid">
                            <div class="haiia-reason-item">
                                <h4>1. 先行者利益</h4>
                                <p><strong>AI教育市場は、これから急拡大します。</strong></p>
                                <ul class="haiia-list">
                                    <li>2025年、政府は5年で1兆円のリスキリング支援を発表</li>
                                    <li>企業の教育投資額は2023年比で150%増予測</li>
                                    <li>今学べば、「AI活用の第一人者」として市場価値が高まる</li>
                                </ul>
                            </div>

                            <div class="haiia-reason-item">
                                <h4>2. 実績が積める</h4>
                                <p><strong>HAIIAでは、実プロジェクトに参加できます。</strong></p>
                                <ul class="haiia-list">
                                    <li>実在企業の課題を解決した実績は、ポートフォリオになる</li>
                                    <li>認定資格は、転職・昇進の武器になる</li>
                                    <li>協会の活動自体が、社会貢献として評価される</li>
                                </ul>
                            </div>

                            <div class="haiia-reason-item">
                                <h4>3. コミュニティの力</h4>
                                <p><strong>一人では続かない学びも、仲間がいれば続く。</strong></p>
                                <ul class="haiia-list">
                                    <li>同じ目標を持つ仲間との切磋琢磨</li>
                                    <li>先輩会員からのメンタリング</li>
                                    <li>困ったときに相談できる安心感</li>
                                </ul>
                            </div>
                        </div>
                    </section>

                    <hr class="wp-block-separator has-alpha-channel-opacity">

                    <!-- CTA -->
                    <section class="haiia-section haiia-cta">
                        <div class="haiia-cta-box">
                            <h3 class="haiia-cta-title">今すぐ始めましょう</h3>
                            <div class="haiia-cta-buttons">
                                <a href="<?php echo home_url('/member-register/'); ?>" class="haiia-btn haiia-btn-primary">会員登録する</a>
                                <a href="<?php echo home_url('/aitaskananalysis/'); ?>" class="haiia-btn haiia-btn-secondary">AI診断を試す</a>
                            </div>
                        </div>
                    </section>

                </div><!-- .entry-body -->
            </article>

            <?php do_action( 'lightning_main_section_append', 'lightning_main_section_append' ); ?>
        </div><!-- [ /.main-section ] -->

        <?php
        do_action( 'lightning_sub_section_before', 'lightning_sub_section_before' );
        if ( lightning_is_subsection() ) {
            lightning_get_template_part( 'sidebar', get_post_type() );
        }
        do_action( 'lightning_sub_section_after', 'lightning_sub_section_after' );
        ?>

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
