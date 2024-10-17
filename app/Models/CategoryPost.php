<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPost extends Model
{
    use HasFactory;

    protected $table = 'category_post';
    // Laravel assumes that the table is in plural form
    // to correct we created the property $table to define the correct table name
    protected $fillable = ['category_id', 'post_id'];
    // allow mass assignment
    // we will be using create() to save data to this model
    public $timestamps = false;
    // disable the automatic timestamps for created_at and updated_at

    # to get the name of the category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
