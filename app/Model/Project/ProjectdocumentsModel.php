<?php

namespace App\Model\Project;

use Illuminate\Database\Eloquent\Model;

class ProjectdocumentsModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'projectdocuments';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['project_id','docname','documents','doctype','remarks','is_deleted','user_id','doc_path'];
}
