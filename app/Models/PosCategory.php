<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosCategory extends Model
{
    use HasFactory;
    
    protected $table = 'pos_category';
    
    protected $primaryKey = 'id';
    
    protected $guarded = ['id'];
}
