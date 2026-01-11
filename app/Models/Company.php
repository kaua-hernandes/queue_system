<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    // relaçao de company para users - uma company tem muitos users
    public function users()
    {
        return $this->hasMany(User::class, 'id_company');
    }

    // relaçao de company para queues - uma company tem muitas queues
    public function queues()
    {
        return $this->hasMany(Queue::class, 'id_company');
    }
}
