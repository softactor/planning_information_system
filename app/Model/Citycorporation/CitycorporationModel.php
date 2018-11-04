<?php

namespace App\Model\Citycorporation;

use Illuminate\Database\Eloquent\Model;

class CitycorporationModel extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'citycorporations';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id','div_id','citycorp_name','citycorp_name_bn','geo_code','citycorp_x','citycorp_y','is_deleted','user_id'];
}
