<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class ReportesService extends BasePythonService
{
    public function cargarReporteGeneral(UploadedFile $file)
    {
        return $this->postMultipart('reportes/cargar-general', 'file', $file);
    }
}