<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QueueTicket extends Model
{
    use SoftDeletes;

    // relação entre queue_ticket e queue - um ticket pertence a uma queue
    public function queue()
    {
        return $this->belongsTo(Queue::class, 'id_queue');
    }
}
