<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kategori extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'table_category';

    protected $fillable = [
        'name',
    ];
    
    protected $dates = ['deleted_at'];
    
}