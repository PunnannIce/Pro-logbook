@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">บันทึกของอาจารย์นิเทศก์</h1>
    <p class="text-center text-muted">สำหรับอาจารย์ในการบันทึกรายการนิเทศของนักศึกษา</p>
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-hover table-striped align-middle text-center">
                <thead>
                    <tr>
                        <th>รหัสนักศึกษา</th>
                        <th>ชื่อนักศึกษา</th>
                        <th>สาขา</th>
                        <th>ชั้นปี</th>
                        <th>สถานที่ฝึก</th>
                        <th>ภาคการศึกษา</th>
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
                        <td>{{ $student->location->name ?? '-' }}</td>
                        <td>{{ $student->location->term_year ?? '-' }}</td>
                        <td>
                            @if($student->student_id)
                                @if(in_array($student->student_id, $studentIdsWithNotes ?? []))
                                    <a 
                                        href="{{ route('teacher.notes.edit', ['student_id' => $student->student_id]) }}" 
                                        class="btn btn-warning btn-sm">
                                        แก้ไขรายการนิเทศ
                                    </a>
                                @else
                                    <a 
                                        href="{{ route('teacher.notes.edit', ['student_id' => $student->student_id]) }}" 
                                        class="btn btn-primary btn-sm">
                                        เพิ่มรายการนิเทศ
                                    </a>
                                @endif
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

@section('scripts')
<script>
    $(document).ready(function() {
        $('.table').DataTable({
            responsive: true,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/th.json'
            },
            "order": [] // Disable default sorting
        });
    });
</script>
@endsection
