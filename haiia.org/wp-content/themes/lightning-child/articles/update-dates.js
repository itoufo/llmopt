#!/usr/bin/env node
/**
 * 記事の公開日を過去の日付に散りばめるスクリプト
 */

const https = require('https');

const CONFIG = {
    username: 'yuho132@haiia.org',
    password: 'mFRu EJlY Wz5p goj8 ziDY jWuC'
};

// 記事IDと日付のマッピング（2024年12月〜2025年1月に散りばめ）
const POSTS = [
    // 既存記事（2024年10月〜11月）
    { id: 1721, date: '2024-10-15T10:00:00', title: '誰一人取り残さないAI教育' },
    { id: 1722, date: '2024-10-22T14:30:00', title: 'AIと対話する力を育てる' },
    { id: 1723, date: '2024-11-05T09:00:00', title: 'P-A-I-Cサイクル実践ガイド' },
    { id: 1724, date: '2024-11-12T11:00:00', title: 'AI倫理5原則' },
    { id: 1725, date: '2024-11-20T15:00:00', title: '2045年問題と教育' },

    // 実践・ハウツー系（2024年12月）
    { id: 1771, date: '2024-12-02T10:00:00', title: 'ChatGPTの始め方' },
    { id: 1772, date: '2024-12-05T14:00:00', title: 'プロンプトの書き方10選' },
    { id: 1773, date: '2024-12-09T11:30:00', title: 'AIに聞いてはいけない質問' },
    { id: 1774, date: '2024-12-12T09:00:00', title: '子どものAI利用ルール' },

    // 教育者・保護者向け（2024年12月中旬）
    { id: 1775, date: '2024-12-16T10:00:00', title: '学校でAIをどう教えるか' },
    { id: 1776, date: '2024-12-19T14:30:00', title: 'AI時代の読書感想文' },
    { id: 1777, date: '2024-12-23T11:00:00', title: '親子で学ぶAIリテラシー' },

    // 4つの力シリーズ（2024年12月下旬〜2025年1月）
    { id: 1778, date: '2024-12-26T10:00:00', title: 'AI時代のコミュニケーション力' },
    { id: 1779, date: '2024-12-28T15:00:00', title: '言語力を鍛える' },
    { id: 1780, date: '2025-01-02T10:00:00', title: 'セルフコーチング入門' },
    { id: 1781, date: '2025-01-03T14:00:00', title: 'AIを活用したプロジェクト管理' },

    // トレンド解説（2025年1月）
    { id: 1782, date: '2025-01-04T09:00:00', title: '生成AIの最新動向2025' },
    { id: 1783, date: '2025-01-04T15:00:00', title: 'AIと著作権' },
    { id: 1784, date: '2025-01-05T10:00:00', title: 'AIによる仕事の変化' },

    // XaaMe レポート（本日午前公開）
    { id: 1831, date: '2025-01-05T11:00:00', title: 'XaaMe：AI時代の新パラダイム' }
];

function updatePostDate(postId, date) {
    return new Promise((resolve, reject) => {
        const auth = Buffer.from(`${CONFIG.username}:${CONFIG.password}`).toString('base64');
        const postData = JSON.stringify({
            date: date,
            date_gmt: date.replace('T', ' ').slice(0, -3) + ':00'
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
                    if (result.id === postId) {
                        resolve({ id: result.id, date: result.date });
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
    console.log('=== 記事の公開日を更新 ===\n');

    for (const post of POSTS) {
        try {
            const result = await updatePostDate(post.id, post.date);
            const dateStr = post.date.slice(0, 10);
            console.log(`✓ ${post.id}: ${dateStr} - ${post.title}`);
            await new Promise(r => setTimeout(r, 300));
        } catch (error) {
            console.log(`✗ ${post.id}: ${error.message}`);
        }
    }

    console.log('\n=== 完了 ===');
}

main().catch(console.error);
