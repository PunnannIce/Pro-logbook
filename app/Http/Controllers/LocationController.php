<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\User;
use Illuminate\Http\Request;

class LocationController extends Controller
{


    public function index(Request $request)
    {
        $locations = Location::all();
        $users = User::all(); // Fetch all users

        // รวม student_id1-4
        $studentIds = $locations->flatMap(function ($loc) {
            return [
                $loc->student_id1,
                $loc->student_id2,
                $loc->student_id3,
                $loc->student_id4,
            ];
        })->filter()->unique();

        // รวม mentor_id1-3
        $mentorIds = $locations->flatMap(function ($loc) {
            return [
                $loc->mentor_id1,
                $loc->mentor_id2,
                $loc->mentor_id3,
            ];
        })->filter()->unique();

        // รวม teacher_id1-3
        $teacherIds = $locations->flatMap(function ($loc) {
            return [
                $loc->teacher_id
            ];
        })->filter()->unique();

        // ดึง users ทั้งนักศึกษา, พี่เลี้ยง และที่ปรึกษา
        $users = User::whereIn('student_id', $studentIds)
            ->orWhereIn('id', $mentorIds)
            ->orWhereIn('id', $teacherIds)
            ->get();

        // สร้าง 3 map แยก: student → keyBy student_id, mentor → keyBy id, teacher → keyBy id
        $students = $users->whereNotNull('student_id')->keyBy('student_id');
        $mentors = $users->keyBy('id');
        $teachers = $users->keyBy('id');

        return view('location.index', compact('locations', 'students', 'mentors', 'teachers', 'users'));
    }

    public function store(Request $request)
    {
        // Validate ข้อมูลที่รับมาจากฟอร์ม
        $request->validate([
            'name' => 'required|string|max:255',
            'student_id1' => 'nullable|size:10',
            'student_id2' => 'nullable|size:10',
            'student_id3' => 'nullable|size:10',
            'student_id4' => 'nullable|size:10',
        ]);

        // สร้างข้อมูลในฐานข้อมูล
        Location::create([
            'name' => $request->name,
            'student_id1' => $request->student_id1,
            'student_id2' => $request->student_id2,
            'student_id3' => $request->student_id3,
            'student_id4' => $request->student_id4,
        ]);

        // แสดงผลข้อความเมื่อบันทึกสำเร็จ
        return redirect()->back()->with('success', 'ข้อมูลสถานที่ฝึกงานบันทึกสำเร็จ');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'student_id1' => 'nullable|size:10',
            'student_id2' => 'nullable|size:10',
            'student_id3' => 'nullable|size:10',
            'student_id4' => 'nullable|size:10',
        ]);

        $location = Location::findOrFail($id);
        $location->update([
            'name' => $request->name,
            'student_id1' => $request->student_id1,
            'student_id2' => $request->student_id2,
            'student_id3' => $request->student_id3,
            'student_id4' => $request->student_id4,
        ]);

        return redirect()->route('location.index')->with('success', 'แก้ไขสถานที่ฝึกงานสำเร็จ');
    }

    public function registerAdvisor(Request $request)
    {
        $request->validate([
            'location_id' => 'required|exists:locations,id',
        ]);

        $location = Location::find($request->location_id);
        $location->teacher_id = auth()->user()->id; // Assuming the logged-in user is the advisor
        $location->save();

        return redirect()->route('location.index')->with('success', 'ลงทะเบียนที่ปรึกษาสำเร็จ!');
    }
}
