#!/usr/bin/env node
/**
 * セキュリティコンサルページを更新
 */

const https = require('https');
const fs = require('fs');
const path = require('path');

const CONFIG = {
    username: 'yuho132@haiia.org',
    password: 'mFRu EJlY Wz5p goj8 ziDY jWuC',
    pageId: 1848
};

function updatePage(pageId, content) {
    return new Promise((resolve, reject) => {
        const auth = Buffer.from(`${CONFIG.username}:${CONFIG.password}`).toString('base64');
        const postData = JSON.stringify({
            content: content
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
                        resolve({
                            id: result.id,
                            title: result.title.rendered,
                            link: result.link,
                            modified: result.modified
                        });
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
    console.log('=== セキュリティコンサルページ更新 ===\n');

    const htmlPath = path.join(__dirname, 'security-consulting.html');
    const content = fs.readFileSync(htmlPath, 'utf8');

    try {
        const result = await updatePage(CONFIG.pageId, content);

        console.log('✓ ページを更新しました');
        console.log(`  ID: ${result.id}`);
        console.log(`  タイトル: ${result.title}`);
        console.log(`  URL: ${result.link}`);
        console.log(`  更新日時: ${result.modified}`);

    } catch (error) {
        console.log(`✗ エラー: ${error.message}`);
    }
}

main().catch(console.error);
