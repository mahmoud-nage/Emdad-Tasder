<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogDepartment extends Model
{
    protected $table = 'blog_departments';
    protected $fillable = ['name_ar', 'name_en'];

    public function blogs(){
        return $this->hasMany(Blog::class,'blog_department_id','id');
    }

}
