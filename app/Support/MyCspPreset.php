<?php

namespace App\Support;

use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;
use Spatie\Csp\Policy;
use Spatie\Csp\Preset;

class MyCspPreset implements Preset
{
    public function configure(Policy $policy): void
    {
        if (request()->path() == config('log-viewer.route_path') && request()->user() && request()->user()->isAdmin()) {
            return;
        }

        $isLocal = !app()->isProduction();

        $connectHosts = [Keyword::SELF, 'https://ipinfo.io', 'https://get.geojs.io'];
        $imgHosts = [Keyword::SELF, 'data:', 'https://*.ivss.gob.ve:*', 'https://ivss.gob.ve:*'];
        $scriptHosts = [Keyword::SELF];
        $styleHosts = [Keyword::SELF, 'https://cdnjs.cloudflare.com', 'https://fonts.googleapis.com'];

        if ($isLocal) {
            $connectHosts = array_merge($connectHosts, ['http://localhost:*', 'https://localhost:*', 'http://127.0.0.1:*', 'https://127.0.0.1:*']);
            $imgHosts = array_merge($imgHosts, ['http://localhost:*', 'https://localhost:*', 'http://127.0.0.1:*', 'https://127.0.0.1:*', 'http://*.ivss.gob.ve:*', 'http://ivss.gob.ve:*']);
            $scriptHosts = array_merge($scriptHosts, ['http://localhost:*', 'https://localhost:*', 'http://127.0.0.1:*', 'https://127.0.0.1:*']);
            $styleHosts = array_merge($styleHosts, ['http://localhost:*', 'https://localhost:*', 'http://127.0.0.1:*', 'https://127.0.0.1:*']);
        }

        $policy
            ->add(Directive::BASE, [Keyword::SELF, 'https://*.ivss.gob.ve:*', 'https://ivss.gob.ve:*', 'https://www.ivss.gob.ve:*'])
            ->add(Directive::CHILD, Keyword::NONE)
            ->add(Directive::CONNECT, $connectHosts)
            ->add(Directive::DEFAULT, Keyword::SELF)
            ->add(Directive::FONT, [Keyword::SELF, 'data:', 'https://cdnjs.cloudflare.com', 'https://fonts.gstatic.com'])
            ->add(Directive::FORM_ACTION, Keyword::SELF)
            ->add(Directive::FRAME, Keyword::NONE)
            ->add(Directive::FRAME_ANCESTORS, Keyword::NONE)
            ->add(Directive::IMG, $imgHosts)
            ->add(Directive::MANIFEST, Keyword::SELF)
            ->add(Directive::MEDIA, Keyword::SELF)
            ->add(Directive::OBJECT, Keyword::NONE)
            ->add([Directive::SCRIPT, Directive::SCRIPT_ATTR, Directive::SCRIPT_ELEM], array_merge($scriptHosts, [Keyword::UNSAFE_INLINE]))
            ->add([Directive::STYLE, Directive::STYLE_ELEM], array_merge($styleHosts, [Keyword::UNSAFE_INLINE]))
            ->add(Directive::STYLE_ATTR, [Keyword::UNSAFE_INLINE])
            ->add(Directive::WORKER, Keyword::NONE)
            ->addNonce(Directive::SCRIPT)
            ->addNonce(Directive::STYLE)
            ->addNonce(Directive::FONT)
            ->addNonce(Directive::IMG)
            ->addNonce(Directive::MEDIA);
    }
}

