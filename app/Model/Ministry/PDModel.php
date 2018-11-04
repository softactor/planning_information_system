<?php

namespace App\Model\Ministry;

use Illuminate\Database\Eloquent\Model;

class PDModel extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pcdivisions';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['pcdivision_code','pcdivision_name','pcdivision_name_bn','pcdivision_shortname','is_deleted','user_id'];
}
