<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
	public $timestamps = false;
    protected $fillable = ['title', 'parent_id', 'ord', 'status'];
    protected $table = 'cities';
    /**
     * Get the tabs
     */
    public function tabs()
    {
        //return $this->hasMany('App\Entities\Tabs');
    }
}
