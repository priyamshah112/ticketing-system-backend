<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Models\Inventory;
use App\Models\User;

class HardwareImport implements ToModel, WithStartRow
{
  
        public function __construct(){
            $this->import_ids = [];
            $this->rows = 0;
            $this->totalImported = 0;
        }
    
    
        public function model(array $row){
            $assig = null;
            if($row[7] != ""){
                $user = User::where(['email' => $row[7]])->first();
                if($user){
                    $assig = $user->id;
                }
            }

            $data =  [
                'asset_name' => $row[0],
                'unit_price' => $row[1],
                'description' => $row[2],
                'service_tag' => $row[3],
                'express_service_code' => $row[4],
                'warranty_expire_on' => $row[5],
                'model' => $row[6],
                'assigned_to' => $assig,
                'assigned_on' => $row[8],
                'status' => $row[9],
                'location' => $row[10],
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
             return null;
        }

        public function startRow(): int{
            return 2;
        }
}
