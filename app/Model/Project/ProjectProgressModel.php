<?php

namespace App\Model\Project;

use Illuminate\Database\Eloquent\Model;

class ProjectProgressModel extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'project_progress';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['project_id','pversion_id','progresstype','progressdate','progressdecision','proapp','proapp_date','is_deleted','user_id'];
}
