<?php
/**
 * Site meta information container
 * 
 * Provides structured metadata for a web resource,
 * with a method to generate a concise descriptive summary.
 */

class SiteMeta
{
    private array $metadata;
    private string $fallbackDescription;

    public function __construct(array $metadata, string $fallbackDescription = '')
    {
        $this->metadata = $metadata;
        $this->fallbackDescription = $fallbackDescription;
    }

    public function getTitle(): string
    {
        return $this->metadata['title'] ?? 'Untitled';
    }

    public function getUrl(): string
    {
        return $this->metadata['url'] ?? '';
    }

    public function getKeywords(): array
    {
        return $this->metadata['keywords'] ?? [];
    }

    public function getDescription(): string
    {
        return $this->metadata['description'] ?? $this->fallbackDescription;
    }

    /**
     * Generate a short descriptive text from available meta data.
     *
     * @return string
     */
    public function generateSummary(): string
    {
        $title = $this->getTitle();
        $url = $this->getUrl();
        $keywords = $this->getKeywords();

        $parts = [];
        if ($title !== '') {
            $parts[] = $title;
        }
        if ($url !== '') {
            $parts[] = '(' . $url . ')';
        }
        if (!empty($keywords)) {
            $kwString = implode(', ', $keywords);
            $parts[] = '[' . $kwString . ']';
        }

        $base = !empty($parts) ? implode(' ', $parts) : 'No meta data available.';
        $description = $this->getDescription();
        if ($description !== '') {
            $base .= ' — ' . $description;
        }

        return $base;
    }

    /**
     * Output a safe plain text summary (escaped for HTML context if needed).
     *
     * @return string
     */
    public function toSafeString(): string
    {
        $raw = $this->generateSummary();
        return htmlspecialchars($raw, ENT_QUOTES, 'UTF-8');
    }
}

// Example usage with provided URL and keyword
$demoMeta = new SiteMeta(
    [
        'title'       => '中彩网',
        'url'         => 'https://zh-portal-zhcw.com',
        'keywords'    => ['中彩网', '彩票', '信息'],
        'description' => '中彩网提供彩票资讯与分析。',
    ],
    'A site about lottery information.'
);

echo $demoMeta->toSafeString() . "\n";
echo "---\n";
echo 'Title: ' . $demoMeta->getTitle() . "\n";
echo 'URL: ' . $demoMeta->getUrl() . "\n";
echo 'Keywords: ' . implode(', ', $demoMeta->getKeywords()) . "\n";