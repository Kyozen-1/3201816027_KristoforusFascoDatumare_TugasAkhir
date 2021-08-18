<?php

namespace App\Imports;

use App\Models\RS_Data;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class RS_DataImport implements ToModel, WithStartRow
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
        return new RS_Data([
            'id_rs' => $row[0],
            'k_icu' => $row[1],
            'jlh_tmpt_icu' => $row[2],
            'k_isolasi' => $row[3],
            'jlh_tmpt_positif' => $row[4],
            'jlh_tmpt_suspek' => $row[5],
            'tgl' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['6'])->format('Y-m-d')
        ]);
    }
}