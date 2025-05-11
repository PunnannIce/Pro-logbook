<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentLog;
use App\Models\User;
use App\Models\Student; // Ensure this line is present

class TeacherController extends Controller
{
    public function index()
    {
        $students = User::where('role', 'Student')->get(); // Fetch users with role 'Student'
        return view('teacher.index', compact('students')); // Pass $students to the view
    }

    public function updateComment(Request $request)
    {
        $log = StudentLog::findOrFail($request->id);

        if (auth()->user()->role === 'Teacher') {
            $log->teacher_comments = $request->teacher_comments;
            $log->save();
        }

        return redirect()->back()->with('success', 'ความคิดเห็นของอาจารย์ถูกอัปเดตเรียบร้อยแล้ว');
    }

    public function addNote($studentId)
    {
        $student = Student::where('student_id', $studentId)->firstOrFail(); 
        return view('teacher.addNote', compact('student')); 
    }
}
