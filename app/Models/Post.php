<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function scopeWithImage($query){
        return $query->with(['image', function($query){
            $query->select('url', 'imageable_id', 'imageable_type');
        }]);
    }

    const BORRADOR = 1;
    const PUBLICADO = 1;
    const INACTIVO = 1;
  
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
