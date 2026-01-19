<?php
namespace StoryMgr\Support;

final class Seo {
    public static function makeTitle(string $storyTitle, int $chapterNumber, string $chapterTitle): string {
        $storyTitle   = trim($storyTitle);
        $chapterTitle = trim($chapterTitle);

        $base = sprintf('Chương %d: %s', $chapterNumber, $chapterTitle);
        if ($storyTitle !== '') {
            $base .= ' - ' . $storyTitle;
        }

        return mb_substr($base, 0, 255);
    }

    public static function makeDescriptionFromContent(string $content, int $max = 160): string {
        $text = wp_strip_all_tags($content);
        $text = preg_replace('/\s+/u', ' ', $text);
        $text = trim($text);

        if ($text === '') return '';

        if (mb_strlen($text) > $max) {
            $text = mb_substr($text, 0, $max);
            $text = rtrim($text, " \t\n\r\0\x0B,.-");
            $text .= '…';
        }

        return $text;
    }
}
