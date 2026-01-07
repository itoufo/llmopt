#!/usr/bin/env node
/**
 * 会員限定ページをWordPressに作成
 */

const https = require('https');
const fs = require('fs');
const path = require('path');

const CONFIG = {
    username: 'yuho132@haiia.org',
    password: 'mFRu EJlY Wz5p goj8 ziDY jWuC'
};

// HTMLコンテンツを読み込み
const htmlContent = fs.readFileSync(
    path.join(__dirname, 'members-only.html'),
    'utf8'
);

function createPage() {
    return new Promise((resolve, reject) => {
        const auth = Buffer.from(`${CONFIG.username}:${CONFIG.password}`).toString('base64');

        const postData = JSON.stringify({
            title: '会員限定',
            slug: 'members-only',
            content: htmlContent,
            status: 'publish',
            template: 'templates/template-members.php'
        });

        const options = {
            hostname: 'haiia.org',
            port: 443,
            path: '/wp-json/wp/v2/pages',
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
                        reject(new Error(result.message || JSON.stringify(result)));
                    }
                } catch (e) {
                    reject(new Error(body.substring(0, 500)));
                }
            });
        });

        req.on('error', reject);
        req.write(postData);
        req.end();
    });
}

async function main() {
    console.log('=== 会員限定ページ作成 ===\n');

    try {
        const page = await createPage();
        console.log('ページ作成成功!');
        console.log(`  ID: ${page.id}`);
        console.log(`  URL: ${page.link}`);
        console.log(`  テンプレート: templates/template-members.php`);
    } catch (error) {
        console.log(`エラー: ${error.message}`);
    }
}

main().catch(console.error);
