#!/usr/bin/env node
/**
 * XaaMe記事アップロード＆公開スクリプト
 */

const https = require('https');
const fs = require('fs');
const path = require('path');

const CONFIG = {
    username: 'yuho132@haiia.org',
    password: 'mFRu EJlY Wz5p goj8 ziDY jWuC'
};

const POST_ID = 1831;
const CATEGORY_ID = 46; // AI教育記事カテゴリ
const ARTICLE_FILE = 'xaame-ai-paradigm.html';

function processContent(content) {
    // 記事ファイル内の著者・関連記事セクションを削除（テンプレートで管理）
    let processed = content.replace(/<aside class="haiia-author-section">[\s\S]*?<\/aside>/g, '');
    processed = processed.replace(/<section class="haiia-related-section">[\s\S]*?<\/section>/g, '');
    processed = processed.trim();
    return processed;
}

function updatePost(postId, content, publish = false) {
    return new Promise((resolve, reject) => {
        const auth = Buffer.from(`${CONFIG.username}:${CONFIG.password}`).toString('base64');
        const postData = JSON.stringify({
            content: content,
            status: publish ? 'publish' : 'draft',
            categories: [CATEGORY_ID]
        });

        const options = {
            hostname: 'haiia.org',
            port: 443,
            path: `/wp-json/wp/v2/posts/${postId}`,
            method: 'POST',
            headers: {
                'Authorization': `Basic ${auth}`,
                'Content-Type': 'application/json',
                'Content-Length': Buffer.byteLength(postData)
            }
        };

        const req = https.request(options, (res) => {
            let body = '';
            res.on('data', chunk => body += chunk);
            res.on('end', () => {
                try {
                    const result = JSON.parse(body);
                    if (result.id === postId) {
                        resolve({
                            id: result.id,
                            title: result.title.rendered,
                            link: result.link,
                            status: result.status
                        });
                    } else {
                        reject(new Error(result.message || 'Failed'));
                    }
                } catch (e) {
                    reject(new Error(body.substring(0, 200)));
                }
            });
        });

        req.on('error', reject);
        req.write(postData);
        req.end();
    });
}

async function main() {
    const arg = process.argv[2];
    const publish = arg === 'publish';

    console.log('=== XaaMe記事アップロード ===\n');

    const filePath = path.join(__dirname, ARTICLE_FILE);

    if (!fs.existsSync(filePath)) {
        console.log(`✗ ファイルが見つかりません: ${ARTICLE_FILE}`);
        return;
    }

    try {
        const rawContent = fs.readFileSync(filePath, 'utf8');
        const content = processContent(rawContent);

        console.log(`📤 記事 ${POST_ID} をアップロード中...`);
        const result = await updatePost(POST_ID, content, publish);

        console.log(`✓ 記事を${publish ? '公開' : '更新'}しました`);
        console.log(`  ID: ${result.id}`);
        console.log(`  タイトル: ${result.title}`);
        console.log(`  ステータス: ${result.status}`);
        console.log(`  URL: ${result.link}`);

        if (!publish) {
            console.log('\n公開するには: node upload-xaame.js publish');
        }

    } catch (error) {
        console.log(`✗ エラー: ${error.message}`);
    }
}

main().catch(console.error);
