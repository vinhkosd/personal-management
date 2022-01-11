<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    //
    protected $table='tasks';

    protected $primaryKey='id';

    public $timestamps = false;

    protected $guarded = ['id'];
}
?>