<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    use HasFactory;
    public function categories()
    {
        return $this->belongsToMany(Category::class,'category_parameters');
    }

    public function items()
    {
        return $this->belongsToMany(Item::class,'item_parameters')->withPivot(['data']);
    }
}
