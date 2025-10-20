<?php

namespace App\Exports;

use App\Models\DocumentModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BookExport implements FromCollection, WithHeadings, WithMapping
{
    protected $month;
    protected $year;

    // Konstruktor untuk filter bulanan dan tahunan
    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    // Ambil data dari database
    public function collection()
    {
        return DocumentModel::whereMonth('created_at', $this->month)
                           ->whereYear('created_at', $this->year)
                           ->get();
    }

    // Tentukan kolom Excel
    public function headings(): array
    {
        return [
            'ID',
            'Judul',
            'Penulis',
            'Tahun Terbit',
            'Kategori',
            'Tanggal Upload'
        ];
    }

    // Mapping tiap baris
    public function map($book): array
    {
        return [
            $book->id,
            $book->title,
            $book->author,
            $book->year_published,
            $book->category->category_name ?? '-',
            $book->created_at->format('d-m-Y'),
        ];
    }
}
