<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TeacherNote;

class TeacherNotesController extends Controller
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

        return view('teacher.notes', ['students' => $studentsWithLocation]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,student_id',
            'supervision_type' => 'required|string|max:255',
            'note_detail' => 'required|string',
        ]);

        TeacherNote::create([
            'student_id' => $request->student_id,
            'supervision_type' => $request->supervision_type,
            'note_detail' => $request->note_detail,
        ]);

        return back()->with('success', 'บันทึกสำเร็จ');
    }

    public function edit($student_id)
    {
        $student = User::where('student_id', $student_id)->where('role', 'Student')->first();

        if (!$student) {
            return back()->with('error', 'ไม่พบข้อมูลนักศึกษา');
        }

        return view('teacher.edit_note', compact('student'));
    }

    public function update(Request $request, $student_id)
    {
        $request->validate([
            'supervision_type' => 'required|string|in:ออนไลน์,ออนไซต์',
            'note_detail' => 'required|string',
        ]);

        $teacherNote = TeacherNote::where('student_id', $student_id)->first();

        if ($teacherNote) {
            // Update the existing record
            $teacherNote->update([
                'supervision_type' => $request->supervision_type,
                'note_detail' => $request->note_detail,
            ]);
        } else {
            // Create a new record
            TeacherNote::create([
                'student_id' => $student_id,
                'supervision_type' => $request->supervision_type,
                'note_detail' => $request->note_detail,
            ]);
        }

        return back()->with('success', 'บันทึกนิเทศสำเร็จ');
    }
}
