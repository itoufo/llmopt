<?php
/**
 * フロントページテンプレート
 *
 * WordPressがフロントページとして自動的に使用するテンプレート
 * 設定 > 表示設定 で「固定ページ」を選択した場合、
 * その固定ページに対してこのテンプレートが自動的に適用されます。
 *
 * @package Lightning Child
 */

// TOPページテンプレートを読み込む
include( get_stylesheet_directory() . '/templates/template-home.php' );
