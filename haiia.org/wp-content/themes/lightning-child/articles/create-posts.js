#!/usr/bin/env node
/**
 * WordPress新規記事作成スクリプト
 */

const https = require('https');

const CONFIG = {
    username: 'yuho132@haiia.org',
    password: 'mFRu EJlY Wz5p goj8 ziDY jWuC',
    postsApi: '/wp-json/wp/v2/posts'
};

const NEW_ARTICLES = [
    { slug: 'chatgpt-beginners-guide', title: 'ChatGPTの始め方：初心者向け完全ガイド', category: 'AI活用' },
    { slug: 'prompt-writing-tips', title: 'プロンプトの書き方10選', category: 'AI活用' },
    { slug: 'ai-questions-to-avoid', title: 'AIに聞いてはいけない質問とは', category: 'AI倫理' },
    { slug: 'kids-ai-usage-rules', title: '子どものAI利用ルールの作り方', category: '家庭教育' },
    { slug: 'ai-education-in-schools', title: '学校でAIをどう教えるか', category: '学校教育' },
    { slug: 'ai-and-school-essays', title: 'AI時代の読書感想文・作文指導', category: '学校教育' },
    { slug: 'parent-child-ai-literacy', title: '親子で学ぶAIリテラシー', category: '家庭教育' },
    { slug: 'ai-communication-skills-guide', title: 'AI時代のコミュニケーション力とは', category: '4つの力' },
    { slug: 'language-skills-ai-era', title: '言語力を鍛える：AIに負けない表現力', category: '4つの力' },
    { slug: 'self-coaching-introduction', title: 'セルフコーチング入門', category: '4つの力' },
    { slug: 'ai-project-management', title: 'AIを活用したプロジェクト管理', category: '4つの力' },
    { slug: 'generative-ai-trends-2025', title: '生成AIの最新動向2025', category: 'AIトレンド' },
    { slug: 'ai-and-copyright', title: 'AIと著作権：知っておくべき基礎知識', category: 'AI倫理' },
    { slug: 'ai-job-changes', title: 'AIによる仕事の変化：消える職業・生まれる職業', category: 'AIトレンド' }
];

function createPost(article) {
    return new Promise((resolve, reject) => {
        const auth = Buffer.from(`${CONFIG.username}:${CONFIG.password}`).toString('base64');
        const postData = JSON.stringify({
            title: article.title,
            slug: article.slug,
            status: 'draft',
            categories: [156], // haiia-article category ID
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
                        resolve({ id: result.id, title: article.title, slug: article.slug });
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

async function main() {
    console.log('=== 新規記事を作成 ===\n');
    const results = [];

    for (const article of NEW_ARTICLES) {
        try {
            const result = await createPost(article);
            console.log(`✓ ID ${result.id}: ${result.title}`);
            results.push(result);
            await new Promise(r => setTimeout(r, 500));
        } catch (error) {
            console.log(`✗ ${article.title}: ${error.message}`);
        }
    }

    console.log('\n=== 作成完了 ===');
    console.log('upload.js用の配列:');
    console.log(JSON.stringify(results.map(r => ({
        id: r.id,
        file: `${r.id}-${r.slug}.html`,
        title: r.title
    })), null, 4));
}

main().catch(console.error);
