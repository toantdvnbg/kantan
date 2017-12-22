<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
	public $timestamps = false;
    protected $fillable = ['title', 'parent_id', 'ord', 'status', 'publish'];
    protected $table = 'product_categories';
    /**
     * Get the tabs
     */
    public function tabs()
    {
        //return $this->hasMany('App\Entities\Tabs');
    }
}
