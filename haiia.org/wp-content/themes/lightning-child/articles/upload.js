#!/usr/bin/env node
/**
 * HAIIA記事アップロードスクリプト
 * 使い方: node upload.js [all|記事ID]
 */

const https = require('https');
const fs = require('fs');
const path = require('path');

const CONFIG = {
    username: 'yuho132@haiia.org',
    password: 'mFRu EJlY Wz5p goj8 ziDY jWuC',
    postsApi: '/wp-json/wp/v2/posts'
};

const ARTICLES = [
    // 既存記事
    { id: 1721, file: '1721-inclusive-ai-education.html', title: '誰一人取り残さないAI教育' },
    { id: 1722, file: '1722-ai-communication-skills.html', title: 'AIと対話する力を育てる' },
    { id: 1723, file: '1723-paic-cycle-guide.html', title: 'P-A-I-Cサイクル実践ガイド' },
    { id: 1724, file: '1724-ai-ethics-5-principles.html', title: 'AI倫理5原則' },
    { id: 1725, file: '1725-singularity-2045-education.html', title: '2045年問題と教育' },
    // 実践・ハウツー系
    { id: 1771, file: '1771-chatgpt-beginners-guide.html', title: 'ChatGPTの始め方：初心者向け完全ガイド' },
    { id: 1772, file: '1772-prompt-writing-tips.html', title: 'プロンプトの書き方10選' },
    { id: 1773, file: '1773-ai-questions-to-avoid.html', title: 'AIに聞いてはいけない質問とは' },
    { id: 1774, file: '1774-kids-ai-usage-rules.html', title: '子どものAI利用ルールの作り方' },
    // 教育者・保護者向け
    { id: 1775, file: '1775-ai-education-in-schools.html', title: '学校でAIをどう教えるか' },
    { id: 1776, file: '1776-ai-and-school-essays.html', title: 'AI時代の読書感想文・作文指導' },
    { id: 1777, file: '1777-parent-child-ai-literacy.html', title: '親子で学ぶAIリテラシー' },
    // 4つの力シリーズ
    { id: 1778, file: '1778-ai-communication-skills-guide.html', title: 'AI時代のコミュニケーション力とは' },
    { id: 1779, file: '1779-language-skills-ai-era.html', title: '言語力を鍛える：AIに負けない表現力' },
    { id: 1780, file: '1780-self-coaching-introduction.html', title: 'セルフコーチング入門' },
    { id: 1781, file: '1781-ai-project-management.html', title: 'AIを活用したプロジェクト管理' },
    // トレンド・ニュース解説
    { id: 1782, file: '1782-generative-ai-trends-2025.html', title: '生成AIの最新動向2025' },
    { id: 1783, file: '1783-ai-and-copyright.html', title: 'AIと著作権：知っておくべき基礎知識' },
    { id: 1784, file: '1784-ai-job-changes.html', title: 'AIによる仕事の変化：消える職業・生まれる職業' }
];

const scriptDir = __dirname;

function makeRequest(method, postId, data = null) {
    return new Promise((resolve, reject) => {
        const auth = Buffer.from(`${CONFIG.username}:${CONFIG.password}`).toString('base64');
        const options = {
            hostname: 'haiia.org',
            port: 443,
            path: `${CONFIG.postsApi}/${postId}`,
            method: method,
            headers: {
                'Authorization': `Basic ${auth}`,
                'Content-Type': 'application/json'
            }
        };

        const req = https.request(options, (res) => {
            let body = '';
            res.on('data', chunk => body += chunk);
            res.on('end', () => {
                try {
                    resolve(JSON.parse(body));
                } catch (e) {
                    reject(new Error(body));
                }
            });
        });

        req.on('error', reject);
        if (data) req.write(JSON.stringify(data));
        req.end();
    });
}

function processContent(content) {
    // 記事ファイル内の著者・関連記事セクションを削除（テンプレートで管理）
    let processed = content.replace(/<aside class="haiia-author-section">[\s\S]*?<\/aside>/g, '');
    processed = processed.replace(/<section class="haiia-related-section">[\s\S]*?<\/section>/g, '');

    // 末尾の空白を整理
    processed = processed.trim();

    return processed;
}

async function uploadArticle(article) {
    const filePath = path.join(scriptDir, article.file);

    if (!fs.existsSync(filePath)) {
        console.log(`✗ ファイルが見つかりません: ${article.file}`);
        return false;
    }

    console.log(`📤 記事 ${article.id} (${article.title}) をアップロード中...`);

    try {
        const rawContent = fs.readFileSync(filePath, 'utf8');
        const content = processContent(rawContent);

        const result = await makeRequest('POST', article.id, { content });

        if (result.id === article.id) {
            console.log(`✓ 記事 ${article.id} を更新しました`);
            return true;
        } else {
            console.log(`✗ 記事 ${article.id} の更新に失敗: ${result.message || '不明なエラー'}`);
            return false;
        }
    } catch (error) {
        console.log(`✗ 記事 ${article.id} でエラー: ${error.message}`);
        return false;
    }
}

async function main() {
    const arg = process.argv[2];

    if (!arg) {
        console.log('使い方:');
        console.log('  node upload.js all      - 全記事をアップロード');
        console.log('  node upload.js [記事ID] - 特定の記事をアップロード');
        console.log('');
        console.log('利用可能な記事:');
        ARTICLES.forEach(a => console.log(`  ${a.id}: ${a.title}`));
        return;
    }

    if (arg === 'all') {
        console.log('=== 全記事をアップロード ===\n');
        let success = 0, fail = 0;

        for (const article of ARTICLES) {
            const result = await uploadArticle(article);
            if (result) success++; else fail++;
            await new Promise(r => setTimeout(r, 1000));
        }

        console.log(`\n=== 完了: 成功 ${success} / 失敗 ${fail} ===`);
    } else {
        const article = ARTICLES.find(a => a.id === parseInt(arg));
        if (article) {
            await uploadArticle(article);
        } else {
            console.log(`✗ 記事ID ${arg} が見つかりません`);
        }
    }
}

main().catch(console.error);
