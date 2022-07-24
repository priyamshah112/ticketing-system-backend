<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Models\Software;
use App\Models\User;
use Carbon\Carbon;
use Mockery\Undefined;

class SoftwareImport implements ToModel, WithStartRow
{
    public function __construct(){
            $this->import_ids = [];
            $this->rows = 0;
            $this->totalImported = 0;
        }
    
    
        public function model(array $row){
            if(isset($row[1]) && $row[1] !== "")
            {
                $assig = null;
                
                if(isset($row[4]) && $row[4] != ""){
                    $user = User::where(['email' => $row[4]])->first();
                    if($user){
                        $assig = $user->id;
                    }
                }
    
                $data =  [
                    'name' => $row[1],
                    'version' => $row[2],
                    'key' => $row[3],
                    'assigned_to' => $assig,
                    'assigned_on' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[5])),
                    'expiry_date' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[6])),
                    'status' => $row[7],
                    'notes' => $row[8],
                    'enable' => 1,
                ];
    
                    //dd($data);
                    $add = 0;
                    foreach($data as $key => $value) {
                        if($value)
                            $add = 1;
                    }
                    if($add)
                        $inventory = Software::create($data); 

            }
             return null;
        }

        public function startRow(): int{
            return 2;
        }
    
}
