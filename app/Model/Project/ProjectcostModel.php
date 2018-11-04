<?php

namespace App\Model\Project;

use Illuminate\Database\Eloquent\Model;

class ProjectcostModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'projectcosts';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['project_id','implstartdate','implenddate','expgobrev','expparev','expofundrev','expothersrev','expgobcap','exppacap','expofundcap','expotherscap','expgobcont_ph','exppacont_ph','expofundcont_ph','expotherscont_ph','expgobcont_pr','exppacont_pr','expofundcont_pr','expotherscont_pr','gob_gt','pa_gt','own_gt','oth_gt','is_deleted','user_id','rev_total','cap_total','conph_total','conpr_total','sum_grand_total'];
}
