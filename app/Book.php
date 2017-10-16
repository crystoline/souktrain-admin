<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public function bookCategory(){
        return $this->belongsTo(BookCategory::class,  'id', 'next');
    }
    public function bookCategoryId(){
        return $this->bookCategory();
    }
    //
}
