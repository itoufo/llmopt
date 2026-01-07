#!/usr/bin/env node
/**
 * XaaMe記事用日本語画像アップロードスクリプト
 */

const https = require('https');
const fs = require('fs');
const path = require('path');

const CONFIG = {
    username: 'yuho132@haiia.org',
    password: 'mFRu EJlY Wz5p goj8 ziDY jWuC'
};

const IMAGE_DIR = '/Users/yuho/nanobananaMCP/outputs/generated';
const POST_ID = 1831;

// 日本語版図と画像ファイルのマッピング
const IMAGES = [
    { file: 'nanobanana_generated_20260105_181509_2ed5f721.jpeg', title: 'xaame-fig1-waterfall-jp', alt: '図1：ウォーターフォール開発モデル' },
    { file: 'nanobanana_generated_20260105_181529_f7e5bb60.jpeg', title: 'xaame-fig2-agile-jp', alt: '図2：アジャイル開発モデル' },
    { file: 'nanobanana_generated_20260105_181549_b95bb612.jpeg', title: 'xaame-fig3-evolutionary-jp', alt: '図3：AI時代の開発モデル（Evolutionary Development）' },
    { file: 'nanobanana_generated_20260105_181610_e4a63b5b.jpeg', title: 'xaame-fig4-paradigm-shift-jp', alt: '図4：XaaS から XaaMe への主語の逆転' },
    { file: 'nanobanana_generated_20260105_181631_ada7b75b.jpeg', title: 'xaame-fig5-saas-saame-jp', alt: '図5：SaaS から SaaMe への構造変化' }
];

function uploadMedia(imagePath, title, altText) {
    return new Promise((resolve, reject) => {
        const auth = Buffer.from(`${CONFIG.username}:${CONFIG.password}`).toString('base64');
        const imageData = fs.readFileSync(imagePath);
        const filename = `haiia-${title}.jpeg`;

        const boundary = '----FormBoundary' + Math.random().toString(36).substring(2);

        let body = '';
        body += `--${boundary}\r\n`;
        body += `Content-Disposition: form-data; name="file"; filename="${filename}"\r\n`;
        body += `Content-Type: image/jpeg\r\n\r\n`;

        const bodyStart = Buffer.from(body, 'utf8');

        let altBody = `\r\n--${boundary}\r\n`;
        altBody += `Content-Disposition: form-data; name="alt_text"\r\n\r\n`;
        altBody += altText;

        const bodyEnd = Buffer.from(`${altBody}\r\n--${boundary}--\r\n`, 'utf8');
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
                        resolve({ id: result.id, url: result.source_url });
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
    console.log('=== XaaMe記事用日本語画像アップロード ===\n');
    const results = [];

    for (let i = 0; i < IMAGES.length; i++) {
        const img = IMAGES[i];
        const imagePath = path.join(IMAGE_DIR, img.file);

        if (!fs.existsSync(imagePath)) {
            console.log(`✗ ファイルが見つかりません: ${img.file}`);
            continue;
        }

        try {
            console.log(`📤 ${img.alt} をアップロード中...`);
            const result = await uploadMedia(imagePath, img.title, img.alt);
            console.log(`   Media ID: ${result.id}`);
            console.log(`   URL: ${result.url}`);
            results.push({ ...img, mediaId: result.id, url: result.url });

            // 図4をアイキャッチに設定
            if (i === 3) {
                const success = await setFeaturedImage(POST_ID, result.id);
                if (success) {
                    console.log(`✓ 投稿 ${POST_ID} にアイキャッチを設定`);
                }
            }

            await new Promise(r => setTimeout(r, 1000));
        } catch (error) {
            console.log(`✗ エラー: ${error.message}`);
        }
    }

    console.log('\n=== アップロード完了 ===');
    console.log('\n画像URL一覧:');
    results.forEach((r, i) => {
        console.log(`図${i + 1}: ${r.url}`);
    });

    // 記事HTML更新用にURLを出力
    console.log('\n記事更新用のURL置換:');
    results.forEach((r, i) => {
        console.log(`FIG${i + 1}_URL="${r.url}"`);
    });
}

main().catch(console.error);
