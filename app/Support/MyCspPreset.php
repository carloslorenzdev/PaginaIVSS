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
        $policy
            ->add(Directive::BASE, [Keyword::SELF, 'http://*.ivss.gob.ve:*', 'http://ivss.gob.ve:*', 'http://www.ivss.gob.ve:*'])
            ->add(Directive::CHILD, Keyword::NONE)
            ->add(Directive::CONNECT, Keyword::SELF)
            ->add(Directive::DEFAULT, Keyword::SELF)
            ->add(Directive::FONT, [Keyword::SELF, 'https://cdnjs.cloudflare.com', 'https://fonts.gstatic.com'])
            ->add(Directive::FORM_ACTION, Keyword::SELF)
            ->add(Directive::FRAME, Keyword::NONE)
            ->add(Directive::FRAME_ANCESTORS, Keyword::NONE)
            ->add(Directive::IMG, [Keyword::SELF, 'data:', 'https://cdn.jsdelivr.net', 'http://*.ivss.gob.ve:*', 'http://ivss.gob.ve:*', 'http://www.ivss.gob.ve:*'])
            ->add(Directive::MANIFEST, Keyword::SELF)
            ->add(Directive::MEDIA, Keyword::SELF)
            ->add(Directive::OBJECT, Keyword::NONE)
            ->add([Directive::SCRIPT, Directive::SCRIPT_ATTR, Directive::SCRIPT_ELEM], [Keyword::SELF, 'https://cdn.jsdelivr.net', 'https://unpkg.com'])
            ->add([Directive::STYLE, Directive::STYLE_ELEM], [Keyword::SELF, 'https://cdn.jsdelivr.net', 'https://cdnjs.cloudflare.com', 'https://unpkg.com', 'https://fonts.googleapis.com', Keyword::UNSAFE_INLINE])
            ->add(Directive::STYLE_ATTR, [Keyword::UNSAFE_EVAL, Keyword::UNSAFE_INLINE])
            ->add(Directive::WORKER, Keyword::NONE)
            ->addNonce(Directive::FONT)
            ->addNonce(Directive::IMG)
            ->addNonce(Directive::MEDIA)
            ->addNonce(Directive::SCRIPT)
            ->addNonce(Directive::SCRIPT_ATTR)
            ->addNonce(Directive::SCRIPT_ELEM)
            ;
    }
}

