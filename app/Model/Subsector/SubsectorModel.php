<?php

namespace App\Model\Subsector;

use Illuminate\Database\Eloquent\Model;

class SubsectorModel extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'subsectors';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['subsector_name','subsector_name_bn','sector_id','is_deleted','user_id'];
}
