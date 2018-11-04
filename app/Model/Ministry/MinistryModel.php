<?php

namespace App\Model\Ministry;

use Illuminate\Database\Eloquent\Model;

class MinistryModel extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ministries';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['ministry_code','ministry_name','ministry_name_bn','ministry_short_name','is_deleted','user_id'];
}
