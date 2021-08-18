<?php

namespace App\Imports;

use App\Models\C19_Klh;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class C19_KlhImport implements ToModel, WithStartRow
{
    public function startRow():int
    {
        return 2;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new C19_Klh([
            'id_kelurahan' => $row[0],
            'kontak_erat' => $row[1],
            'suspek' => $row[2],
            'positif' => $row[3],
            'positif_isolasi' => $row[4],
            'meninggal' => $row[5],
            'color' => $row[6],
            'tgl' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['7'])->format('Y-m-d')
        ]);
    }
}