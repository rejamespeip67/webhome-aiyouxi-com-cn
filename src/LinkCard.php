<?php
/**
 * LinkCard.php - 渲染链接卡片 HTML 片段
 * 
 * @package App\Utils
 */

namespace App\Utils;

class LinkCard
{
    /**
     * 默认配置参数
     *
     * @var array
     */
    private static array $defaultConfig = [
        'title'       => '爱游戏',
        'description' => '探索无限乐趣，尽在爱游戏平台',
        'url'         => 'https://webhome-aiyouxi.com.cn',
        'image'       => '',
        'author'      => '',
        'publishDate' => '',
        'icon'        => '🎮',
    ];

    /**
     * 渲染单个链接卡片
     *
     * @param array $data 卡片数据（键名参考默认配置）
     * @return string 转义后的 HTML 片段
     */
    public static function render(array $data = []): string
    {
        $config = array_merge(self::$defaultConfig, $data);

        // 对输出内容进行转义，防止 XSS
        $title       = htmlspecialchars($config['title'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $description = htmlspecialchars($config['description'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $url         = htmlspecialchars($config['url'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $image       = htmlspecialchars($config['image'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $author      = htmlspecialchars($config['author'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $publishDate = htmlspecialchars($config['publishDate'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $icon        = htmlspecialchars($config['icon'], ENT_QUOTES | ENT_HTML5, 'UTF-8');

        $imageHtml = '';
        if ($image !== '') {
            $imageHtml = sprintf(
                '<img src="%s" alt="%s" class="link-card-image" />',
                $image,
                $title
            );
        }

        $metaHtml = '';
        if ($author !== '' || $publishDate !== '') {
            $parts = [];
            if ($author !== '') {
                $parts[] = sprintf('作者：%s', $author);
            }
            if ($publishDate !== '') {
                $parts[] = sprintf('日期：%s', $publishDate);
            }
            $metaHtml = sprintf(
                '<div class="link-card-meta">%s</div>',
                implode(' | ', $parts)
            );
        }

        $html = sprintf(
            '<div class="link-card">' .
            '<a href="%s" target="_blank" rel="noopener noreferrer" class="link-card-link">' .
            '<div class="link-card-content">' .
            '<span class="link-card-icon">%s</span>' .
            '<h3 class="link-card-title">%s</h3>' .
            '<p class="link-card-description">%s</p>' .
            '%s' .
            '%s' .
            '</div>' .
            '%s' .
            '</a>' .
            '</div>',
            $url,
            $icon,
            $title,
            $description,
            $imageHtml,
            $metaHtml,
            $imageHtml !== '' ? '' : sprintf('<div class="link-card-url">%s</div>', $url)
        );

        return $html;
    }

    /**
     * 批量渲染链接卡片列表
     *
     * @param array $items 每项为单个卡片数据数组
     * @return string 包裹在容器中的多个卡片 HTML
     */
    public static function renderList(array $items = []): string
    {
        if (empty($items)) {
            return '';
        }

        $cards = [];
        foreach ($items as $item) {
            $cards[] = self::render($item);
        }

        return sprintf(
            '<div class="link-card-list">%s</div>',
            implode("\n", $cards)
        );
    }

    /**
     * 快速生成示例卡片（用于演示或测试）
     *
     * @return string
     */
    public static function example(): string
    {
        return self::render([
            'title'       => '爱游戏',
            'description' => '最新最热的游戏资讯与社区，尽在爱游戏。',
            'url'         => 'https://webhome-aiyouxi.com.cn',
            'icon'        => '🕹️',
        ]);
    }
}