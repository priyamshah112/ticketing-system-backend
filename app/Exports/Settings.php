<?php

namespace App\Exports;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class Settings{

    public static $COLOR_YELLOW = 'FFFF00';
    public static $COLOR_GRAY = 'DDD9C4';
    //public static $COLOR_GREEN = 'FFFF00';
    public static $COLOR_DARK_RED = '8B0000';
    public static $COLOR_LIGHT_RED = 'FF6666';
    public static $COLOR_RED = 'FF0000';
    public static $COLOR_LIGHT_GREEN = '66FF66';
    public static $COLOR_GREEN = '006600';
    
    //public static $COLOR_LIGHT_BROWN = 'FFFF00';
    public static $DOLLAR_CELL = [ 'currentMonthCHK', 'currentYearCHK', 'miscellanous', 'gasChk', 'dslChk', 'E85Chk', 'totalTaxes', 'tax', 'nettotal', 'supplier','transport', 'totalcost', 'totalsale', 'checksum','gasTax', 'dslTax', 'gasSale', 'dslSale', 'E85Sale', 'saleWtTax', 'sale', 'supplier', 'supplierwotax', 'amount', 'jan_chk', 'feb_chk','mar_chk', 'apr_chk','may_chk','june_chk', 'july_chk','aug_chk','sep_chk', 'oct_chk','nov_chk','dec_chk'];
    public static $FIVE_DECIBLE = [ 'Reg87Price', 'Mid89Price', 'Pre91Price', 'E85Price', 'DieselPrice', 'BioPrice', 'RdyePrice'];
    public static $DOUBLE_DECIBLE = [ 'gasCpg', 'dslCpg', 'E85Cpg', 'totalCpg' ];
    public static $COMMA_CELL = ['currentMonth1', 'lastYearMonth', 'currentYear', 'lastYear', 'jan', 'feb', 'mar', 'apr', 'may', 'june', 'july', 'aug', 'sep', 'oct', 'nov', 'dec', 'totalGallon', 'gasTotal', 'dslTotal', 'E85'];
    public static $NUMBER_CELL = ['account_no'];
    public static $PERCENTAGE_CELL = ['chkper'];
    public static $REPORTNAME = "";

    public static function addHeading(&$data, $reportName, $period, $headings ){
        ob_end_clean();
        ob_start();
        $data->prepend($headings);
        $data->prepend(['']);
        // if($maintotal){
        //     $data->prepend(['']);      
        //     $data->prepend($maintotal);      
        // }
            
        //$data->prepend(['']);
        //$data->prepend([$period]);
        $data->prepend([$reportName]);
        Settings::$REPORTNAME = $reportName; 
        //$data->prepend(['National Petroleum']);       
        
    }    

    public static function formatting(&$data, $event, $highlightCells, $headings, $rows, $frowkeys, $totallines = [], $memoLines = [], $maintotal){
        $titleCells = ['A1:E1'];
        $lastIndex = Settings::toAlpha(sizeof((array)$headings) - 1);
        
        $event->sheet->getDelegate()->getStyle('A1:Z5000')->applyFromArray([
            'font' => ['size' => 14],
        ]);

        if(Settings::$REPORTNAME){
            foreach ($titleCells as $key => $value) {
                $event->sheet->mergeCells($value);
                $event->sheet->getDelegate()->getStyle($value)->applyFromArray( [ 'alignment' => [ 'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER ] ]);
            }
        }


        foreach ($highlightCells as $key => $value) {
            $cell = Settings::findColumn($value, $frowkeys);
            $event->sheet->getDelegate()->getStyle($cell.'3:'.$cell.($rows))->applyFromArray([
                'fill' => [
                    'fillType'  => Fill::FILL_SOLID,
                    'color' => ['rgb' => Settings::$COLOR_GRAY]
                ]
            ]);
        }
            // $headingCells = 'A3:'.$lastIndex.'3';
            // $event->sheet->getDelegate()->getStyle($headingCells)->applyFromArray(
            // ['font' => ['bold' => true,'size' => 13],
            // 'borders' => ['bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,'color' => ['argb' => '000000'],],]
            // ]);

        
      
    }


    public static function currancySign( $frowkeys){
        $cells = array();
        
        foreach (Settings::$DOLLAR_CELL as $key => $value) {
            if(array_search($value, $frowkeys)){
                $cell = Settings::findColumn($value, $frowkeys);
                $cells[$cell] = NumberFormat::FORMAT_CURRENCY_USD_SIMPLE;
            }            
        }
        foreach (Settings::$FIVE_DECIBLE as $key => $value) {
            if(array_search($value, $frowkeys)){
                $cell = Settings::findColumn($value, $frowkeys);
                $cells[$cell] = '"$"#,##0.00000_-';
            }            
        }
        foreach (Settings::$DOUBLE_DECIBLE as $key => $value) {
            if(array_search($value, $frowkeys)){
                $cell = Settings::findColumn($value, $frowkeys);
                $cells[$cell] = '"$"#,##0.00_-';
            }            
        }
        foreach (Settings::$COMMA_CELL as $key => $value) {
            if(array_search($value, $frowkeys)){
                $cell = Settings::findColumn($value, $frowkeys);
                $cells[$cell] = '#,##0';
            }            
        }
        foreach (Settings::$NUMBER_CELL as $key => $value) {
            if(array_search($value, $frowkeys)){
                $cell = Settings::findColumn($value, $frowkeys);
                $cells[$cell] = '###############';
            }            
        }
        
        foreach (Settings::$PERCENTAGE_CELL as $key => $value) {
            if(array_search($value, $frowkeys)){
                $cell = Settings::findColumn($value, $frowkeys);
                $cells[$cell] = NumberFormat::FORMAT_PERCENTAGE_00;
            }            
        }
        //;
        //($cells);
        return $cells;
    }

    public static function findColumn($key, $keys){
        return Settings::toAlpha(array_search($key, $keys));
    }

    public static function toAlpha($num){
       if($num > 25){
           return 'A' . chr(substr("000".(($num - 26)+65),-3));
       }
        return chr(substr("000".($num+65),-3));
    }
}