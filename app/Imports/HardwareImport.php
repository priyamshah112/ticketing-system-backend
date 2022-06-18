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
            if($row[8] != ""){
                $user = User::where(['name' => $row[8], 'enable' => 1])->first();
                if($user){
                    $assig = $user->id;
                }
            }

            $data =  ['customID' => $row[0],
                'device_name' => $row[1],
                'device_number' => $row[2],
                'brand' => $row[3],
                'model' => $row[4],
                'serial_number' => $row[5],
                'floor' => $row[6],
                'section' => $row[7],
                'assigned_to' => $assig,
                'status' => $row[9],
                'location' => $row[10],
                'notes' => $row[11],
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
