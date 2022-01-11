<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;

class PhongBan extends Model
{
    //
    protected $table='phongban';
    
    protected $primaryKey='id';
    
    public $timestamps = false;
    
    protected $guarded = ['id'];
}
?>