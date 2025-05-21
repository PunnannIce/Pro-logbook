<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'name' => ['required', 'regex:/^[a-zA-Zก-๏]+(\s[a-zA-Zก-๏]+)?$/u', 'max:100'],
            // 'student_id' => ['required', 'numeric', 'digits:10', 'unique:users'],
            'branch' => ['required',],
            'year' => ['required',],
            'phone_number' => ['required', 'numeric', 'digits:10'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:Student,Mentor,Teacher'],
        ];

        $messages = [
            'name.required' => 'กรุณากรอกชื่อ-นามสกุล',
            'name.max' => 'ชื่อ-นามสกุลยาวเกินไป (สูงสุด 100 ตัวอักษร)',
            'name.regex' => 'กรุณากรอกชื่อให้ถูกต้อง และสามารถเว้นวรรคได้แค่ 1 ครั้ง',

            // 'student_id.required' => 'กรุณากรอกรหัสนักศึกษา',
            // 'student_id.numeric' => 'รหัสนักศึกษาต้องเป็นเป็นตัวเลขเท่านั้น',
            // 'student_id.digits' => 'กรุณากรอกรหัสนักศึกษาให้ครบ 10 ตัวอักษร',
            // 'student_id.unique' => 'รหัสนักศึกษาได้ถูกลงทะเบียนไปแล้ว',

            'branch.required' => 'กรุณาเลือกสาขา',
            'branch.exists' => 'ข้อมูลสาขาไม่ถูกต้อง',

            'year.required' => 'กรุณาเลือกปีการศึกษา',
            'year.exists' => 'ข้อมูลปีการศึกษาไม่ถูกต้อง',

            'phone_number.required' => 'กรุณากรอกเบอร์โทรศัพท์',
            'phone_number.numeric' => 'เบอร์โทรศัพท์ต้องเป็นตัวเลขเท่านั้น',
            'phone_number.digits' => 'กรุณากรอกเบอร์โทรให้ครบ 10 ตัวอักษร',

            'email.required' => 'กรุณากรอกอีเมล',
            'email.email' => 'อีเมลไม่ถูกต้อง',
            'email.max' => 'อีเมลยาวเกินไป (สูงสุด 255 ตัวอักษร)',
            'email.unique' => 'อีเมลนี้ถูกลงทะเบียนไปแล้ว',

            'password.required' => 'กรุณากรอกรหัสผ่าน',
            'password.min' => 'รหัสผ่านต้องมีความยาวอย่างน้อย 8 ตัวอักษร',
            'password.confirmed' => 'รหัสผ่านไม่ตรงกัน',
        ];

        return Validator::make($data, $rules, $messages);
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $fullName = trim(($data['prefix'] ?? '') . ' ' . $data['name']);
        return User::create([
            'name' => $fullName,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'student_id' => $data['student_id'] ?? null,
            'branch' => $data['branch'] ?? null,
            'year' => $data['year'] ?? null,
            'phone_number' => $data['phone_number'] ?? null,
            'role' => $data['role'] ?? 'Student',
            'email_verified_at' => now(),
            'remember_token' => '',
        ]);
    }
}
