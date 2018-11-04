<?php

namespace App\Model\Project;

use Illuminate\Database\Eloquent\Model;

class ProjectShapeFilesModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'projectshapefiles';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['project_id','docname','documents','is_deleted','user_id'];
}
