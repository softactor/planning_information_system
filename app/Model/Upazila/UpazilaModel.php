<?php

namespace App\Model\Upazila;

use Illuminate\Database\Eloquent\Model;

class UpazilaModel extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'upazilas';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['district_id','upazila_name','upazila_name_bn','geo_code','upz_x','upz_y','constituency','is_deleted','user_id'];
}
