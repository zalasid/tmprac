<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Repositories\EventRepository;
use Exception;
use Illuminate\Http\Request;

class EventController extends Controller
{

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            return view('event.index');
        } catch (Exception $e) {
            return redirect()->route('event.index')->withSuccess('Message', 'Hello everyone!');
        }
    }

    public function getEvents()
    {
        try {
            $events = $this->eventRepository->getEvents(true);
            return response()->json([
                'data' => [
                    'events' => $events
                ],
                'has_error' => false
            ]);
        } catch (Exception $e) {
            return response()->json([
                'has_error' => true,
                'msg' => 'Try after sometime!'
            ]);
        }
    }

    public function exportEvents()
    {
        try {
            return $this->eventRepository->exportEvents();
        } catch (Exception $e) {
            echo '<pre>'; print_r($e->getMessage()); exit;
            return response()->json([
                'has_error' => true,
                'msg' => 'Try after sometime!'
            ]);
        }
    }
}
