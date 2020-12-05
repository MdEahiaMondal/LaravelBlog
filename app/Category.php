<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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

    /*protected $attributes  = ['background_image', 'slider_image']; if you use this it must be need to fillable or your db attribute  */
    protected $appends  = ['background_image', 'slider_image']; // custom attribute add

    public function getBackgroundImageAttribute()
    {
        return Storage::url($this->BgImg());
    }

    public function getSliderImageAttribute() // add custom attribute in model that is not my real fillable attribute
    {
        return Storage::url($this->SliderImg());
    }


   /*public function posts()
   {
       return $this->belongsToMany(Post::class)->withTimestamps();
   }*/

   public function posts()
   {
       return $this->morphedByMany(Post::class, 'categoryable')->withTimestamps();
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

       static::deleting(function (Category $category){
           $category->images()->delete();
       });
   }


   public function images()
   {
       return $this->morphMany('App\Image','imageable');
   }

   public function scopeBgImg()
   {
       return $this->images()->where('cat_type', 'background')->first()->path ?? '';
   }

   public function scopeSliderImg()
   {
       return $this->images()->where('cat_type', 'slider')->first()->path ?? '';
   }

}
