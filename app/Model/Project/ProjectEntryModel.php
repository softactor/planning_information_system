<?php

namespace App\Model\Project;

use Illuminate\Database\Eloquent\Model;

class ProjectEntryModel extends Model{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'projects';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['project_entry_date','project_app_code','project_name_eng','project_short_name','project_name_bng','pcdivision_id','wing_id','subsector_id','search_keyword',"protemp",'is_deleted','user_id','proposal_type_id','quality_review_identity'];
}
