#!/usr/bin/env node
/**
 * 調査レポートのアイキャッチ画像を一括設定
 */

const https = require('https');
const fs = require('fs');
const path = require('path');

const CONFIG = {
    username: 'yuho132@haiia.org',
    password: 'mFRu EJlY Wz5p goj8 ziDY jWuC'
};

const REPORTS = [
    { postId: 1693, title: 'AI活用による理解度・定着率・創造性への影響', image: '/Users/yuho/nanobananaMCP/outputs/generated/nanobanana_generated_20260106_143357_3223b111.jpeg' },
    { postId: 1688, title: '健全AI教育と台湾におけるPlurality', image: '/Users/yuho/nanobananaMCP/outputs/generated/nanobanana_generated_20260106_143416_9811a44e.jpeg' },
    { postId: 1685, title: 'Xに画像のAI加工機能が実装されたことへの懸念点', image: '/Users/yuho/nanobananaMCP/outputs/generated/nanobanana_generated_20260106_143433_f6a037b7.jpeg' },
    { postId: 1652, title: '日本のAIガバナンス動向と国際枠組みの比較', image: '/Users/yuho/nanobananaMCP/outputs/generated/nanobanana_generated_20260106_143450_f811ff41.jpeg' }
];

function uploadMedia(imagePath) {
    return new Promise((resolve, reject) => {
        const auth = Buffer.from(`${CONFIG.username}:${CONFIG.password}`).toString('base64');
        const imageBuffer = fs.readFileSync(imagePath);
        const filename = path.basename(imagePath);
        const boundary = '----WebKitFormBoundary' + Math.random().toString(36).substring(2);

        let body = `--${boundary}\r\nContent-Disposition: form-data; name="file"; filename="${filename}"\r\nContent-Type: image/jpeg\r\n\r\n`;
        const bodyStart = Buffer.from(body, 'utf8');
        const bodyEnd = Buffer.from(`\r\n--${boundary}--\r\n`, 'utf8');
        const fullBody = Buffer.concat([bodyStart, imageBuffer, bodyEnd]);

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
                    if (result.id) resolve(result);
                    else reject(new Error(result.message || 'Upload failed'));
                } catch (e) {
                    reject(new Error(data.substring(0, 300)));
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
            let body = '';
            res.on('data', chunk => body += chunk);
            res.on('end', () => {
                try {
                    const result = JSON.parse(body);
                    if (result.id) resolve(result);
                    else reject(new Error(result.message || 'Failed'));
                } catch (e) {
                    reject(new Error(body.substring(0, 300)));
                }
            });
        });
        req.on('error', reject);
        req.write(postData);
        req.end();
    });
}

async function main() {
    console.log('=== 調査レポート アイキャッチ一括設定 ===\n');

    for (const report of REPORTS) {
        try {
            console.log(`処理中: ${report.title}`);

            const media = await uploadMedia(report.image);
            console.log(`  画像アップロード完了 (Media ID: ${media.id})`);

            await setFeaturedImage(report.postId, media.id);
            console.log(`  アイキャッチ設定完了\n`);

        } catch (error) {
            console.log(`  エラー: ${error.message}\n`);
        }
    }

    console.log('完了しました');
}

main().catch(console.error);
