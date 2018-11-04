<?php

namespace App\Model\Project;

use Illuminate\Database\Eloquent\Model;

class ProjectForeignAssistanceModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'project_fas';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['project_id','fa_country','fa_donor','fa_mof','fa_amount','is_deleted','user_id'];
}
