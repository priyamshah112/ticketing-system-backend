<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;

use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Fill;
class ReportExport implements FromCollection, WithColumnFormatting, ShouldAutoSize, withEvents, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public $data, $totallines, $rows, $memoLines, $maintotal, $title;
    public $headings, $frowkeys;
    public $highlightCells = [];

    function __construct($d, $lines, $period, $headings, $reportName) {
        $this->data = $d;      
        $this->frowkeys =  array_keys((array)$d->first());
        $this->headings = $headings;
        if($reportName != "")
            Settings::addHeading($this->data, $reportName, $period, $headings);   
        else
            $this->data->prepend($headings);

        $this->rows = sizeof($this->data);
        $this->totallines = $lines;
        // $this->highlightCells = $highlightCells;
        //$this->title = $title;
    }

    // function __construct($d, $lines, $period, $headings, $reportName, $highlightCells = [], $memoLines = [], $maintotal = false, $title = "Worksheet") {
    //     $this->data = $d;      
    //     $this->frowkeys =  array_keys((array)$d->first());
    //     $this->headings = $headings;
    //     Settings::addHeading($this->data, $reportName, $period, $headings, $maintotal);        
    //     $this->rows = sizeof($this->data);
    //     $this->totallines = $lines;
    //     $this->highlightCells = $highlightCells;
    //     $this->memoLines = $memoLines;
    //     $this->maintotal = $maintotal;
    //     $this->title = $title;
    // }

    public function collection()    {
        return $this->data;
    } 

    public function registerEvents(): array    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                Settings::formatting($this->data, $event, $this->highlightCells, $this->headings, $this->rows, $this->frowkeys, $this->totallines, $this->memoLines, $this->maintotal);                
                //$event->sheet->getDelegate()->getComment('E11')->getText()->createTextRun('Your comment:');
            },
        ];
    }

    public function title(): string
    {
        return "Worksheet"; //$this->title;
    }

    public function columnFormats(): array    {
        $cols = Settings::currancySign($this->frowkeys);
        return $cols;
    }
}
