<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait CreadorModificadorTrait
{
    /**
     * Usuario creador
     * @return HasOne
     */
    public function creador(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'created_by')->withTrashed();
    }

    /**
     * Usuario modificador
     * @return HasOne
     */
    public function modificador(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'updated_by')->withTrashed();
    }
}
