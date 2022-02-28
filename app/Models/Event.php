<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'place', 'start_date', 'end_date', 'fees'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('descOrderByStartDate', function (Builder $builder) {
            $builder->orderBy('start_date', 'desc');
        });
    }

    /**
     * Method to add query scope for past events
     *
     */
    public function scopePastEvents($query)
    {
        $currentDateTime = Carbon::now();
        $query->where('end_date', '<', $currentDateTime);
    }
}
