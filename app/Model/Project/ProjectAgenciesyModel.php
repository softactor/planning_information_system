<?php

namespace App\Model\Project;

use Illuminate\Database\Eloquent\Model;

class ProjectAgenciesyModel extends Model{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'projectagencies';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['project_id','ministry_id','agency_id','lead_agency','is_deleted','user_id'];
}
