<?php

namespace App\Model\Commonconf;

use Illuminate\Database\Eloquent\Model;

class CommonconfModel extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'commonconfs';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['commonconf_name','commonconf_type','is_deleted','user_id'];
}
