<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
	public $timestamps = false;
    protected $fillable = ['name', 'event_type_id', 'code', 'description', 'new_flg','publish_event','status', 'image','create_date', 'start_date', 'end_date'];
    protected $table = 'ccll_r_event_data';
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
