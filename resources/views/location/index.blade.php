@extends('layouts.app')

    @section('title')
        Subject
    @endsection

    @section('activeUsers')
        active border-2 border-bottom border-primary
    @endsection

    @section('content')
        <div class="container py-4">
        
                <!-- Search Bar -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <form action="{{ route('location.index') }}" method="GET" class="d-flex" id="filterForm">
                        <input type="text" name="search" class="form-control me-2" style="width: 300px;" placeholder="ค้นหาสถานที่ฝึกงานหรือภาคการศึกษา" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> ค้นหา
                        </button>
                    </form>
                    <div class="d-flex gap-2 justify-content-end">

                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelAdvisorModal">
                            <i class="fas fa-user-times me-1"></i> ยกเลิกลงทะเบียนอาจารย์นิเทศก์
                        </button>

                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#registerAdvisorModal">
                            <i class="fas fa-user-plus me-1"></i> ลงทะเบียนอาจารย์นิเทศก์
                        </button>

                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addLocationModal">
                            <i class="fas fa-plus-circle me-1"></i> เพิ่มรายการฝึกงาน
                        </button>
                    </div>
                </div>
            

            <div class="row">
                @foreach ($locations as $location)
                    @if (empty(request('search')) || stripos($location->name . ' ' . $location->term_year, request('search')) !== false)
                    <div class="col-md-4 mb-4">
                        <div class="card border-0 shadow-lg h-100 hover-shadow" style="transition: box-shadow 0.4s ease;">
                            <div class="card-body">
                                <!-- ชื่อสถานที่ -->
                                <h3 class="card-title mb-3 text-primary">
                                    <i class="fas fa-map-marker-alt me-2"></i>{{ $location->name }} {{ $location->term_year }}
                                </h3>
                                <hr>
                                <!-- รายชื่อนักศึกษาฝึกงาน -->
                                <h6 class="text-muted mb-2">รายชื่อนักศึกษาฝึกงาน</h6>
                                <ul class="list-group list-group-flush mb-3">
                                    @foreach (['student_id1', 'student_id2', 'student_id3', 'student_id4'] as $studentId)
                                        <li class="list-group-item d-flex align-items-center py-1">
                                            @if ($location->$studentId)
                                                <i class="fa-solid fa-graduation-cap me-2"></i>
                                                <span class="small">
                                                    {{ $location->$studentId }}
                                                    @if (!empty($students[$location->$studentId]->name))
                                                        - {{ $students[$location->$studentId]->name }}
                                                    @endif
                                                </span>
                                            @else
                                                <i class="fa-solid fa-minus me-2 text-muted"></i>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>

                                <!-- รายชื่อพี่เลี้ยง -->
                                <h6 class="text-muted mb-2">รายชื่อพี่เลี้ยง</h6>
                                <ul class="list-group list-group-flush mb-3">
                                    @foreach (['mentor_id1', 'mentor_id2'] as $mentorId)
                                        <li class="list-group-item d-flex align-items-center py-1">
                                            @if ($location->$mentorId && !empty($mentors[$location->$mentorId]->name))
                                                <i class="fa-solid fa-user-tie me-2"></i>
                                                <span class="small">{{ $mentors[$location->$mentorId]->name }}</span>
                                            @else
                                                <i class="fa-solid fa-minus me-2 text-muted"></i>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>

                                <!-- รายชื่อที่ปรึกษา -->
                                <h6 class="text-muted mb-2">รายชื่ออาจารย์นิเทศก์</h6>
                                <ul class="list-group list-group-flush mb-0">
                                    <li class="list-group-item d-flex align-items-center py-1">
                                        @if ($location->teacher_id && !empty($teachers[$location->teacher_id]->name))
                                            <i class="fa-solid fa-chalkboard-teacher me-2"></i>
                                            <span class="small">{{ $teachers[$location->teacher_id]->name }}</span>
                                        @else
                                            <i class="fa-solid fa-minus me-2 text-muted"></i>
                                        @endif
                                    </li>
                                </ul>

                            </div>

                            <!-- ปุ่มแก้ไขการฝึกงาน -->
                            <div class="card-footer text-end border-top bg-light-mode">
                                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editLocationModal-{{ $location->id }}">
                                    <i class="fas fa-edit me-1"></i> แก้ไขการฝึกงาน
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach

                <!-- Modal แก้ไขรายการฝึกงาน -->
                @foreach ($locations as $location)
                <div class="modal fade" id="editLocationModal-{{ $location->id }}" tabindex="-1" aria-labelledby="editLocationModalLabel-{{ $location->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <form action="{{ route('location.update', $location->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="editLocationModalLabel-{{ $location->id }}">แก้ไขการฝึกงาน</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <!-- ชื่อสถานประกอบการ -->
                                    <div class="mb-3">
                                        <label for="name" class="form-label">ชื่อสถานประกอบการ</label>
                                        <input type="text" class="form-control" name="name" value="{{ $location->name }}" required>
                                    </div>

                                    <!-- ภาคการศึกษา -->
                                    <div class="mb-3">
                                        <label for="term_year" class="form-label">ภาคการศึกษา</label>
                                        <input type="text" class="form-control" name="term_year" value="{{ $location->term_year }}" required>
                                    </div>

                                    <!-- รหัสนักศึกษา -->
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="student_id1" class="form-label">รหัสนักศึกษาคนที่ 1</label>
                                            <input type="text" class="form-control" name="student_id1" value="{{ $location->student_id1 }}" maxlength="10">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="student_id2" class="form-label">รหัสนักศึกษาคนที่ 2</label>
                                            <input type="text" class="form-control" name="student_id2" value="{{ $location->student_id2 }}" maxlength="10">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="student_id3" class="form-label">รหัสนักศึกษาคนที่ 3</label>
                                            <input type="text" class="form-control" name="student_id3" value="{{ $location->student_id3 }}" maxlength="10">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="student_id4" class="form-label">รหัสนักศึกษาคนที่ 4</label>
                                            <input type="text" class="form-control" name="student_id4" value="{{ $location->student_id4 }}" maxlength="10">
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer bg-light-mode">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                    <button type="submit" class="btn btn-primary">บันทึกการเปลี่ยนแปลง</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach

        <!-- Modal เพิ่มรายการฝึกงาน -->
        <div class="modal fade" id="addLocationModal" tabindex="-1" aria-labelledby="addLocationModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('location.store') }}" method="POST">
                        @csrf
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="addLocationModalLabel">เพิ่มรายการฝึกงาน</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <!-- ชื่อสถานที่ฝึกงาน -->
                            <div class="mb-3">
                                <label for="name" class="form-label">ชื่อสถานประกอบการ</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>

                            <!-- ภาคการศึกษา -->
                            <div class="mb-3">
                                <label for="term_year" class="form-label">ภาคการศึกษา</label>
                                <input type="text" class="form-control" name="term_year" required>
                            </div>

                            <!-- รหัสนักศึกษา -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="student_id1" class="form-label">รหัสนักศึกษาคนที่ 1</label>
                                    <input type="text" class="form-control" name="student_id1" maxlength="10">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="student_id2" class="form-label">รหัสนักศึกษาคนที่ 2</label>
                                    <input type="text" class="form-control" name="student_id2" maxlength="10">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="student_id3" class="form-label">รหัสนักศึกษาคนที่ 3</label>
                                    <input type="text" class="form-control" name="student_id3" maxlength="10">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="student_id4" class="form-label">รหัสนักศึกษาคนที่ 4</label>
                                    <input type="text" class="form-control" name="student_id4" maxlength="10">
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer bg-light-mode">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal ลงทะเบียนอาจารย์นิเทศก์ -->
        <div class="modal fade" id="registerAdvisorModal" tabindex="-1" aria-labelledby="registerAdvisorModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('location.registerAdvisor') }}" method="POST">
                        @csrf
                        <div class="modal-header bg-warning text-black">
                            <h5 class="modal-title" id="registerAdvisorModalLabel">ลงทะเบียนอาจารย์นิเทศก์</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <!-- เลือกสถานประกอบการ -->
                            <div class="mb-3">
                                <label for="location_id" class="form-label">เลือกสถานประกอบการ</label>
                                <select class="form-select" name="location_id" required>
                                    <option value="" disabled selected>กรุณาเลือกสถานประกอบการ</option>
                        @foreach ($locations as $location)
                            @if (empty($location->teacher_id))
                                <option value="{{ $location->id }}">{{ $location->name }} - {{ $location->term_year }}</option>
                            @endif
                        @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer bg-light-mode">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-warning">ลงทะเบียน</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal ยกเลิกลงทะเบียนอาจารย์นิเทศก์ -->
        <div class="modal fade" id="cancelAdvisorModal" tabindex="-1" aria-labelledby="cancelAdvisorModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <form id="cancelAdvisorForm" action="{{ route('location.cancelAdvisor') }}" method="POST">
                        @csrf
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title" id="cancelAdvisorModalLabel">ยกเลิกลงทะเบียนอาจารย์นิเทศก์</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="location_id_cancel" class="form-label">เลือกสถานประกอบการที่ต้องการ</label>
                                <select class="form-select" id="location_id_cancel" name="location_id" required>
                                    <option value="" disabled selected>กรุณาเลือกสถานประกอบการ</option>
                                    @foreach ($locations as $location)
                                        @if ($location->teacher_id == auth()->user()->id)
                                            <option value="{{ $location->id }}">{{ $location->name }} - {{ $location->term_year }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-danger">ยืนยัน</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                const confirmBtn = document.getElementById('confirmCancelAdvisorBtn');
                                const form = document.getElementById('cancelAdvisorForm');
                                confirmBtn.addEventListener('click', function () {
                                    form.submit();
                                });
                            });
                        </script>
                </div>
            </div>
        </div>

        @if (session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'สำเร็จ!',
                        text: '{{ session('success') }}',
                        icon: 'success',
                        confirmButtonText: 'ตกลง'
                    });
                });
            </script>
        @endif
    @endsection

    <style>
        .hover-shadow:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease-in-out;
        }

        .bg-light-mode {
            background-color: var(--bs-light);
        }

        .bg-light-mode[data-theme="dark"] {
            background-color: var(--bs-dark);
        }
        </style>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const root = document.documentElement;
                const theme = localStorage.getItem('theme') || 'light';
                root.setAttribute('data-theme', theme);

                // Update theme dynamically if toggled
                document.querySelectorAll('[data-theme-toggle]').forEach(toggle => {
                    toggle.addEventListener('click', function ()
                    const newTheme = root.getAttribute('data-theme') === 'light' ? 'dark' : 'light';
                    root.setAttribute('data-theme', newTheme);
                    localStorage.setItem('theme', newTheme);
                });
            });
        });
    </script>
