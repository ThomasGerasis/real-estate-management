<?php

namespace App\Services;

class ShortcodeProcessor
{
    protected array $shortcodes = [];

    public function register(string $tag, callable $callback): void
    {
        $this->shortcodes[$tag] = $callback;
    }

    public function process(string $content): string
    {
        if (empty($content)) {
            return $content;
        }

        // Pattern to match shortcodes: [tag attr="value" attr2="value2"]
        $pattern = '/\[(\w+)([^\]]*)\]/';

        return preg_replace_callback($pattern, function ($matches) {
            $tag = $matches[1];
            $attrString = $matches[2] ?? '';

            if (!isset($this->shortcodes[$tag])) {
                return $matches[0]; // Return original if shortcode not registered
            }

            $attributes = $this->parseAttributes($attrString);
            
            try {
                return call_user_func($this->shortcodes[$tag], $attributes);
            } catch (\Exception $e) {
                return "<!-- Shortcode error: {$e->getMessage()} -->";
            }
        }, $content);
    }

    protected function parseAttributes(string $text): array
    {
        $attributes = [];
        
        // Pattern to match attr="value" or attr='value'
        $pattern = '/(\w+)=["\']([^"\']*)["\']|(\w+)=(\S+)/';
        
        preg_match_all($pattern, $text, $matches, PREG_SET_ORDER);
        
        foreach ($matches as $match) {
            if (!empty($match[1])) {
                // Quoted value
                $attributes[$match[1]] = $match[2];
            } elseif (!empty($match[3])) {
                // Unquoted value
                $attributes[$match[3]] = $match[4];
            }
        }
        
        return $attributes;
    }

    public function getRegisteredShortcodes(): array
    {
        return array_keys($this->shortcodes);
    }
}
