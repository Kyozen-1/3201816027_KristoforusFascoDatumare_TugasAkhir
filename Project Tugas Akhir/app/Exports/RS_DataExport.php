<?php

namespace App\Exports;

use App\Models\RS_Data;
use App\Models\RS;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class RS_DataExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = DB::table('rs')
                ->join('data_rs', 'rs.id', '=', 'data_rs.id_rs')
                ->select('rs.nama', 'data_rs.k_icu', 'data_rs.jlh_tmpt_icu', 'data_rs.k_isolasi', 'data_rs.jlh_tmpt_positif', 'data_rs.jlh_tmpt_suspek', 'data_rs.tgl')
                ->orderBy('tgl', 'desc')
                ->get();
        return $data;
    }

    public function headings():array
    {
        return [
            'Nama Rumah Sakit',
            'Ketersediaan Tempat Tidur ICU',
            'Jumlah Tempat Tidur ICU Terisi Pasien Positif Covid-19 + Suspek',
            'Ketersediaan Tempat Tidur Isolasi',
            'Jumlah Tempat Tidur Terisi Positif Covid-19',
            'Jumlah Kamar Tidur Terisi Suspek',
            'Tanggal'
        ];
    }
}