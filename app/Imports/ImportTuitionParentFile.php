<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Carbon\Carbon;
use DB;
use App\Models\TuitionParent;
use Hash;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Date;
use Illuminate\Filesystem\Filesystem;
use File;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;

class ImportTuitionParentFile implements ToCollection
{
    public function collection(Collection $rows)
    {
        $k = [];
        foreach ($rows as $key => $row)
        {
            if ($key > 0 && count($row) > 0) {
                $data = [
                    'first_name' => $row[0],
                    'middle_name' => $row[1],
                    'last_name' => $row[2],
                    'dob' => date('Y-m-d',strtotime($row[3])),
                    'gender' => $row[4],
                    'email' => strtolower($row[5]),
                    'mobile' => $row[6],
                    'full_name' => $row[0].' '.$row[1].' '.$row[2],
                ];
                TuitionParent::create($data);
            }
        }
    }

}
