<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LeaveRequest extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'leave_type', 'start_date', 'end_date', 'reason','status','days_requested','days_taken','days_left'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Calculate leave days excluding weekends and public holidays.
     */
    public function getLeaveDays()
    {
        $startDate = Carbon::parse($this->start_date);
        $endDate = Carbon::parse($this->end_date);

        // Fetch public holidays from database
        $publicHolidays = Holiday::pluck('date')->map(fn($date) => Carbon::parse($date)->toDateString())->toArray();

        $totalLeaveDays = 0;

        while ($startDate <= $endDate) {
            $dayOfWeek = $startDate->dayOfWeek;
            $formattedDate = $startDate->toDateString();

            if ($dayOfWeek !== Carbon::SATURDAY && $dayOfWeek !== Carbon::SUNDAY && !in_array($formattedDate, $publicHolidays)) {
                $totalLeaveDays++;
            }

            $startDate->addDay();
        }

        return $totalLeaveDays;
    }
}
