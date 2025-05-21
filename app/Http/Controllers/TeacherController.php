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
        $user = auth()->user();
        $userId = $user->id;
        $role = $user->role;

        $studentIds = [];

        if ($role === 'Teacher') {
            // Get locations assigned to this teacher
            $locations = \App\Models\Location::where('teacher_id', $userId)->get();
        } elseif ($role === 'Mentor') {
            // Get locations assigned to this mentor (mentor_id1 or mentor_id2)
            $locations = \App\Models\Location::where('mentor_id1', $userId)
                ->orWhere('mentor_id2', $userId)
                ->get();
        } else {
            // For other roles, no students
            $locations = collect();
        }

        // Collect all student IDs from these locations
        foreach ($locations as $location) {
            if ($location->student_id1) {
                $studentIds[] = $location->student_id1;
            }
            if ($location->student_id2) {
                $studentIds[] = $location->student_id2;
            }
            if ($location->student_id3) {
                $studentIds[] = $location->student_id3;
            }
            if ($location->student_id4) {
                $studentIds[] = $location->student_id4;
            }
        }

        // Remove duplicates
        $studentIds = array_unique($studentIds);

        // Fetch students with those IDs and role 'Student'
        $students = User::where('role', 'Student')
            ->whereIn('student_id', $studentIds)
            ->get();

        // Map each student to their location
        $studentsWithLocation = $students->map(function ($student) use ($locations) {
            $location = $locations->first(function ($loc) use ($student) {
                return $loc->student_id1 == $student->student_id
                    || $loc->student_id2 == $student->student_id
                    || $loc->student_id3 == $student->student_id
                    || $loc->student_id4 == $student->student_id;
            });
            $student->location = $location;
            return $student;
        });

        return view('teacher.index', ['students' => $studentsWithLocation]);
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
