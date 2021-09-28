<?php

namespace App\Imports;

use App\Models\C19_Ptk;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class C19_PtkImport implements ToModel, WithStartRow
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
        return new C19_Ptk([
            'di_rs' => $row[0],
            'probable' => $row[1],
            'discarded' => $row[2],
            'isolasi' => $row[3],
            'sembuh' => $row[4],
            'meninggal' => $row[5],
            'tgl' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['6'])->format('Y-m-d')
        ]);
    }
}