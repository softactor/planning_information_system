<?php

namespace App\Model\Project;

use Illuminate\Database\Eloquent\Model;

class ProjectVersionsModel extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'project_versions';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['project_id','project_type_id','projectcode','pstatus','rev_number','statusdate','qreview','qrview_date','is_deleted','user_id','deo_id','deo_date'];
}
