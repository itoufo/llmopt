#!/usr/bin/env node
/**
 * 画像アップロード＆アイキャッチ設定スクリプト
 */

const https = require('https');
const fs = require('fs');
const path = require('path');

const CONFIG = {
    username: 'yuho132@haiia.org',
    password: 'mFRu EJlY Wz5p goj8 ziDY jWuC'
};

const IMAGE_DIR = '/Users/yuho/nanobananaMCP/outputs/generated';

// 画像ファイル名と投稿IDのマッピング
const IMAGES = [
    { file: 'nanobanana_generated_20260105_053721_7a960b80.jpeg', postId: 1771, title: 'ChatGPTの始め方' },
    { file: 'nanobanana_generated_20260105_053738_ef03226f.jpeg', postId: 1772, title: 'プロンプトの書き方10選' },
    { file: 'nanobanana_generated_20260105_053755_9977eb9d.jpeg', postId: 1773, title: 'AIに聞いてはいけない質問' },
    { file: 'nanobanana_generated_20260105_053814_866c21b5.jpeg', postId: 1774, title: '子どものAI利用ルール' },
    { file: 'nanobanana_generated_20260105_053831_bef75995.jpeg', postId: 1775, title: '学校でAIをどう教えるか' },
    { file: 'nanobanana_generated_20260105_053847_39b32eb3.jpeg', postId: 1776, title: 'AI時代の読書感想文' },
    { file: 'nanobanana_generated_20260105_053905_e3b27432.jpeg', postId: 1777, title: '親子で学ぶAIリテラシー' },
    { file: 'nanobanana_generated_20260105_053937_5cf4bcc0.jpeg', postId: 1778, title: 'AI時代のコミュニケーション力' },
    { file: 'nanobanana_generated_20260105_053953_bfca95f8.jpeg', postId: 1779, title: '言語力を鍛える' },
    { file: 'nanobanana_generated_20260105_054010_8ee735f3.jpeg', postId: 1780, title: 'セルフコーチング入門' },
    { file: 'nanobanana_generated_20260105_054027_e2476c63.jpeg', postId: 1781, title: 'AIを活用したプロジェクト管理' },
    { file: 'nanobanana_generated_20260105_054044_f3d416eb.jpeg', postId: 1782, title: '生成AIの最新動向2025' },
    { file: 'nanobanana_generated_20260105_054104_79035ae4.jpeg', postId: 1783, title: 'AIと著作権' },
    { file: 'nanobanana_generated_20260105_054122_f21263f9.jpeg', postId: 1784, title: 'AIによる仕事の変化' }
];

function uploadMedia(imagePath, title) {
    return new Promise((resolve, reject) => {
        const auth = Buffer.from(`${CONFIG.username}:${CONFIG.password}`).toString('base64');
        const imageData = fs.readFileSync(imagePath);
        const filename = `haiia-${title.replace(/[^a-zA-Z0-9]/g, '-')}.jpeg`;

        const boundary = '----FormBoundary' + Math.random().toString(36).substring(2);

        let body = '';
        body += `--${boundary}\r\n`;
        body += `Content-Disposition: form-data; name="file"; filename="${filename}"\r\n`;
        body += `Content-Type: image/jpeg\r\n\r\n`;

        const bodyStart = Buffer.from(body, 'utf8');
        const bodyEnd = Buffer.from(`\r\n--${boundary}--\r\n`, 'utf8');
        const fullBody = Buffer.concat([bodyStart, imageData, bodyEnd]);

        const options = {
            hostname: 'haiia.org',
            port: 443,
            path: '/wp-json/wp/v2/media',
            method: 'POST',
            headers: {
                'Authorization': `Basic ${auth}`,
                'Content-Type': `multipart/form-data; boundary=${boundary}`,
                'Content-Length': fullBody.length
            }
        };

        const req = https.request(options, (res) => {
            let data = '';
            res.on('data', chunk => data += chunk);
            res.on('end', () => {
                try {
                    const result = JSON.parse(data);
                    if (result.id) {
                        resolve(result.id);
                    } else {
                        reject(new Error(result.message || 'Upload failed'));
                    }
                } catch (e) {
                    reject(new Error(data.substring(0, 200)));
                }
            });
        });

        req.on('error', reject);
        req.write(fullBody);
        req.end();
    });
}

function setFeaturedImage(postId, mediaId) {
    return new Promise((resolve, reject) => {
        const auth = Buffer.from(`${CONFIG.username}:${CONFIG.password}`).toString('base64');
        const postData = JSON.stringify({ featured_media: mediaId });

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
            let data = '';
            res.on('data', chunk => data += chunk);
            res.on('end', () => {
                try {
                    const result = JSON.parse(data);
                    resolve(result.featured_media === mediaId);
                } catch (e) {
                    reject(new Error(data));
                }
            });
        });

        req.on('error', reject);
        req.write(postData);
        req.end();
    });
}

async function main() {
    console.log('=== 画像アップロード開始 ===\n');

    for (const img of IMAGES) {
        const imagePath = path.join(IMAGE_DIR, img.file);

        if (!fs.existsSync(imagePath)) {
            console.log(`✗ ファイルが見つかりません: ${img.file}`);
            continue;
        }

        try {
            console.log(`📤 ${img.title} の画像をアップロード中...`);
            const mediaId = await uploadMedia(imagePath, img.title);
            console.log(`   Media ID: ${mediaId}`);

            const success = await setFeaturedImage(img.postId, mediaId);
            if (success) {
                console.log(`✓ 投稿 ${img.postId} にアイキャッチを設定`);
            } else {
                console.log(`✗ アイキャッチ設定に失敗`);
            }

            await new Promise(r => setTimeout(r, 1000));
        } catch (error) {
            console.log(`✗ エラー: ${error.message}`);
        }
    }

    console.log('\n=== 完了 ===');
}

main().catch(console.error);
