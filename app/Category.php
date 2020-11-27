<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Category extends Model
{

   protected $fillable = [
       'name',
       'slug',
       'image',
       'created_by',
       'updated_by',
   ];

   public function posts()
   {
       return $this->belongsToMany(Post::class)->withTimestamps();
   }


   protected static function boot()
   {
       parent::boot(); // this boot method is parent model's child. that why

       static::creating(function (Category $category){
           $category->slug = Str::slug($category->name);
           $category->created_by = Auth::id();
       });

       static::updating(function (Category $category){
           $category->slug = Str::slug($category->name);
           $category->updated_by = Auth::id();
       });
   }


}
