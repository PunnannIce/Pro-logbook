@extends('layouts.app')

@section('title')
    Profile
@endsection

@section('activeUsers')
    active border-2 border-bottom border-primary
@endsection

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm p-4">
            <div class="row">
                <!-- Profile Picture -->
                <div class="col-md-3 text-center">
                    @php
                        $imagePathJpg = public_path('student_images/' . $user->student_id . '.jpg');
                        $imagePathPng = public_path('student_images/' . $user->student_id . '.png');
                        $imageExists = file_exists($imagePathJpg) || file_exists($imagePathPng);
                    @endphp

                    @if ($imageExists)
                        <img src="{{ file_exists($imagePathJpg) 
                            ? asset('student_images/' . $user->student_id . '.jpg') 
                            : asset('student_images/' . $user->student_id . '.png') }}" 
                            class="img-fluid mb-3 toggle-upload" alt="User Profile" style="width: 2in; height: auto; max-height: 2in; cursor: pointer;">
                    @else
                        <div class="text-muted toggle-upload" style="cursor: pointer;">
                            <p class="text-center">คลิกเพื่ออัพโหลดรูปภาพ</p>
                        </div>
                    @endif

                    <h5 class="mt-2 fw-bold">{{ $user->name }}</h5>
                    <p class="text-muted">รหัสนักศึกษา: <strong>{{ $user->student_id }}</strong></p>
                    <form action="{{ route('student.uploadImage') }}" method="POST" enctype="multipart/form-data" id="upload-form" style="display: none;">
                        @csrf
                        <div class="mb-3">
                            <input type="file" name="profile_image" class="form-control" accept=".png, .jpg" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">อัพโหลดรูปภาพ</button>
                    </form>
                </div>
                
                <!-- Main Info -->
                <div class="col-md-9">
                    <h4 class="fw-bold">ข้อมูลนักศึกษา</h4>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <p><strong>ชื่อ-นามสกุล:</strong> {{ $user->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>รหัสนักศึกษา:</strong> {{ $user->student_id }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>ชั้นปี:</strong> {{ $user->year }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>สาขาวิชา:</strong> {{ $user->branch }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>เบอร์โทร:</strong> {{ $user->phone_number }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>อีเมล:</strong> {{ $user->email }}</p>
                        </div>
                    </div>
                    <hr>
                    <h5 class="fw-bold">ข้อมูลส่วนตัว</h5>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <p><strong>ชื่อภาษาอังกฤษ:</strong> {{ $student_infos->where('student_id', $user->student_id)->first()->name_eng ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>วันเกิด:</strong> 
                                @php
                                    $studentInfo = $student_infos->where('student_id', $user->student_id)->first();
                                @endphp
                                {{ isset($studentInfo) && $studentInfo->birthday 
                                    ? \Carbon\Carbon::parse($studentInfo->birthday)->format('d/m/Y') 
                                    : '-' }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>อายุ:</strong> {{ $student_infos->where('student_id', $user->student_id)->first()->age ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>ศาสนา:</strong> {{ $student_infos->where('student_id', $user->student_id)->first()->religion ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>ระดับ:</strong> {{ $student_infos->where('student_id', $user->student_id)->first()->degree_level ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>ภาค:</strong> {{ $student_infos->where('student_id', $user->student_id)->first()->sector ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>หมู่เรียนที่:</strong> {{ $student_infos->where('student_id', $user->student_id)->first()->group ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>ภาคการศึกษา:</strong> {{ $student_infos->where('student_id', $user->student_id)->first()->term_year ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>ปีการศึกษา:</strong> {{ $student_infos->where('student_id', $user->student_id)->first()->year ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>ชื่อบิดา:</strong> {{ $student_infos->where('student_id', $user->student_id)->first()->father_name ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>อาชีพของบิดา:</strong> {{ $student_infos->where('student_id', $user->student_id)->first()->father_career ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>ชื่อมารดา:</strong> {{ $student_infos->where('student_id', $user->student_id)->first()->mother_name ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>อาชีพของมารดา:</strong> {{ $student_infos->where('student_id', $user->student_id)->first()->mother_career ?? '-' }}</p>
                        </div>
                        <div class="row">
                            <p><strong>ที่อยู่ตามภูมิลำเนา:</strong>
                                @if (isset($student_infos) && $user->student_id)
                                บ้านเลขที่ {{ $student_infos->where('student_id', $user->student_id)->first()->old_house_no ?? '-' }} หมู่
                                    {{ $student_infos->where('student_id', $user->student_id)->first()->old_moo ?? '-' }} ซอย
                                    {{ $student_infos->where('student_id', $user->student_id)->first()->old_soi ?? '-' }}  ถนน
                                    {{ $student_infos->where('student_id', $user->student_id)->first()->old_road ?? '-' }} ตำบล
                                    {{ $student_infos->where('student_id', $user->student_id)->first()->old_subdistrict ?? '-' }} อำเภอ
                                    {{ $student_infos->where('student_id', $user->student_id)->first()->old_district ?? '-' }} จังหวัด
                                    {{ $student_infos->where('student_id', $user->student_id)->first()->old_province ?? '-' }} รหัสไปรษณีย์
                                    {{ $student_infos->where('student_id', $user->student_id)->first()->old_zip_code ?? '-' }}
                                @endif
                            </p>
                        </div>
                        <div class="row">
                            <p><strong>ที่อยู่ปัจจุบัน:</strong>
                                @if (isset($student_infos) && $user->student_id)
                                บ้านเลขที่ {{ $student_infos->where('student_id', $user->student_id)->first()->now_house_no ?? '-' }} หมู่
                                    {{ $student_infos->where('student_id', $user->student_id)->first()->now_moo ?? '-' }} ซอย
                                    {{ $student_infos->where('student_id', $user->student_id)->first()->now_soi ?? '-' }}  ถนน
                                    {{ $student_infos->where('student_id', $user->student_id)->first()->now_road ?? '-' }} ตำบล
                                    {{ $student_infos->where('student_id', $user->student_id)->first()->now_subdistrict ?? '-' }} อำเภอ
                                    {{ $student_infos->where('student_id', $user->student_id)->first()->now_district ?? '-' }} จังหวัด
                                    {{ $student_infos->where('student_id', $user->student_id)->first()->now_province ?? '-' }} รหัสไปรษณีย์
                                    {{ $student_infos->where('student_id', $user->student_id)->first()->now_zip_code ?? '-' }}
                                @endif
                            </p>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>ประสบการณ์การทำงาน:</strong> {{ $student_infos->where('student_id', $user->student_id)->first()->work_experience ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>ความรู้ความสามารถพิเศษ:</strong> {{ $student_infos->where('student_id', $user->student_id)->first()->talent ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>ความสนใจพิเศษ:</strong> {{ $student_infos->where('student_id', $user->student_id)->first()->special_interests ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>สถานภาพ:</strong> {{ $student_infos->where('student_id', $user->student_id)->first()->marital_status ?? '-' }}</p>
                            </div>
                            @if (!in_array($student_infos->where('student_id', $user->student_id)->first()->marital_status ?? '', ['โสด', 'หย่าร้าง']))
                                <div class="col-md-6">
                                    <p><strong>ชื่อสามี/ภรรยา:</strong> {{ $student_infos->where('student_id', $user->student_id)->first()->spouse_name ?? '-' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>อาชีพ:</strong> {{ $student_infos->where('student_id', $user->student_id)->first()->spouse_job ?? '-' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>จำนวนบุตร:</strong> {{ $student_infos->where('student_id', $user->student_id)->first()->childern_count ?? '-' }} คน</p>
                                </div>
                                <div class="col-md-6">
                                <p></p>
                            </div>
                            @endif
                            <div class="col-md-6">
                                <p></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>ชื่อบุคคลที่ติดต่อได้:</strong> {{ $student_infos->where('student_id', $user->student_id)->first()->emg_name ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p></p>
                            </div>  
                            <div class="col-md-6">
                                <p><strong>ที่อยู่:</strong> {{ $student_infos->where('student_id', $user->student_id)->first()->emg_address ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p> </p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>เบอร์โทร:</strong> {{ $student_infos->where('student_id', $user->student_id)->first()->emg_phone ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-end mt-3">
                    <a href="{{-- route('student.editProfile', ['id' => $user->student_id]) --}}" class="btn btn-outline-primary">แก้ไขข้อมูลส่วนตัว</a>
                </div>
            </div>
        </div>

        <!-- Internship Information -->
        <div class="col-md-12 mt-4">
            <div class="card shadow-sm p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="fw-bold">ข้อมูลสถานที่ฝึกงาน</h4>
                    <a href="{{-- route('location_infos.editProfile', ['id' => $user->student_id]) --}}" class="btn btn-outline-primary">แก้ไขข้อมูลสถานที่ฝึกงาน</a>
                </div>
                <div class="row mt-3">
                    @php
                        $locations = $locations ?? collect();
                        $location_infos = $location_infos ?? collect(); // Ensure $location_infos is defined

                        $filteredLocation = $locations->map(function ($location) use ($location_infos) {
                            $matchingInfo = $location_infos->firstWhere('id', $location->id); // Match using 'id'
                            return [
                                'id' => $location->id,
                                'name' => $location->name,
                                'term_year' => $location->term_year,
                                'loc_detail' => $matchingInfo->loc_detail ?? null,
                                'loc_house_no' => $matchingInfo->loc_house_no ?? null,
                                'loc_moo' => $matchingInfo->loc_moo ?? null,
                                'loc_soi' => $matchingInfo->loc_soi ?? null,
                                'loc_road' => $matchingInfo->loc_road ?? null,
                                'loc_subdistrict' => $matchingInfo->loc_subdistrict ?? null,
                                'loc_district' => $matchingInfo->loc_district ?? null,
                                'loc_province' => $matchingInfo->loc_province ?? null,
                                'loc_zip_code' => $matchingInfo->loc_zip_code ?? null,
                                'loc_phone_number' => $matchingInfo->loc_phone_number ?? null,
                                'student_ids' => [
                                    $location->student_id1,
                                    $location->student_id2,
                                    $location->student_id3,
                                    $location->student_id4
                                ]
                            ];
                        })->filter(function ($location) use ($user) {
                            return in_array($user->student_id, $location['student_ids']);
                        })->reduce(function ($carry, $item) {
                            return array_merge($carry, array_filter($item, fn($value) => $value !== null));
                        }, []);
                    @endphp
                    <div class="col-md-12">
                        <p><strong>สถานที่ฝึกงาน:</strong> {{ $filteredLocation['name'] ?? '-' }}</p>
                    </div>
                    <div class="col-md-12">
                        <p><strong>ภาคการศึกษา:</strong> {{ $filteredLocation['term_year'] ?? '-' }}</p>
                    </div>
                    <div class="col-md-12">
                        <p><strong>ข้อมูลสถานที่ฝึกงาน:</strong> {{ $filteredLocation['loc_detail'] ?? '-' }}</p>
                    </div>
                    <div class="col-md-12">
                        <p><strong>ที่อยู่:</strong>
                            @if (!empty($filteredLocation))
                                {{ $filteredLocation['loc_house_no'] ?? '-' }} หมู่
                                {{ $filteredLocation['loc_moo'] ?? '-' }} ซอย
                                {{ $filteredLocation['loc_soi'] ?? '-' }} ถนน
                                {{ $filteredLocation['loc_road'] ?? '-' }} ตำบล
                                {{ $filteredLocation['loc_subdistrict'] ?? '-' }} อำเภอ
                                {{ $filteredLocation['loc_district'] ?? '-' }} จังหวัด
                                {{ $filteredLocation['loc_province'] ?? '-' }} รหัสไปรษณีย์
                                {{ $filteredLocation['loc_zip_code'] ?? '-' }}
                            @else
                                -
                            @endif
                        </p>
                    </div>
                    <div class="col-md-12">
                        <p><strong>เบอร์โทร/แฟกซ์:</strong> {{ $filteredLocation['loc_phone_number'] ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleElements = document.querySelectorAll('.toggle-upload');
            const uploadForm = document.getElementById('upload-form');

            toggleElements.forEach(element => {
                element.addEventListener('click', function () {
                    uploadForm.style.display = uploadForm.style.display === 'none' ? 'block' : 'none';
                });
            });
        });
    </script>
@endsection
