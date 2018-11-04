<?php

namespace App\Model\Union;

use Illuminate\Database\Eloquent\Model;

class UnionModel extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bd_unions';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['division_id','district_id','upz_id','bd_union_name','un_x','un_y','constituent','is_deleted','user_id','created_at','updated_at'];
}
