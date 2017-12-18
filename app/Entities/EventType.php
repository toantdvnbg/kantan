<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
	public $timestamps = false;
    protected $fillable = ['event_type', 'name', 'create_date', 'update_date'];
    protected $table = 'ccll_r_event_type';
    // const CREATED_AT = 'create_at';
    // const UPDATED_AT = 'update_at';
    /**
     * Get the tabs
     */
    public function tabs()
    {
        //return $this->hasMany('App\Entities\Tabs');
    }
}
