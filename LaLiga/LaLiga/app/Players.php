<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Players extends Model
{
    use SoftDeletes;

    protected $table = 'players';

    protected $fillable = ['name', 'position', 'team_id', 'price', 'deleted_at'];

    public function teams()
    {
        return $this->belongsTo('App\Teams','team_id', 'id');
    }
}
