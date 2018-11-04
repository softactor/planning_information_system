<?php

namespace App\Model\Division;

use Illuminate\Database\Eloquent\Model;

class DivisionModel extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admdivisions';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['dvname','dvname_bn','geo_code','dv_x','dv_y','is_deleted','user_id'];
}
