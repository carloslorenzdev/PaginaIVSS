<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\DisallowedRawHtml\DisallowedRawHtmlExtension;
use League\CommonMark\MarkdownConverter;

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
        // $html = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $html);
        // $data['observacion'] = preg_replace('/<script(.*?)>(.*?)<\/script>/is', '', $data['observacion']);
        // $html = preg_replace('#<style(.*?)>(.*?)</style>#is', '', $html);
        $config = [
            // 'html_input' => 'escape',
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
        // $env = new Environment($config);
        // $env->addExtension(new CommonMarkCoreExtension());
        // $env->addExtension(new DisallowedRawHtmlExtension());
        // $converter = new MarkdownConverter($env);
        // dd(
        //     $data['observacion'],
        //     preg_replace('/<script(.*?)>(.*?)<\/script>/is', '', htmlspecialchars_decode($data['observacion'])),
        //     $converter->convert(htmlspecialchars_decode($data['observacion']))
        // );
        return Str::inlineMarkdown(
            $value,
            $config,
            [new DisallowedRawHtmlExtension()]
        );
    }
}
