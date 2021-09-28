<?php

namespace App\Exports;

use App\Models\C19_Klh;
use App\Models\Kelurahan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class C19_KlhExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = DB::table('kelurahan')
                ->join('klh_cvd', 'kelurahan.id', '=', 'klh_cvd.id_kelurahan')
                ->select('kelurahan.nama', 'klh_cvd.kontak_erat', 'klh_cvd.suspek', 'klh_cvd.positif', 'klh_cvd.positif_isolasi', 'klh_cvd.meninggal', 'klh_cvd.tgl')
                ->orderBy('tgl', 'desc')
                ->get();
        return $data; 
    }

    public function headings():array
    {
        return [
            'Nama Kelurahan', 
            'Kontak Erat', 
            'Suspek', 
            'Positif', 
            'Positif Isolasi', 
            'Meninggal', 
            'Tanggal'
        ];
    }
}