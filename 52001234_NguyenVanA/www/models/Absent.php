<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;

class Absent extends Model
{
    //
    protected $table='absent';

    protected $primaryKey='id';

    public $timestamps = false;

    protected $guarded = ['id'];
}
?>