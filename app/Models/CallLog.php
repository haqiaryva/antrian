<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Staff;

class CallLog extends Model
{
    protected $fillable = ['queue_id', 'staff_id', 'called_at', 'finished_at'];

    public function queue()
    {
        return $this->belongsTo(Queue::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
}
