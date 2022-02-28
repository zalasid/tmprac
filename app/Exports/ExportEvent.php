<?php

namespace App\Exports;

use App\Models\Event;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportEvent implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection(): \Illuminate\Support\Collection
    {
        $events = Event::select(['name', 'place', 'start_date', 'end_date', 'fees'])->get();
        return $events;
    }

    public function headings(): array
    {
        return ['name', 'place', 'start_date', 'end_date', 'fees'];
    }
}
