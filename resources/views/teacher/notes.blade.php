@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">บันทึกของอาจารย์นิเทศก์</h1>
    <p class="text-center text-muted">สำหรับอาจารย์ในการบันทึกรายการนิเทศของนักศึกษา</p>
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-hover table-striped align-middle text-center">
                <thead class="table-primary">
                    <tr>
                        <th>รหัสนักศึกษา</th>
                        <th>ชื่อนักศึกษา</th>
                        <th>สาขา</th>
                        <th>ชั้นปี</th>
                        <th>เพิ่มรายการนิเทศ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $index => $student)
                    <tr>
                        <td>{{ $student->student_id ?? 'ไม่พบข้อมูล' }}</td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->branch ?? 'ไม่พบข้อมูล' }}</td>
                        <td>{{ $student->year ?? 'ไม่พบข้อมูล' }}</td>
                        <td>
                            @if($student->student_id)
                                <a 
                                    href="{{ route('teacher.notes.edit', ['student_id' => $student->student_id]) }}" 
                                    class="btn btn-primary btn-sm">
                                    เพิ่มรายการนิเทศ
                                </a>
                            @else
                                <button 
                                    class="btn btn-danger btn-sm" disabled>
                                    ไม่สามารถแก้ไขข้อมูลได้ เนื่องจากไม่พบรหัสนักศึกษา
                                </button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
