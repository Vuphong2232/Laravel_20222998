<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';

    protected $fillable = [
        'name',
        'credits'
    ];

    // 🔗 liên kết với enrollment
    public function enrollments()
    {
        return $this->hasMany(\App\Models\Enrollment::class);
    }
}