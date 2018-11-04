<?php

namespace App\Model\Area;

use Illuminate\Database\Eloquent\Model;

class AreaModel extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'areas';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['upz_id','area_name','area_name_bn','geo_code','area_x','area_y','is_deleted','user_id'];
}
