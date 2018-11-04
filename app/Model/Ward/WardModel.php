<?php

namespace App\Model\Ward;

use Illuminate\Database\Eloquent\Model;

class WardModel extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'wards';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id','citycorp_id','ward_nr','geo_code','ward_x','ward_y','constituency','is_deleted','user_id'];
}
