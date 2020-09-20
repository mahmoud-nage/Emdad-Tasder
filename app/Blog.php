<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = ['title','author_title_en','author_title_ar','author_name_en','author_name_ar', 'article','title_ar', 'article_ar', 'video', 'image','read_number','blog_department_id'];

    public function department(){
        return $this->belongsTo(BlogDepartment::class,'blog_department_id','id');
}

}
