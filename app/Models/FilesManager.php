<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilesManager extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'file_id';
    
    protected $guarded = ['file_id'];
    
    protected $table = 'files_manager';
    
    public $timestamps = false;
}
