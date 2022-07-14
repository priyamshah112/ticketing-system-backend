<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Models\Software;
use App\Models\User;

class SoftwareImport implements ToModel, WithStartRow
{
    public function __construct(){
            $this->import_ids = [];
            $this->rows = 0;
            $this->totalImported = 0;
        }
    
    
        public function model(array $row){
            $assig = null;

            if($row[3] != ""){
                $user = User::where(['email' => $row[3]])->first();
                if($user){
                    $assig = $user->id;
                }
            }

            $data =  [
                'name' => $row[0],
                'version' => $row[1],
                'key' => $row[2],
                'assigned_to' => $assig,
                'assigned_on' => $row[4],
                'expiry_date' =>$row[5],
                'status' => $row[6],
                'notes' => $row[7],
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
             return null;
        }

        public function startRow(): int{
            return 2;
        }
    
}
