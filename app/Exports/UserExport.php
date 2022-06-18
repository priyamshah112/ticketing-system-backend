<?php

namespace App\Exports;



use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class UserExport implements FromArray, WithStrictNullComparison, ShouldAutoSize, WithEvents, WithHeadings
{
    public $data, $totallines, $rows, $memoLines, $maintotal, $title;
    public $headings, $frowkeys;
    public $highlightCells = [];

    function __construct($d, $lines, $period, $headings, $reportName) {
        $this->data = $d;
        $this->frowkeys = [];
        $this->headings = "Error User Export";
        $this->rows = sizeof($this->data);
        $this->totallines = $lines;
    }

    public function array(): array
    {
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


    function sortArrayByArray(array $array, array $orderArray)
    {
        $ordered = array();
        foreach ($orderArray as $key => $value) {
            // dd($array[$key]);
            if (in_array($value, $array)) {
                //$ordered[$key] = $array[$key];
                array_push($ordered, $value);
                unset($array[$key]);
            } else {
                // $ordered[$key] = '';
                array_push($ordered, '');
            }
        }
        return $ordered;
    }

    function addStatus(array $status, array $or)
    {
        $ordered = array();
        $i = 0;
        foreach ($or as $key => $value) {
            if (!empty($value)) {
                //$ordered[$key] = $array[$key];
                array_push($ordered, $status[$i]);
                $i++;
            } else {
                // $ordered[$key] = '';
                array_push($ordered, '');
            }
        }
        return $ordered;
    }
    public function headings(): array
    {
        return ['name',
        	'email',
            'userType',
            'hireDate',
            'startDate',
            'firstName',
            'middleName',
            'lastName',
            'preferredName',
            'permanantAddress',
            'homePhone',
            'cellPhone',
            'title',
            'projectName',
            'clientName',
            'clientLocation',
            'workLocation',
            'supervisorName',
            'request',
            'providingLaptop',
            'hiredAs',
            'error'];

    }

}
