@extends('layouts.app')

@section('title', 'เลือกสถานที่สังกัด')

@section('activeUsers', 'active border-2 border-bottom border-primary')

@section('content')
    <div class="container">
        <h2 class="mb-4">เลือกสถานที่สังกัด</h2>

        <div class="card border-0 shadow-lg">
            <div class="card-body text-center py-5 px-4">

                @if (session('success'))
                    <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
                @endif

                {{-- กรณีรออนุมัติ --}}
                @if ($confirm && $confirm->req == 2)
                    <h3 class="text-success fw-bold mb-2">คุณได้ทำการขอสิทธิไปแล้ว</h3>

                    <div class="mx-auto my-3"
                        style="width: 60px; height: 3px; background-color: #f39c12; border-radius: 50px;"></div>

                    <p class="fs-5 mb-4">กรุณารอการยืนยันจากผู้ดูแลระบบ
                    </p>
                    {{-- กรณีได้รับการอนุมัติแล้ว --}}
                @elseif ($registeredLocation)
                    <i class="bi bi-check-circle-fill mb-4"
                        style="font-size: 3.5rem; color: #20c997; animation: pop 0.6s ease;"></i>

                    <h3 class="text-success fw-bold mb-2">ลงทะเบียนสำเร็จ</h3>

                    <div class="mx-auto my-3"
                        style="width: 60px; height: 3px; background-color: #20c997; border-radius: 50px;"></div>

                    <p class="fs-5 mb-4">คุณได้ลงทะเบียนกับสถานที่:
                        <span class="fw-semibold text-primary">{{ $registeredLocation->name }} - {{ $registeredLocation->term_year }}</span>
                    </p>

                    <button type="button" class="btn btn-warning btn-lg px-4 py-2 shadow-sm" data-bs-toggle="modal"
                        data-bs-target="#changeLocationModal">
                        <i class="bi bi-arrow-repeat me-2"></i>เปลี่ยนสถานที่ใหม่
                    </button>

                    {{-- Modal เปลี่ยนสถานที่ --}}
                    <div class="modal fade" id="changeLocationModal" tabindex="-1"
                        aria-labelledby="changeLocationModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('confirms.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="changeLocationModalLabel">เลือกสถานที่ใหม่</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <label for="location" class="form-label">สถานที่</label>
                                        <select class="form-select @error('location_id') is-invalid @enderror"
                                            id="location" name="location_id" required>
                                            <option value="">-- กรุณาเลือกสถานที่ --</option>
                                            @foreach ($locations as $location)
                                                @if (is_null($location->mentor_id1) || is_null($location->mentor_id2))
                                                    <option value="{{ $location->id }}">{{ $location->name }} - {{ $location->term_year }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('location_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">ยกเลิก</button>
                                        <button type="submit" class="btn btn-primary">ยืนยันการเปลี่ยนสถานที่</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- กรณียังไม่เคยลงทะเบียน --}}
                @else
                    <form action="{{ route('confirms.store') }}" method="POST" id="registerForm">
                        @csrf
                        <div class="mb-4">
                            <label for="location" class="form-label">สถานที่</label>
                            <select class="form-select @error('location_id') is-invalid @enderror" id="location"
                                name="location_id" required>
                                <option value="">-- กรุณาเลือกสถานที่ --</option>
                                @foreach ($locations as $location)
                                    @if (is_null($location->mentor_id1) || is_null($location->mentor_id2))
                                        <option value="{{ $location->id }}">{{ $location->name }} - {{ $location->term_year }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('location_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">ลงทะเบียน</button>
                    </form>
                @endif

            </div>
        </div>
    </div>
@endsection
