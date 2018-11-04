<?php

namespace App\Model\Wing;

use Illuminate\Database\Eloquent\Model;

class WingModel extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'wings';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['pcdivision_id','wing_name','wing_name_bn','wing_short_name','is_deleted','user_id'];
}
