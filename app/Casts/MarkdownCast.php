<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use League\CommonMark\Extension\DisallowedRawHtml\DisallowedRawHtmlExtension;

class MarkdownCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return $value;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        $config = [
            'disallowed_raw_html' => [
                'disallowed_tags' => [
                    'embed',
                    'iframe',
                    'input',
                    'noembed',
                    'noframes',
                    'plaintext',
                    'select',
                    'script',
                    'style',
                    'textarea',
                    'title',
                    'xmp',
                ]
            ]
        ];

        return Str::inlineMarkdown(
            $value,
            $config,
            [new DisallowedRawHtmlExtension()]
        );
    }
}
