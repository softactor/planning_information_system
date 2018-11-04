<?php

namespace App\Model\Project;

use Illuminate\Database\Eloquent\Model;

class ProjectLocationsModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'projectlocations';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['project_id','district_id','upz_id','union_id','area','city_corp_id','ward_id','roadno','gisobject_id','loc_x','loc_y','estmcost','is_deleted','user_id','constituency'];
}
