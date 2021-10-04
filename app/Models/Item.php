<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    public function parameters()
    {
        return $this->belongsToMany(Parameter::class,'item_parameters')->withPivot(['data']);
    }
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function ifDisabled()
    {
        if($this->status == 0 || $this->quantity == 0) {
            return "disabled";
        }
    }

    public function checkboxStatus()
    {
        if($this->status !== 0) {
            return "checked";
        }
    }
}
