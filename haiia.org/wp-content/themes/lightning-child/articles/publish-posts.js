#!/usr/bin/env node
/**
 * 記事を公開するスクリプト
 */

const https = require('https');

const CONFIG = {
    username: 'yuho132@haiia.org',
    password: 'mFRu EJlY Wz5p goj8 ziDY jWuC'
};

// 公開する記事ID（新規14記事）
const POST_IDS = [1771, 1772, 1773, 1774, 1775, 1776, 1777, 1778, 1779, 1780, 1781, 1782, 1783, 1784];

// AI教育記事カテゴリID
const CATEGORY_ID = 46;

function updatePost(postId) {
    return new Promise((resolve, reject) => {
        const auth = Buffer.from(`${CONFIG.username}:${CONFIG.password}`).toString('base64');
        const postData = JSON.stringify({
            status: 'publish',
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
                    if (result.id && result.status === 'publish') {
                        resolve({ id: result.id, title: result.title.rendered, link: result.link });
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
    console.log('=== 記事を公開 ===\n');

    for (const postId of POST_IDS) {
        try {
            const result = await updatePost(postId);
            console.log(`✓ ${result.id}: ${result.title}`);
            await new Promise(r => setTimeout(r, 500));
        } catch (error) {
            console.log(`✗ ${postId}: ${error.message}`);
        }
    }

    console.log('\n=== 完了 ===');
}

main().catch(console.error);
