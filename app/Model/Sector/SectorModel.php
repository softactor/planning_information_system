<?php

namespace App\Model\Sector;

use Illuminate\Database\Eloquent\Model;

class SectorModel extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sectors';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['sector_name','sector_name_bn','is_deleted','user_id'];
}
