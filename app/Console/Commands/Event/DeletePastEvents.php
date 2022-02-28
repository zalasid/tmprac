<?php

namespace App\Console\Commands\Event;

use App\Jobs\Event\DeleteEventJob;
use App\Repositories\EventRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;

class DeletePastEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'event:delete-past-events';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will delete the past events from the database';

    /**
     * Event repository object
     *
     * @var \App\Repositories\EventRepository
     */
    protected $eventRepository;

    /**
     * Create a new command instance.
     * 
     * @param \App\Repositories\EventRepository $eventRepository
     * @return void
     */
    public function __construct(EventRepository $eventRepository)
    {
        parent::__construct();

        $this->eventRepository = $eventRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        try {
            $pastEvents = $this->eventRepository->getEvents(false, EventRepository::PAST_EVENT);

            $this->newLine();
            $this->warn('Deleting past events: ' . Carbon::now()->format('Y-m-d H:i:s'));
            $this->warn(str_repeat('=', 50));
            
            if ($pastEvents->count()) {
                $this->info('There are ' . $pastEvents->count() . ' past events are going to delete!');
                $this->info('Deleting the past events...');
                $this->newLine();
                $this->output->progressStart($pastEvents->count());
                foreach ($pastEvents as $event) {
                    DeleteEventJob::dispatch($event);
                    $this->output->progressAdvance();
                }
                $this->output->progressFinish();
                $this->info('Events deleted successfully!');
            } else {
                $this->info('No past events found');
            }
            
            return 0;
        } catch (Exception $e) {
            $this->error('Something went wrong!');
        }
    }
}
