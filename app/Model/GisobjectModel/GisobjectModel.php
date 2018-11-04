<?php

namespace App\Model\GisobjectModel;

use Illuminate\Database\Eloquent\Model;

class GisobjectModel extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gisobjects';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['gisobject_name','gisobject_type','is_deleted','user_id'];
}
