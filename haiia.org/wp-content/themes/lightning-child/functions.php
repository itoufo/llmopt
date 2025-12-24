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
