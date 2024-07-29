<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BlogPosts extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];
    
    public function category() : HasOne
    {
        return $this->hasOne(BlogCategories::class, 'id', 'post_category');
    }
    
    public function scopeActive(Builder $query): void
    {
        $query->where('active', 1);
    }
}