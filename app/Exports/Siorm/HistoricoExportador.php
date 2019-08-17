<?php

namespace App\Exports\Siorm;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromArray;

class HistoricoExportadorExport implements FromArray
{
    public function view(): View
    {
        return view('Siorm.index', compact('historicoExportador'));
    }
}
