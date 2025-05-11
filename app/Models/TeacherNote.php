<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'supervision_type',
        'note_detail',
    ];
}