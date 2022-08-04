<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Models\Inventory;
use App\Models\User;
use Carbon\Carbon;

class HardwareImport implements ToModel, WithStartRow
{
  
        public function __construct(){
            $this->import_ids = [];
            $this->rows = 0;
            $this->totalImported = 0;
        }
    
    
        public function model(array $row){
            if(isset($row[1]) && $row[1] !== "" && isset($row[11]) && $row[11] !== "" )
            {
                $assig = null;
                if(isset($row[8]) && $row[8] != ""){
                    $user = User::where(['email' => $row[8]])->first();
                    if($user){
                        $assig = $user->id;
                    }
                }

                $data =  [
                    'asset_name' => isset($row[1]) ? $row[1] : null,
                    'hardware_type' => isset($row[2]) ? $row[2] : null,
                    'unit_price' => isset($row[3]) ? $row[3] : null,
                    'model' => isset($row[4]) ? $row[4] : null,
                    'service_tag' => isset($row[5]) ? $row[5] : null,
                    'express_service_code' => isset($row[6]) ? $row[6] : null,
                    'warranty_expire_on' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[7])),
                    'assigned_to' => $assig,
                    'assigned_on' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[9])),
                    'status' => isset($row[10]) ? $row[10] : null,
                    'location' => isset($row[11]) ? $row[11] : null,
                    'description' => isset($row[12]) ? $row[12] : null,
                    'enable' => 1,
                ];

                //dd($data);
                $add = 0;
                foreach ($data as $key => $value) {
                    if($value)
                        $add = 1;

                }
                if($add)
                    $inventory = Inventory::create($data); 
                }
                return null;
        }

        public function startRow(): int{
            return 2;
        }
}
