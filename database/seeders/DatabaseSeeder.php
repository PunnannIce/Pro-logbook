<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('adminadmin'),
            ],
            [
                'name' => 'อาจารย์สุวาณี คำศรี',
                'email' => 'teacher@gmail.com',
                'password' => Hash::make('teacherteacher'),
            ],
            [
                'name' => 'นายซีเมเจอร์ บลูโซล',
                'email' => 'mentor1@gmail.com',
                'password' => Hash::make('mentormentor'),
            ],
            [
                'name' => 'นายผ้าพันคอ ดวงดาว',
                'email' => 'mentor2@gmail.com',
                'password' => Hash::make('mentormentor'),
            ],
            [
                'name' => 'นางสาวแทนรัก ประนา',
                'email' => 'student@gmail.com',
                'password' => Hash::make('studentstudent'),
            ],
        ];

        foreach ($users as $data) {
            $role = $data['name'] === 'admin' ? 'Administrator' : 'Student';

            User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => $data['password'],
                    'role' => $role,
                ]
            );
        }
    }
}


