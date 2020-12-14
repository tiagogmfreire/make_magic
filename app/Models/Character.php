<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model for the Character domain entity
 */
class Character extends Model
{
    use SoftDeletes;

    protected $table = 'characters';
    protected $fillable = array('*');
    protected $guarded = ['id'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * Mapping relationship with the 'houses' table
     *
     * @return House
     */
    public function house()
    {
        return $this->belongsTo(House::class);
    }
}
