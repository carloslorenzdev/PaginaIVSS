<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Jenssegers\Agent\Agent;

trait HasUserAgent
{
    /**
     * User agent libreria
     * @return Attribute
     */
    public function agent(): Attribute
    {
        return Attribute::make(fn () => new Agent(null, $this->user_agent));
    }
}
