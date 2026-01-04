<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );

// END ENQUEUE PARENT ACTION

/**
 * TOPページテンプレート用CSSを読み込み
 */
add_action( 'wp_enqueue_scripts', 'haiia_enqueue_home_styles' );
function haiia_enqueue_home_styles() {
    // TOPページテンプレートが使用されている場合、またはフロントページの場合にCSSを読み込む
    if ( is_page_template( 'templates/template-home.php' ) || is_front_page() ) {
        wp_enqueue_style(
            'haiia-home-style',
            get_stylesheet_directory_uri() . '/assets/css/home.css',
            array(),
            filemtime( get_stylesheet_directory() . '/assets/css/home.css' )
        );
    }
}

/**
 * 協会についてページテンプレート用CSSを読み込み
 */
add_action( 'wp_enqueue_scripts', 'haiia_enqueue_about_styles' );
function haiia_enqueue_about_styles() {
    if ( is_page_template( 'templates/template-about.php' ) ) {
        wp_enqueue_style(
            'haiia-about-style',
            get_stylesheet_directory_uri() . '/assets/css/about.css',
            array(),
            filemtime( get_stylesheet_directory() . '/assets/css/about.css' )
        );
    }
}

/**
 * 協会活動ページテンプレート用CSSを読み込み
 */
add_action( 'wp_enqueue_scripts', 'haiia_enqueue_activities_styles' );
function haiia_enqueue_activities_styles() {
    if ( is_page_template( 'templates/template-activities.php' ) ) {
        wp_enqueue_style(
            'haiia-activities-style',
            get_stylesheet_directory_uri() . '/assets/css/activities.css',
            array(),
            filemtime( get_stylesheet_directory() . '/assets/css/activities.css' )
        );
    }
}

/**
 * 教育・研修プログラムページテンプレート用CSSを読み込み
 */
add_action( 'wp_enqueue_scripts', 'haiia_enqueue_programs_styles' );
function haiia_enqueue_programs_styles() {
    if ( is_page_template( 'templates/template-programs.php' ) ) {
        wp_enqueue_style(
            'haiia-programs-style',
            get_stylesheet_directory_uri() . '/assets/css/programs.css',
            array(),
            filemtime( get_stylesheet_directory() . '/assets/css/programs.css' )
        );
    }
}

// ログアウト後にTOPページへリダイレクト
add_action( 'wp_logout', function() {
    wp_safe_redirect( home_url('/') );
    exit;
});

/**
 * 調査レポートカテゴリの投稿に専用テンプレートを適用
 * カテゴリスラッグ: research-report
 */
add_filter( 'single_template', 'haiia_research_report_template' );
function haiia_research_report_template( $template ) {
    if ( is_single() && has_category( 'research-report' ) ) {
        $custom_template = get_stylesheet_directory() . '/single-research-report.php';
        if ( file_exists( $custom_template ) ) {
            return $custom_template;
        }
    }
    return $template;
}

/**
 * research-reportカテゴリページを固定ページにリダイレクト
 */
add_action( 'template_redirect', 'haiia_redirect_research_report_category' );
function haiia_redirect_research_report_category() {
    if ( is_category( 'research-report' ) ) {
        // 固定ページのスラッグを指定
        $page = get_page_by_path( 'report' );
        if ( $page ) {
            wp_redirect( get_permalink( $page->ID ), 301 );
            exit;
        }
    }
}

/**
 * PMPro チェックアウトフォームのカスタマイズ
 */

// 日本式住所入力に最適化（姓名を先頭に、郵便番号→都道府県→市区町村→町域）
add_action( 'wp_head', 'haiia_pmpro_japanese_address_style' );
function haiia_pmpro_japanese_address_style() {
    if ( ! function_exists( 'pmpro_is_checkout' ) || ! pmpro_is_checkout() ) {
        return;
    }
    ?>
    <style>
    /* 日本式住所入力のフィールド順序（CSS order） */
    #pmpro_billing_address_fields .pmpro_form_fields.pmpro_cols-2 {
        display: flex;
        flex-wrap: wrap;
    }
    /* 順序: 姓(1) → 名(2) → 郵便番号(3) → 都道府県(4) → 市区町村(5) → 町域(6) → 建物名(7) → 国(8) → 電話(9) */
    #pmpro_billing_address_fields .pmpro_form_field-blastname { order: 1; }
    #pmpro_billing_address_fields .pmpro_form_field-bfirstname { order: 2; }
    #pmpro_billing_address_fields .pmpro_form_field-bzipcode { order: 3; }
    #pmpro_billing_address_fields .pmpro_form_field-bstate { order: 4; }
    #pmpro_billing_address_fields .pmpro_form_field-bcity { order: 5; }
    #pmpro_billing_address_fields .pmpro_form_field-baddress1 { order: 6; }
    #pmpro_billing_address_fields .pmpro_form_field-baddress2 { order: 7; }
    #pmpro_billing_address_fields .pmpro_form_field-bcountry { order: 8; }
    #pmpro_billing_address_fields .pmpro_form_field-bphone { order: 9; }
    #pmpro_billing_address_fields .pmpro_form_field-bemail { order: 10; }
    #pmpro_billing_address_fields .pmpro_form_field-bconfirmemail { order: 11; }

    /* 法人名フィールドのスタイル */
    #pmpro_company_name_fields {
        margin-bottom: 20px;
    }
    #pmpro_company_name_fields .pmpro_form_field {
        width: 100%;
    }
    </style>
    <?php
}

