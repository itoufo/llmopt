#!/bin/bash
# HAIIA記事アップロードスクリプト
# 使い方: ./upload.sh [記事ID] または ./upload.sh all

SCRIPT_DIR="$(cd "$(dirname "$0")" && pwd)"
USERNAME="yuho132@haiia.org"
PASSWORD="mFRu EJlY Wz5p goj8 ziDY jWuC"
POSTS_API="https://haiia.org/wp-json/wp/v2/posts"

# 著者セクションを読み込む
AUTHOR_SECTION=$(cat "$SCRIPT_DIR/_author-section.html")

# 記事マッピング
declare -a ARTICLES=(
    "1721:1721-inclusive-ai-education.html"
    "1722:1722-ai-communication-skills.html"
    "1723:1723-paic-cycle-guide.html"
    "1724:1724-ai-ethics-5-principles.html"
    "1725:1725-singularity-2045-education.html"
)

upload_article() {
    local POST_ID="$1"
    local FILENAME="$2"
    local FILEPATH="$SCRIPT_DIR/$FILENAME"

    if [ ! -f "$FILEPATH" ]; then
        echo "✗ ファイルが見つかりません: $FILEPATH"
        return 1
    fi

    echo "📤 記事 $POST_ID をアップロード中..."

    # ファイル内容を読み込み（著者セクションは _author-section.html から）
    # 記事ファイル内の著者セクションを新しいものに置換
    CONTENT=$(cat "$FILEPATH")

    # 古い著者セクションを削除（<!-- 執筆・監修情報 -->から</aside>まで）
    CONTENT=$(echo "$CONTENT" | sed '/<aside class="haiia-author-section">/,/<\/aside>/d')

    # 新しい著者セクションを追加
    CONTENT="${CONTENT}
${AUTHOR_SECTION}"

    # JSONペイロードを作成
    JSON_PAYLOAD=$(jq -n --arg content "$CONTENT" '{"content": $content}')

    # アップロード
    RESULT=$(curl -s -X POST "$POSTS_API/$POST_ID" \
        --user "$USERNAME:$PASSWORD" \
        -H "Content-Type: application/json" \
        -d "$JSON_PAYLOAD")

    UPDATED_ID=$(echo "$RESULT" | jq -r '.id')
    if [ "$UPDATED_ID" == "$POST_ID" ]; then
        echo "✓ 記事 $POST_ID を更新しました"
        return 0
    else
        echo "✗ 記事 $POST_ID の更新に失敗"
        echo "$RESULT" | jq -r '.message // .' | head -3
        return 1
    fi
}

# メイン処理
if [ "$1" == "all" ]; then
    echo "=== 全記事をアップロード ==="
    for ARTICLE in "${ARTICLES[@]}"; do
        IFS=':' read -r ID FILE <<< "$ARTICLE"
        upload_article "$ID" "$FILE"
        sleep 1
    done
    echo ""
    echo "=== 完了 ==="
elif [ -n "$1" ]; then
    # 特定の記事IDを指定
    for ARTICLE in "${ARTICLES[@]}"; do
        IFS=':' read -r ID FILE <<< "$ARTICLE"
        if [ "$ID" == "$1" ]; then
            upload_article "$ID" "$FILE"
            exit $?
        fi
    done
    echo "✗ 記事ID $1 が見つかりません"
    exit 1
else
    echo "使い方:"
    echo "  ./upload.sh all      - 全記事をアップロード"
    echo "  ./upload.sh [記事ID] - 特定の記事をアップロード"
    echo ""
    echo "利用可能な記事:"
    for ARTICLE in "${ARTICLES[@]}"; do
        IFS=':' read -r ID FILE <<< "$ARTICLE"
        echo "  $ID: $FILE"
    done
fi
