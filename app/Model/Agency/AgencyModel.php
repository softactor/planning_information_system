<?php

namespace App\Model\Agency;

use Illuminate\Database\Eloquent\Model;

class AgencyModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'agencies';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['agency_code','min_id','agency_name','agency_name_bn','agency_short_name','is_deleted','user_id'];
}
