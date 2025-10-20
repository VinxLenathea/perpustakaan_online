<?php

namespace App\Http\Controllers;

use App\Exports\BookExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportMonthly($month, $year)
    {
        return Excel::download(new BookExport($month, $year), 'data_buku_bulan_'.$month.'_tahun_'.$year.'.xlsx');
    }
}
