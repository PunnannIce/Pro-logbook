@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">รายการนิเทศสำหรับ</h1>
    <h3 class="mb-4">รหัสนักศึกษา: {{ $student->student_id }} {{ $student->name }}</h3>
    <h4 class="mb-4">
        @php
            $location = \App\Models\Location::all()->flatMap(function ($loc) use ($student) {
                return in_array($student->student_id, [$loc->student_id1, $loc->student_id2, $loc->student_id3, $loc->student_id4]) ? [$loc] : [];
            })->first();
            $teacherNote = \App\Models\TeacherNote::where('student_id', $student->student_id)->first();
        @endphp
        สถานที่ฝึกงาน: {{ $location->name ?? 'ยังไม่ได้ลงทะเบียน' }}<br>
        ภาคการศึกษา: {{ $location->term_year ?? 'ไม่พบข้อมูล' }}
    </h4>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <form action="{{ route('teacher.notes.update', ['student_id' => $student->student_id]) }}" method="POST" class="card p-4 shadow-sm">
        @csrf
        @method('PUT')
        <div class="form-group mb-3">
            <label for="supervision_type" class="form-label">ประเภทการนิเทศ</label>
            <select id="supervision_type" name="supervision_type" class="form-select" required>
                <option value="" disabled {{ !$teacherNote ? 'selected' : '' }}>เลือกประเภทการนิเทศ</option>
                <option value="ออนไลน์" {{ $teacherNote && $teacherNote->supervision_type == 'ออนไลน์' ? 'selected' : '' }}>ออนไลน์</option>
                <option value="ออนไซต์" {{ $teacherNote && $teacherNote->supervision_type == 'ออนไซต์' ? 'selected' : '' }}>ออนไซต์</option>
            </select>
        </div>
        <div class="form-group mb-3">
            <label for="note_detail" class="form-label">บันทึกการนิเทศ</label>
            <textarea id="note_detail" name="note_detail" class="form-control" rows="5" required>{{ $teacherNote->note_detail ?? '' }}</textarea>
        </div>
        <button type="submit" class="btn btn-success w-100">บันทึก</button>
    </form>
</div>
@endsection
