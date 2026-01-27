<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MultiImage extends Model
{ 
    use HasFactory;
    
    protected $table = 'about_page_multi_image';

    public $timestamps = true;

    protected $guarded = [];

}