// 国を日本に固定（選択欄を非表示）
add_filter( 'pmpro_default_country', function() { return 'JP'; } );
add_filter( 'pmpro_international_addresses', '__return_false' );

// フィールドラベルを日本語に変更
add_filter( 'gettext', 'haiia_pmpro_translate_labels', 10, 3 );
function haiia_pmpro_translate_labels( $translated_text, $text, $domain ) {
    if ( $domain === 'paid-memberships-pro' ) {
        switch ( $text ) {
            case 'First Name':
                $translated_text = '名';
                break;
            case 'Last Name':
                $translated_text = '姓';
                break;
            case 'Address 1':
                $translated_text = '町域・番地';
                break;
            case 'Address 2':
                $translated_text = '建物名等';
                break;
            case 'City':
                $translated_text = '市区町村';
                break;
            case 'State':
                $translated_text = '都道府県';
                break;
            case 'Postal Code':
                $translated_text = '郵便番号';
                break;
        }
    }
    return $translated_text;
}

// 法人名フィールドをチェックアウトフォームに追加
add_action( 'pmpro_checkout_boxes', 'haiia_pmpro_add_company_name_field' );
function haiia_pmpro_add_company_name_field() {
    global $current_user;

    // 既存の法人名を取得
    $company_name = '';
    if ( is_user_logged_in() ) {
        $company_name = get_user_meta( $current_user->ID, 'pmpro_company_name', true );
    }
    if ( isset( $_REQUEST['company_name'] ) ) {
        $company_name = sanitize_text_field( $_REQUEST['company_name'] );
    }
    ?>
    <fieldset id="pmpro_company_name_fields" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_fieldset', 'pmpro_company_name_fields' ) ); ?>">
        <div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_card' ) ); ?>">
            <div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_card_content' ) ); ?>">
                <legend class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_legend' ) ); ?>">
                    <h2 class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_heading pmpro_font-large' ) ); ?>">法人情報</h2>
                </legend>
                <div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_fields' ) ); ?>">
                    <div class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_field pmpro_form_field-text pmpro_form_field-company_name', 'pmpro_form_field-company_name' ) ); ?>">
                        <label for="company_name" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_label' ) ); ?>">法人名</label>
                        <input id="company_name" name="company_name" type="text" class="<?php echo esc_attr( pmpro_get_element_class( 'pmpro_form_input pmpro_form_input-text', 'company_name' ) ); ?>" value="<?php echo esc_attr( $company_name ); ?>" />
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    <?php
}

// 法人名フィールドの値を保存
add_action( 'pmpro_after_checkout', 'haiia_pmpro_save_company_name', 10, 2 );
function haiia_pmpro_save_company_name( $user_id, $morder ) {
    if ( isset( $_REQUEST['company_name'] ) ) {
        $company_name = sanitize_text_field( $_REQUEST['company_name'] );
        update_user_meta( $user_id, 'pmpro_company_name', $company_name );
    }
}

// ユーザー登録時にも法人名を保存
add_action( 'user_register', 'haiia_pmpro_save_company_name_on_register' );
function haiia_pmpro_save_company_name_on_register( $user_id ) {
    if ( isset( $_REQUEST['company_name'] ) ) {
        $company_name = sanitize_text_field( $_REQUEST['company_name'] );
        update_user_meta( $user_id, 'pmpro_company_name', $company_name );
    }
}

// 管理画面のユーザープロフィールに法人名フィールドを表示
add_action( 'show_user_profile', 'haiia_pmpro_show_company_name_field' );
add_action( 'edit_user_profile', 'haiia_pmpro_show_company_name_field' );
function haiia_pmpro_show_company_name_field( $user ) {
    ?>
    <h3>法人情報</h3>
    <table class="form-table">
        <tr>
            <th><label for="pmpro_company_name">法人名</label></th>
            <td>
                <input type="text" name="pmpro_company_name" id="pmpro_company_name" value="<?php echo esc_attr( get_user_meta( $user->ID, 'pmpro_company_name', true ) ); ?>" class="regular-text" />
            </td>
        </tr>
    </table>
    <?php
}

