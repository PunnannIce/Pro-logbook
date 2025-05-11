@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">รายการบันทึกประจำวัน</h1>

    <!-- Success Alert -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @php // Use URL student_id or fallback to logged-in user's student_id
        $studentId = request()->route('student_id') ?? auth()->user()->student_id; 
        $student = \App\Models\User::where('student_id', $studentId)->first();
        $locations = \App\Models\Location::where(function ($query) use ($studentId) {
            $query->where('student_id1', $studentId)
                  ->orWhere('student_id2', $studentId)
                  ->orWhere('student_id3', $studentId)
                  ->orWhere('student_id4', $studentId);
        })->first();

        $mentorNames = $locations 
            ? collect([$locations->mentor_id1, $locations->mentor_id2, $locations->mentor_id3])
                ->filter()
                ->flatMap(function ($mentorId) {
                    return \App\Models\User::where('id', $mentorId)->pluck('name');
                })
                ->implode(', ') 
            : 'ไม่พบข้อมูล';

        $advisorNames = $locations 
            ? collect([$locations->teacher_id])
                ->filter()
                ->flatMap(function ($teacherId) {
                    return \App\Models\User::where('id', $teacherId)->pluck('name');
                })
                ->implode(', ') 
            : 'ไม่พบข้อมูล';

        $teacherNote = \App\Models\TeacherNote::where('student_id', $studentId)->first();
    @endphp

    @if($student)
        <form action="{{ url('student/log/' . $student->student_id) }}" method="POST" id="logForm">
            @csrf
            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="studentName" class="form-label">ชื่อ-นามสกุล</label>
                    <input type="text" class="form-control" id="studentName" name="student_name" value="{{ $student->name }}" readonly>
                </div>
                <div class="col-md-6">
                    <label for="studentId" class="form-label">รหัสนักศึกษา</label>
                    <input type="text" class="form-control" id="studentId" name="student_id" value="{{ $student->student_id }}" readonly>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="advisorName" class="form-label">ชื่ออาจารย์นิเทศก์</label>
                    <input type="text" class="form-control" id="advisorName" name="advisor_name" value="{{ $advisorNames }}" readonly>
                </div>
                <div class="col-md-6">
                    <label for="mentorName" class="form-label">ชื่อพี่เลี้ยง</label>
                    @if ($locations)
                        <ul class="list-group">
                            @foreach(collect([$locations->mentor_id1, $locations->mentor_id2, $locations->mentor_id3])->filter() as $mentorId)
                                @php
                                    $mentorName = \App\Models\User::where('id', $mentorId)->pluck('name')->first();
                                @endphp
                                <li class="list-group-item text-start">{{ $mentorName ?? 'ไม่พบข้อมูล' }}</li>
                            @endforeach
                        </ul>
                    @else
                        <input type="text" class="form-control" value="ไม่พบข้อมูล" readonly>
                    @endif
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-4">
                    <label for="supervisionType" class="form-label">ประเภทของการนิเทศ</label>
                    <input type="text" class="form-control" id="supervisionType" name="supervision_type" value="{{ $teacherNote->supervision_type ?? 'ไม่พบข้อมูล' }}" readonly>
                </div>
                <div class="col-md-4">
                    <label for="locationName" class="form-label">ชื่อสถานที่ฝึกงาน</label>
                    <input type="text" class="form-control" id="locationName" name="location_name" value="{{ $locations->name ?? 'ไม่พบข้อมูล' }}" readonly>
                </div>
                <div class="col-md-4">
                    <label for="term" class="form-label">เทอมการศึกษา</label>
                    <input type="text" class="form-control" id="term" name="term" value="{{ $locations->term_year ?? 'ไม่พบข้อมูล' }}" readonly>
                </div>
            </div>
        </form>
    @else
        <div class="alert alert-danger">ไม่พบข้อมูลนักศึกษา</div>
    @endif

    @if(auth()->user()->role === 'Student')
        <div class="d-flex justify-content-between mb-3">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addLogModal">เพิ่มบันทึก</button>
            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editLogModal">แก้ไขบันทึก</button>
        </div>
    @endif

    @php
        $logs = collect($student_log->where('student_id', $studentId)->first()->log ?? [])->sortBy('log_date');
    @endphp

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover text-center align-middle" id="logEntries">
            <thead class="table-primary">
                <tr>
                    <th class="text-center" style="width: 12%;">วันที่</th>
                    <th class="text-center" style="width: 18%;">หัวข้อ</th>
                    <th class="text-center" style="width: 30%;">รายละเอียด</th>
                    @if(auth()->user()->role === 'Teacher' || auth()->user()->role === 'Mentor')
                    <th class="text-center" style="width: 10%;">วันที่สร้าง</th>
                    @endif
                    <th class="text-center" style="width: 10%;">ความเห็นจากอาจารย์</th>
                    <th class="text-center" style="width: 10%;">ความเห็นจากพี่เลี้ยง</th>
                    <th class="text-center" style="width: 10%;">ลายเซ็นต์พี่เลี้ยง</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($log['log_date'])->format('d/m/Y') }}</td>
                    <td>{{ $log['log_header'] }}</td>
                    <td>{{ $log['log_detail'] }}</td>
                    @if(auth()->user()->role === 'Teacher' || auth()->user()->role === 'Mentor')
                    <td>{{ \Carbon\Carbon::parse($log['created_date'])->format('d/m/Y') }}</td>
                    @endif
                    <td>
                        <button type="button" class="btn btn-outline-primary btn-sm viewTeacherComments" data-bs-toggle="modal" data-bs-target="#teacherCommentsModal" data-comments="{{ json_encode($log['t_comments'] ?? []) }}" data-student-id="{{ $studentId }}" data-log-date="{{ $log['log_date'] }}">
                            <i class="bi bi-eye"></i> 
                            @if(auth()->user()->role === 'Teacher')
                                เพิ่มความคิดเห็น
                            @else
                                ดูความคิดเห็น
                            @endif
                        </button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-outline-primary btn-sm viewMentorComments" data-bs-toggle="modal" data-bs-target="#mentorCommentsModal" data-comments="{{ json_encode($log['m_comments'] ?? []) }}" data-student-id="{{ $studentId }}" data-log-date="{{ $log['log_date'] }}">
                            <i class="bi bi-eye"></i> 
                            @if(auth()->user()->role === 'Mentor')
                                เพิ่มความคิดเห็น
                            @else
                                ดูความคิดเห็น
                            @endif
                        </button>
                    </td>
                    <td>
                        <form action="{{ route('mentor.signature.update') }}" method="POST" class="signature-form">
                            @csrf
                            <input type="hidden" name="student_id" value="{{ $studentId }}">
                            <input type="hidden" name="log_date" value="{{ $log['log_date'] }}">
                            <input type="hidden" name="signature" value="{{ ($log['signature'] ?? 'no') === 'yes' ? '0' : '1' }}">
                            <input type="checkbox" class="form-check-input signature-checkbox" 
                                {{ ($log['signature'] ?? 'no') === 'yes' ? 'checked' : '' }} 
                                {{ auth()->user()->role === 'Mentor' ? '' : 'disabled' }} 
                                onchange="this.form.submit()">
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">ไม่มีข้อมูลบันทึก</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Add Log Modal -->
    <div class="modal fade" id="addLogModal" tabindex="-1" aria-labelledby="addLogModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('student.log.store', ['student_id' => $studentId]) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addLogModalLabel">เพิ่มบันทึก</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="logDate" class="form-label">วันที่</label>
                            <input type="date" class="form-control" id="logDate" name="date" required>
                        </div>
                        <div class="mb-3">
                            <label for="logTitle" class="form-label">หัวข้อ</label>
                            <input type="text" class="form-control" id="logTitle" name="title" placeholder="หัวข้อบันทึก" required>
                        </div>
                        <div class="mb-3">
                            <label for="logDetails" class="form-label">รายละเอียด</label>
                            <textarea class="form-control" id="logDetails" name="details" rows="3" placeholder="รายละเอียดบันทึก" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Log Modal -->
    <div class="modal fade" id="editLogModal" tabindex="-1" aria-labelledby="editLogModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('student.log.update', ['student_id' => $studentId]) }}" method="POST" id="editLogForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editLogModalLabel">แก้ไขบันทึก</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editLogDate" class="form-label">เลือกวันที่</label>
                            <select class="form-select" id="editLogDate" name="date" required>
                                @foreach($logs as $log)
                                    <option value="{{ $log['log_date'] }}">{{ \Carbon\Carbon::parse($log['log_date'])->format('d/m/Y') }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editLogTitle" class="form-label">หัวข้อ</label>
                            <input type="text" class="form-control" id="editLogTitle" name="title" placeholder="หัวข้อบันทึก" required>
                        </div>
                        <div class="mb-3">
                            <label for="editLogDetails" class="form-label">รายละเอียด</label>
                            <textarea class="form-control" id="editLogDetails" name="details" rows="3" placeholder="รายละเอียดบันทึก" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-primary">บันทึกการแก้ไข</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Teacher Comments Modal -->
    <div class="modal fade" id="teacherCommentsModal" tabindex="-1" aria-labelledby="teacherCommentsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('teacher.comment.update') }}" method="POST">
                    @csrf
                    <input type="hidden" id="teacherStudentId" name="student_id" value="">
                    <input type="hidden" id="teacherLogDate" name="log_date" value="">
                    <div class="modal-header">
                        <h5 class="modal-title" id="teacherCommentsModalLabel">ความเห็นจากอาจารย์</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <textarea class="form-control" id="modalTeacherComments" name="teacher_comments" rows="5" {{ auth()->user()->role === 'Teacher' ? '' : 'readonly' }}></textarea>
                    </div>
                    @if(auth()->user()->role === 'Teacher')
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <!-- Mentor Comments Modal -->
    <div class="modal fade" id="mentorCommentsModal" tabindex="-1" aria-labelledby="mentorCommentsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('mentor.comment.update') }}" method="POST">
                    @csrf
                    <input type="hidden" id="mentorStudentId" name="student_id" value="">
                    <input type="hidden" id="mentorLogDate" name="log_date" value="">
                    <div class="modal-header">
                        <h5 class="modal-title" id="mentorCommentsModalLabel">ความเห็นจากพี่เลี้ยง</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <textarea class="form-control" id="modalMentorComments" name="mentor_comments" rows="5" {{ auth()->user()->role === 'Mentor' ? '' : 'readonly' }}></textarea>
                    </div>
                    @if(auth()->user()->role === 'Mentor')
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Populate Teacher Comments Modal
        const teacherCommentsButtons = document.querySelectorAll('.viewTeacherComments');
        teacherCommentsButtons.forEach(button => {
            button.addEventListener('click', function () {
                const comments = JSON.parse(this.getAttribute('data-comments'));
                const studentId = this.getAttribute('data-student-id');
                const logDate = this.getAttribute('data-log-date');
                document.getElementById('modalTeacherComments').value = comments.join('\n');
                document.getElementById('teacherStudentId').value = studentId;
                document.getElementById('teacherLogDate').value = logDate;
            });
        });

        // Populate Mentor Comments Modal
        const mentorCommentsButtons = document.querySelectorAll('.viewMentorComments');
        mentorCommentsButtons.forEach(button => {
            button.addEventListener('click', function () {
                const comments = JSON.parse(this.getAttribute('data-comments'));
                const studentId = this.getAttribute('data-student-id');
                const logDate = this.getAttribute('data-log-date');
                document.getElementById('modalMentorComments').value = comments.join('\n');
                document.getElementById('mentorStudentId').value = studentId;
                document.getElementById('mentorLogDate').value = logDate;
            });
        });

        const logs = @json($logs->toArray());
        const editLogDate = document.getElementById('editLogDate');
        const editLogTitle = document.getElementById('editLogTitle');
        const editLogDetails = document.getElementById('editLogDetails');

        editLogDate.addEventListener('change', function () {
            const selectedDate = this.value;
            const log = logs.find(log => log.log_date === selectedDate);
            if (log) {
                editLogTitle.value = log.log_header;
                editLogDetails.value = log.log_detail;
            }
        });

        // Trigger change event to populate fields for the first option
        editLogDate.dispatchEvent(new Event('change'));
    });
</script>
@endsection
