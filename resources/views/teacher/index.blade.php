@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">ตรวจสอบบันทึกประจำวัน</h1>
    <p class="text-center text-muted">สำหรับอาจารย์และพี่เลี้ยงในการตรวจสอบบันทึกประจำวันของนักศึกษา</p>
    
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-hover table-striped align-middle text-center">
                <thead class="table-primary">
                    <tr>
                        <th>รหัสนักศึกษา</th>
                        <th>ชื่อ</th>
                        <th>อีเมล</th>
                        <th>การดำเนินการ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        @if($student->student_id)
                        <tr>
                            <td>{{ $student->student_id }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>
                                <a href="{{ url('student/log/' . $student->student_id) }}" class="btn btn-primary btn-sm">
                                    ดูบันทึก
                                </a>
                            </td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