// 管理画面でユーザープロフィールの法人名を保存
add_action( 'personal_options_update', 'haiia_pmpro_save_company_name_field' );
add_action( 'edit_user_profile_update', 'haiia_pmpro_save_company_name_field' );
function haiia_pmpro_save_company_name_field( $user_id ) {
    if ( ! current_user_can( 'edit_user', $user_id ) ) {
        return false;
    }
    if ( isset( $_POST['pmpro_company_name'] ) ) {
        update_user_meta( $user_id, 'pmpro_company_name', sanitize_text_field( $_POST['pmpro_company_name'] ) );
    }
}

/**
 * 法人賛助会員ページテンプレート用CSSを読み込み
 */
add_action( 'wp_enqueue_scripts', 'haiia_enqueue_sponsors_styles' );
function haiia_enqueue_sponsors_styles() {
    if ( is_page_template( 'templates/template-sponsors.php' ) ) {
        wp_enqueue_style(
            'haiia-sponsors-style',
            get_stylesheet_directory_uri() . '/assets/css/sponsors.css',
            array(),
            filemtime( get_stylesheet_directory() . '/assets/css/sponsors.css' )
        );
    }
}

/**
 * 法人賛助会員ページ用 ACF フィールドグループ
 * ギャラリーフィールドを使用して不特定多数のロゴを管理
 * - 画像タイトル: 企業名
 * - 画像キャプション: リンク先URL
 */
