<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\LocationInfo; // Include LocationInfo model
use App\Models\StudentInfo;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $student_infos = StudentInfo::all();
        $locations = Location::all();
        $location_infos = LocationInfo::all(); // Fetch LocationInfo data

        return view('student.index', compact('user', 'student_infos', 'locations', 'location_infos'));
    }

    public function uploadImage(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'profile_image' => 'required|image|mimes:jpg,png|max:2048',
        ]);

        // Get the student's ID
        $studentId = auth()->user()->student_id;

        // Define the storage path and file name
        $fileName = $studentId . '.' . $request->file('profile_image')->extension();
        $path = public_path('student_images');

        // Move the uploaded file to the student_images folder
        $request->file('profile_image')->move($path, $fileName);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Profile image uploaded successfully.');
    }
}
