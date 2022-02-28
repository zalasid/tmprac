<?php 

namespace App\Repositories;

use App\Exports\ExportEvent;
use App\Models\Event;
use Maatwebsite\Excel\Facades\Excel;

class EventRepository
{
    /**
     * Constants for the event
     */
    const PAST_EVENT  = 'past';
    const FUTURE_EVENT = 'future';

    /**
     * The name and signature of the console command.
     *
     * @var \App\Models\Event
     */
    protected $eventModel;

    public function __construct(Event $eventModel)
    {
        $this->eventModel = $eventModel;
    }

    /**
     * Method to get events with type
     *
     * @param bool $paginate
     * @param string $type
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Pagination\LengthAwarePaginator
     */
    public function getEvents(bool $paginate = false, string $type = null): \Illuminate\Database\Eloquent\Collection|\Illuminate\Pagination\LengthAwarePaginator
    {
        switch ($type) {
            case self::PAST_EVENT:
                $eventCollection = $this->eventModel->pastEvents();
                break;
            case self::FUTURE_EVENT:
                $eventCollection = $this->eventModel->futureEvents();
                break;
            default:
                $eventCollection = $this->eventModel;
                break;
        }
        if ($paginate) {
            $eventCollection = $eventCollection->paginate(10);
        } else {
            $eventCollection = $eventCollection->get();
        }
        return $eventCollection;
    }

    /**
     * Method to delete events based on given ids
     *
     * @param array $eventIds
     * @return int
     */
    public function deleteEvents(array $eventIds): int
    {
        return $this->eventModel->whereIn('id', $eventIds)->delete();
    }

    /**
     * Method to export events data
     *
     * @return void
     */
    public function exportEvents()
    {
        return Excel::download(new ExportEvent, 'events.xlsx');
    }
}