add_action( 'acf/init', 'haiia_register_sponsors_fields' );
function haiia_register_sponsors_fields() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    acf_add_local_field_group( array(
        'key' => 'group_sponsors_page',
        'title' => '法人賛助会員設定',
        'fields' => array(
            // ページサブタイトル
            array(
                'key' => 'field_sponsors_subtitle',
                'label' => 'ページサブタイトル',
                'name' => 'sponsors_subtitle',
                'type' => 'text',
                'instructions' => '英語サブタイトル（デフォルト: Corporate Sponsors）',
                'required' => 0,
                'placeholder' => 'Corporate Sponsors',
            ),
            // イントロダクション
            array(
                'key' => 'field_sponsors_introduction',
                'label' => 'イントロダクション',
                'name' => 'sponsors_introduction',
                'type' => 'wysiwyg',
                'instructions' => 'ページ上部に表示される紹介文',
                'required' => 0,
                'tabs' => 'all',
                'toolbar' => 'basic',
                'media_upload' => 0,
            ),
            // プラチナスポンサー
            array(
                'key' => 'field_sponsors_platinum',
                'label' => 'プラチナスポンサー',
                'name' => 'sponsors_platinum',
                'type' => 'gallery',
                'instructions' => 'プラチナスポンサーのロゴ画像を追加してください。<br><strong>画像タイトル</strong>: 企業名、<strong>キャプション</strong>: リンク先URL',
                'required' => 0,
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
                'min' => 0,
                'max' => '',
            ),
            // ゴールドスポンサー
            array(
                'key' => 'field_sponsors_gold',
                'label' => 'ゴールドスポンサー',
                'name' => 'sponsors_gold',
                'type' => 'gallery',
                'instructions' => 'ゴールドスポンサーのロゴ画像を追加してください。<br><strong>画像タイトル</strong>: 企業名、<strong>キャプション</strong>: リンク先URL',
                'required' => 0,
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
                'min' => 0,
                'max' => '',
            ),
            // シルバースポンサー
            array(
                'key' => 'field_sponsors_silver',
                'label' => 'シルバースポンサー',
                'name' => 'sponsors_silver',
                'type' => 'gallery',
                'instructions' => 'シルバースポンサーのロゴ画像を追加してください。<br><strong>画像タイトル</strong>: 企業名、<strong>キャプション</strong>: リンク先URL',
                'required' => 0,
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
                'min' => 0,
                'max' => '',
            ),
            // ブロンズスポンサー
            array(
                'key' => 'field_sponsors_bronze',
                'label' => 'ブロンズスポンサー',
                'name' => 'sponsors_bronze',
                'type' => 'gallery',
                'instructions' => 'ブロンズスポンサーのロゴ画像を追加してください。<br><strong>画像タイトル</strong>: 企業名、<strong>キャプション</strong>: リンク先URL',
                'required' => 0,
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
                'min' => 0,
                'max' => '',
            ),
            // 一般法人賛助会員
            array(
                'key' => 'field_sponsors_general',
                'label' => '法人賛助会員',
                'name' => 'sponsors_general',
                'type' => 'gallery',
                'instructions' => '一般法人賛助会員のロゴ画像を追加してください。<br><strong>画像タイトル</strong>: 企業名、<strong>キャプション</strong>: リンク先URL',
                'required' => 0,
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
                'library' => 'all',
                'min' => 0,
                'max' => '',
            ),
            // CTA設定
            array(
                'key' => 'field_sponsors_cta_text',
                'label' => 'CTA テキスト',
                'name' => 'sponsors_cta_text',
                'type' => 'textarea',
                'instructions' => '賛助会員募集の説明文（HTMLタグ使用可）',
                'required' => 0,
                'rows' => 3,
            ),
            array(
                'key' => 'field_sponsors_cta_button',
                'label' => 'CTA ボタンテキスト',
                'name' => 'sponsors_cta_button',
                'type' => 'text',
                'instructions' => 'ボタンに表示するテキスト（デフォルト: 賛助会員のご案内）',
                'required' => 0,
                'placeholder' => '賛助会員のご案内',
            ),
            array(
                'key' => 'field_sponsors_cta_url',
                'label' => 'CTA リンク先URL',
                'name' => 'sponsors_cta_url',
                'type' => 'url',
                'instructions' => 'ボタンのリンク先URL',
                'required' => 0,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'templates/template-sponsors.php',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ) );
}

/**
 * 調査レポート用 ACF フィールドグループ
 */
add_action( 'acf/init', 'haiia_register_research_report_fields' );
function haiia_register_research_report_fields() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    acf_add_local_field_group( array(
        'key' => 'group_research_report',
        'title' => '調査レポート設定',
        'fields' => array(
            // 執筆者名
            array(
                'key' => 'field_report_author',
                'label' => '執筆者名',
                'name' => 'report_author',
                'type' => 'text',
                'instructions' => 'レポートの執筆者名を入力してください',
                'required' => 0,
                'placeholder' => '例：山田太郎',
            ),
            // はじめに
            array(
                'key' => 'field_report_introduction',
                'label' => 'はじめに',
                'name' => 'report_introduction',
                'type' => 'wysiwyg',
                'instructions' => 'レポートの導入文を入力してください',
                'required' => 0,
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 0,
            ),
            // まとめ
            array(
                'key' => 'field_report_summary',
                'label' => 'まとめ',
                'name' => 'report_summary',
                'type' => 'wysiwyg',
                'instructions' => 'レポートのまとめを入力してください',
                'required' => 0,
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 0,
            ),
            // 参考資料（無料版対応：テキストエリア形式）
            array(
                'key' => 'field_report_references',
                'label' => '参考資料',
                'name' => 'report_references',
                'type' => 'textarea',
                'instructions' => '1行に1つずつ「タイトル|URL」の形式で入力してください。URLのみでもOKです。<br>例：<br>文部科学省ガイドライン|https://example.com/guide<br>https://example.com/report',
                'required' => 0,
                'rows' => 6,
                'new_lines' => '',
            ),
            // 執筆者レビュー - 考察・所感
            array(
                'key' => 'field_report_author_review',
                'label' => '執筆者レビュー（考察・所感）',
                'name' => 'report_author_review',
                'type' => 'wysiwyg',
                'instructions' => '執筆者の考察・所感を入力してください',
                'required' => 0,
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 0,
            ),
            // HAIIAとしての見解・提言
            array(
                'key' => 'field_report_haiia_opinion',
                'label' => 'HAIIAとしての見解・提言',
                'name' => 'report_haiia_opinion',
                'type' => 'wysiwyg',
                'instructions' => 'HAIIAとしての見解・提言を入力してください',
                'required' => 0,
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 0,
            ),
            // 使用AI情報
            array(
                'key' => 'field_report_ai_info',
                'label' => '使用AI情報',
                'name' => 'report_ai_info',
                'type' => 'text',
                'instructions' => '使用したAIの名前・バージョンを入力してください',
                'required' => 0,
                'placeholder' => '例：ChatGPT-4o',
            ),
            // 関連資料（ダウンロード用ファイル）
            array(
                'key' => 'field_report_attachments',
                'label' => '関連資料（ダウンロード）',
                'name' => 'report_attachments',
                'type' => 'textarea',
                'instructions' => '1行に1つずつ「タイトル|ファイルURL」の形式で入力してください。<br>メディアライブラリにアップロード後、URLをコピーして貼り付けてください。<br>例：<br>調査レポートPDF|https://example.com/report.pdf',
                'required' => 0,
                'rows' => 4,
                'new_lines' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'post',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ) );
}
