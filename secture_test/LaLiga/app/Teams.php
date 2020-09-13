<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teams extends Model
{
    use SoftDeletes;
    
    protected $table = 'teams';

    protected $fillable = ['team_name', 'deleted_at'];

    
}
