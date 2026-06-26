<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name', 'color'];
    use HasFactory;

    public function issues()
    {
        return $this->belongsToMany(Issue::class);
    }
}
