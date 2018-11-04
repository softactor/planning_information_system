<?php

namespace App\Model\District;

use Illuminate\Database\Eloquent\Model;

class DistrictModel extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'districts';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id','div_id','district_name','district_bn','geo_code','dv_x','dv_y','is_deleted','user_id'];
}
