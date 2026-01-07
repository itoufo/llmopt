#!/usr/bin/env node
/**
 * セキュリティコンサルページを固定ページとして作成
 */

const https = require('https');
const fs = require('fs');
const path = require('path');

const CONFIG = {
    username: 'yuho132@haiia.org',
    password: 'mFRu EJlY Wz5p goj8 ziDY jWuC'
};

function createPage(title, slug, content, status = 'publish') {
    return new Promise((resolve, reject) => {
        const auth = Buffer.from(`${CONFIG.username}:${CONFIG.password}`).toString('base64');
        const postData = JSON.stringify({
            title: title,
            slug: slug,
            content: content,
            status: status,
            type: 'page'
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
    console.log('=== セキュリティコンサルページ作成 ===\n');

    const htmlPath = path.join(__dirname, 'security-consulting.html');
    const content = fs.readFileSync(htmlPath, 'utf8');

    try {
        const result = await createPage(
            'AIセキュリティコンサルティング',
            'security-consulting',
            content,
            'publish'
        );

        console.log('✓ ページを作成・公開しました');
        console.log(`  ID: ${result.id}`);
        console.log(`  タイトル: ${result.title}`);
        console.log(`  URL: ${result.link}`);

    } catch (error) {
        console.log(`✗ エラー: ${error.message}`);
    }
}

main().catch(console.error);
