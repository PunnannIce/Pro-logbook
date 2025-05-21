<?php

namespace App\Http\Controllers;

use App\Models\Confirm;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentLog;

class MentorController extends Controller
{
    public function req()
    {
        $locations = Location::all();
        $user = Auth::user(); // ดึงข้อมูลผู้ใช้ที่ล็อกอินอยู่
        $confirm = Confirm::where('user_id', $user->id)->first();

        // เช็คว่า user ปรากฏอยู่ใน mentor_id ของ location ไหน
        $registeredLocation = $locations->first(function ($loc) use ($user) {
            return $loc->mentor_id1 == $user->id || $loc->mentor_id2 == $user->id || $loc->mentor_id3 == $user->id;
        });

        // หาสถานที่ที่ mentor slots เต็ม (mentor_id1, mentor_id2, mentor_id3 ไม่เป็น null)
        $fullLocations = $locations->filter(function ($loc) {
            return $loc->mentor_id1 !== null && $loc->mentor_id2 !== null && $loc->mentor_id3 !== null;
        })->pluck('id')->toArray();

        return view('req', compact('locations', 'user', 'confirm', 'registeredLocation', 'fullLocations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'location_id' => 'required|exists:locations,id'
        ]);

        // สร้างข้อมูลในตาราง confirms
        $confirm = Confirm::create([
            'user_id' => Auth::id(),
            'location_id' => $request->location_id,
            'req' => 2
        ]);

        return redirect()->back()->with('success', 'ลงทะเบียนสำเร็จ');
    }

    public function update(Request $request)
    {
        $request->validate([
            'location_id' => 'required|exists:locations,id'
        ]);

        $user = Auth::user();

        // ค้นหา location ที่ user นี้เคยเป็น mentor อยู่
        $locations = Location::where('mentor_id1', $user->id)
            ->orWhere('mentor_id2', $user->id)
            ->orWhere('mentor_id3', $user->id)
            ->get();

        // ล้าง mentor_id ที่ตรงกับ user ออกให้หมด
        foreach ($locations as $location) {
            if ($location->mentor_id1 == $user->id) {
                $location->mentor_id1 = null;
            }
            if ($location->mentor_id2 == $user->id) {
                $location->mentor_id2 = null;
            }
            if ($location->mentor_id3 == $user->id) {
                $location->mentor_id3 = null;
            }
            $location->save();
        }

        // อัปเดต confirm ด้วยสถานที่ใหม่
        $confirm = Confirm::where('user_id', $user->id)->first();

        if ($confirm) {
            $confirm->location_id = $request->location_id;
            $confirm->req = 2; // ตั้งให้รออนุมัติใหม่
            $confirm->save();
        }

        return redirect()->back()->with('success', 'เปลี่ยนสถานที่เรียบร้อย');
    }

    public function updateSignature(Request $request, $id)
    {
        $log = StudentLog::findOrFail($id);

        if (auth()->user()->role === 'Mentor') {
            $log->signature = $request->has('signature') ? 1 : 0;
            $log->save();
        }

        return redirect()->back()->with('success', 'ลายเซ็นต์พี่เลี้ยงถูกอัปเดตเรียบร้อยแล้ว');
    }

    public function updateComment(Request $request)
    {
        $log = StudentLog::findOrFail($request->id);

        if (auth()->user()->role === 'Mentor') {
            $log->mentor_comments = $request->mentor_comments;
            $log->save();
        }

        return redirect()->back()->with('success', 'ความคิดเห็นของพี่เลี้ยงถูกอัปเดตเรียบร้อยแล้ว');
    }
}
