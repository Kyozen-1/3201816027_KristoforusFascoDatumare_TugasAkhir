<?php

namespace App\Exports;

use App\Models\C19_Ptk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class C19_PtkExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return C19_Ptk::orderBy('tgl', 'desc')->get();
    }

    public function headings():array
    {
        return [
            'Id',
            'Di Rawat di RS',
            'Probable',
            'discarded',
            'isolasi',
            'sembuh',
            'meninggal',
            'tgl',
            'created_at'
        ];
    }
}