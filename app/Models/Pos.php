<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

class Pos extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'id';
    
    protected $guarded = ['id'];
    
    public function category() : HasOne
    {
        return $this->hasOne(PosCategory::class, 'id', 'pos_category');
    }
}
