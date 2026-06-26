<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    protected $fillable = ['name', 'description', 'start_date', 'deadline'];
    use HasFactory;
    public function issues()
    {
        return $this->hasMany(Issue::class);
    }
}
