#!/usr/bin/env node
/**
 * 画像をWordPressにアップロードしてアイキャッチに設定
 */

const https = require('https');
const fs = require('fs');
const path = require('path');

const CONFIG = {
    username: 'yuho132@haiia.org',
    password: 'mFRu EJlY Wz5p goj8 ziDY jWuC',
    pageId: 1848
};

function uploadMedia(imagePath) {
    return new Promise((resolve, reject) => {
        const auth = Buffer.from(`${CONFIG.username}:${CONFIG.password}`).toString('base64');
        const imageBuffer = fs.readFileSync(imagePath);
        const filename = path.basename(imagePath);

        const boundary = '----WebKitFormBoundary' + Math.random().toString(36).substring(2);

        let body = '';
        body += `--${boundary}\r\n`;
        body += `Content-Disposition: form-data; name="file"; filename="${filename}"\r\n`;
        body += `Content-Type: image/jpeg\r\n\r\n`;

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
                    if (result.id) {
                        resolve(result);
                    } else {
                        reject(new Error(result.message || 'Upload failed'));
                    }
                } catch (e) {
                    reject(new Error(data.substring(0, 500)));
                }
            });
        });

        req.on('error', reject);
        req.write(fullBody);
        req.end();
    });
}

function setFeaturedImage(pageId, mediaId) {
    return new Promise((resolve, reject) => {
        const auth = Buffer.from(`${CONFIG.username}:${CONFIG.password}`).toString('base64');
        const postData = JSON.stringify({
            featured_media: mediaId
        });

        const options = {
            hostname: 'haiia.org',
            port: 443,
            path: `/wp-json/wp/v2/pages/${pageId}`,
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
                    if (result.id) {
                        resolve(result);
                    } else {
                        reject(new Error(result.message || 'Failed'));
                    }
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
    const imagePath = process.argv[2];

    if (!imagePath) {
        console.log('Usage: node upload-featured-image.js <image-path>');
        process.exit(1);
    }

    console.log('=== アイキャッチ画像設定 ===\n');

    try {
        console.log('1. 画像をアップロード中...');
        const media = await uploadMedia(imagePath);
        console.log(`   Media ID: ${media.id}`);
        console.log(`   URL: ${media.source_url}`);

        console.log('\n2. アイキャッチに設定中...');
        const page = await setFeaturedImage(CONFIG.pageId, media.id);
        console.log(`   ページ: ${page.title.rendered}`);
        console.log(`   URL: ${page.link}`);

        console.log('\n完了しました');

    } catch (error) {
        console.log(`エラー: ${error.message}`);
    }
}

main().catch(console.error);
