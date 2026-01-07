#!/usr/bin/env node
/**
 * XaaMe記事を新規作成するスクリプト
 */

const https = require('https');

const CONFIG = {
    username: 'yuho132@haiia.org',
    password: 'mFRu EJlY Wz5p goj8 ziDY jWuC',
    postsApi: '/wp-json/wp/v2/posts'
};

function createPost() {
    return new Promise((resolve, reject) => {
        const auth = Buffer.from(`${CONFIG.username}:${CONFIG.password}`).toString('base64');
        const postData = JSON.stringify({
            title: 'XaaMe：AI時代の新パラダイム — X as a Me — サービスから「私」への主語の逆転',
            slug: 'xaame-ai-paradigm',
            status: 'draft',
            categories: [156], // haiia-article category
            content: '<p>準備中</p>'
        });

        const options = {
            hostname: 'haiia.org',
            port: 443,
            path: CONFIG.postsApi,
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
                        console.log(`✓ 記事を作成しました`);
                        console.log(`  ID: ${result.id}`);
                        console.log(`  タイトル: ${result.title.rendered}`);
                        console.log(`  スラッグ: ${result.slug}`);
                        console.log(`  編集URL: ${result.link}`);
                        resolve(result);
                    } else {
                        reject(new Error(result.message || 'Unknown error'));
                    }
                } catch (e) {
                    reject(new Error(body));
                }
            });
        });

        req.on('error', reject);
        req.write(postData);
        req.end();
    });
}

createPost().catch(console.error);
