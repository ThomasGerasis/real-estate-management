<?php

if (!function_exists('process_shortcodes')) {
    function process_shortcodes(string $content): string
    {
        $processor = app(\App\Services\ShortcodeProcessor::class);
        return $processor->process($content);
    }
}
