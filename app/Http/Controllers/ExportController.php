<?php

namespace App\Http\Controllers;

use App\Exports\BookExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportMonthly($month)
    {
        return Excel::download(new BookExport($month), 'data_buku_bulan_'.$month.'.xlsx');
    }
}
