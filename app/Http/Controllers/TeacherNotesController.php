<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TeacherNote;

class TeacherNotesController extends Controller
{
    public function index()
    {
        $students = User::where('role', 'Student')->get();
        return view('teacher.notes', compact('students'));
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
