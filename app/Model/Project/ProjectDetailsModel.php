<?php

namespace App\Model\Project;

use Illuminate\Database\Eloquent\Model;

class ProjectDetailsModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'project_details';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['project_id','objectives','backgrounds','activities','objectives_bng','backgrounds_bng','activities_bng','bnf_male','bnf_female','bnf_total','is_deleted','user_id'];
}
