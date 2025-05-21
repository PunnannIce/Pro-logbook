<?php

namespace App\Http\Controllers;

use App\Models\Confirm;
use App\Models\Location;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Laravel\Prompts\confirm;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function users()
    {
        $users = User::where('role', '!=', 'Administrator')->get();
        $location = Location::all();
        $confirm = Confirm::all();

        return view('admin.users', compact('users', 'location', 'confirm'));
    }

    // public function approveMentor(Request $request)
    // {
    //     $userId = $request->input('user_id');

    //     // 3. อัปเดต user role
    //     $user = User::find($userId);
    //     if ($user) {
    //         $user->role = 'Mentor';
    //         $user->save();
    //     }

    //     // 4. อัปเดตค่า req เป็น 0 ใน confirm
    //     $confirm = Confirm::where('user_id', $userId)->first();
    //     if ($confirm) {
    //         $confirm->req = 0;
    //         $confirm->save();
    //     }

    //     return redirect()->back()->with('success', 'อนุมัติเรียบร้อยแล้ว');
    // }
    public function edit(Request $request)
    {
        $request->validate([
            'userId' => 'required|exists:users,id',
            'role' => 'required|in:Administrator,Teacher,Student,Mentor',
        ]);

        $user = User::findOrFail($request->userId);
        $user->role = $request->role;
        $user->save();

        return response()->json(['success' => true]);
    }


    public function approveMentor(Request $request)
    {
        $userId = $request->input('user_id');

        // 2. อัปเดตค่า req = 0 ใน confirm และดึง location_id
        $confirm = Confirm::where('user_id', $userId)->first();
        if ($confirm) {
            $confirm->req = 0;
            $confirm->save();

            $locationId = $confirm->location_id;

            // 3. หา location ที่ตรงกับ location_id
            $location = Location::find($locationId);

            if ($location) {
                // 4. ตรวจสอบ mentor_id1, mentor_id2, mentor_id3 ว่าอันไหนว่าง
                if (!$location->mentor_id1) {
                    $location->mentor_id1 = $userId;
                } elseif (!$location->mentor_id2) {
                    $location->mentor_id2 = $userId;
                } else {
                    // ถ้าทั้ง 2 ช่องเต็ม จะไม่ใส่เพิ่ม
                    return redirect()->back()->with('error', 'สถานที่นี้มี Mentor ครบแล้ว');
                }

                $location->save();
            }
        }


        // 1. อัปเดต user role
        $user = User::find($userId);
        if ($user) {
            $user->role = 'Mentor';
            $user->save();
        }


        return redirect()->back()->with('success', 'อนุมัติเรียบร้อยแล้ว');
    }
}
