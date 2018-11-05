<?php

namespace App\Model\Constituency;
use Illuminate\Database\Eloquent\Model;
class ConstituencyModel extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'constituency';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['const_id','name','longitude','latitude'];
}
