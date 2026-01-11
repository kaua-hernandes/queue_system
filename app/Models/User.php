<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use SoftDeletes;

    // relação entre user e company - um user pertence a uma company
    public function company()
    {
        return $this->belongsTo(Company::class, 'id_company');
    }
}
