<?php

namespace App\Actions\Admin\Revistas;

use App\Models\Revista;
use Illuminate\Support\Facades\Storage;

class EliminarRevistaAction
{
    public function execute(Revista $revista)
    {
        if ($revista->archivo_pdf && Storage::disk('public')->exists($revista->archivo_pdf)) {
            Storage::disk('public')->delete($revista->archivo_pdf);
        }

        if ($revista->imagen_preview && Storage::disk('public')->exists($revista->imagen_preview)) {
            Storage::disk('public')->delete($revista->imagen_preview);
        }

        return $revista->delete();
    }
}
