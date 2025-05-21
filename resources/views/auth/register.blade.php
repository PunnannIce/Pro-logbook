@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <div class="container-sm py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>{{ __('Register') }}</h4>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="prefix" class="col-md-2 col-form-label text-md-end">{{ __('คำนำหน้า') }}</label>
                                <div class="col-md-10">
                                    <select name="prefix" id="prefix"
                                        class="form-select @error('prefix') is-invalid @enderror @if (old('prefix')) is-valid @endif">
                                        <option value="" selected disabled>{{ __('เลือกคำนำหน้า') }}</option>
                                        @foreach (['นาย', 'นาง', 'นางสาว', 'อาจารย์'] as $item)
                                            <option value="{{ $item }}" {{ old('prefix') == $item ? 'selected' : '' }}>
                                                {{ $item }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('prefix')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-floating mb-3">
                                <input id="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror @if (old('name')) is-valid @endif"
                                    name="name" value="{{ old('prefix') . ' ' . old('name') }}" autocomplete="name" autofocus
                                    placeholder="ชื่อ นามสกุล">
                                <label for="name">{{ __('ชื่อ-นามสกุล') }}</label>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-floating mb-3">
                                <input id="student_id" type="text"
                                    class="form-control @error('student_id') is-invalid @enderror @if (old('student_id')) is-valid @endif"
                                    name="student_id" value="{{ old('student_id') }}" autocomplete="student_id"
                                    placeholder="รหัสผู้ใช้งาน">
                                <label for="student_id">{{ __('รหัสผู้ใช้งาน') }}</label>
                                @error('student_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <small class="form-text text-muted">
                                    {{ __('Note: สำหรับนักศึกษาให้ใส่เป็นรหัสนักศึกษา ส่วนพี่เลี้ยงนั้นตามที่สถานประกอบการจะกำหนด') }}
                                </small>
                            </div>

                            <div class="row mb-3">
                                <label for="branch" class="col-md-2 col-form-label text-md-end">{{ __('สาขา') }}</label>
                                <div class="col-md-10">
                                    <select name="branch"
                                        class="form-select @error('branch') is-invalid @enderror @if (old('branch')) is-valid @endif">
                                        <option value="" selected disabled>{{ __('เลือกสาขา') }}</option>
                                        @foreach (['-','วิทยาการคอมพิวเตอร์', 'วิศวกรรมคอมพิวเตอร์', 'เทคโนโลยีสารสนเทศ', 'ภูมิสารสนเทศ'] as $item)
                                            <option value="{{ $item }}" {{ old('branch') == $item ? 'selected' : '' }}>
                                                {{ $item }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('branch')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="year" class="col-md-2 col-form-label text-md-end">{{ __('ชั้นปี') }}</label>
                                <div class="col-md-10">
                                    <select name="year"
                                        class="form-select @error('year') is-invalid @enderror @if (old('year')) is-valid @endif">
                                        <option value="" selected disabled>{{ __('เลือกชั้นปี') }}</option>
                                        @foreach (['-','1', '2', '3', '4', '5'] as $item)
                                            <option value="{{ $item }}" {{ old('year') == $item ? 'selected' : '' }}>
                                                {{ $item }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('year')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="role" class="col-md-2 col-form-label text-md-end">{{ __('บทบาท') }}</label>
                                <div class="col-md-10">
                                    <select name="role" id="role"
                                        class="form-select @error('role') is-invalid @enderror @if (old('role')) is-valid @endif">
                                        <option value="Student" {{ old('role') == 'Student' ? 'selected' : '' }}>{{ __('Student') }}</option>
                                        <option value="Mentor" {{ old('role') == 'Mentor' ? 'selected' : '' }}>{{ __('Mentor') }}</option>
                                        <option value="Teacher" {{ old('role') == 'Teacher' ? 'selected' : '' }}>{{ __('Teacher') }}</option>
                                    </select>
                                    @error('role')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <small class="form-text text-muted">
                                        {{ __('Note: บทบาทอาจารย์และพี่เลี้ยงนั้นจะมีการตรวจสอบจากผู้ดูแล.') }}
                                    </small>
                                </div>
                            </div>

                            <div class="form-floating mb-3">
                                <input id="phone_number" type="text"
                                    class="form-control @error('phone_number') is-invalid @enderror @if (old('phone_number')) is-valid @endif"
                                    name="phone_number" value="{{ old('phone_number') }}" autocomplete="phone_number"
                                    placeholder="เบอร์โทร">
                                <label for="phone_number">{{ __('เบอร์โทร') }}</label>
                                @error('phone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-floating mb-3">
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror @if (old('email')) is-valid @endif"
                                    name="email" value="{{ old('email') }}" autocomplete="email"
                                    placeholder="อีเมล">
                                <label for="email">{{ __('อีเมล') }}</label>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <small class="form-text text-muted">
                                    {{ __('Note: สำหรับนักศึกษาแนะนำให้ใช้ E-mail ของมหาวิทยาลัย') }}
                                </small>
                            </div>

                            <div class="form-floating mb-3">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    autocomplete="new-password" placeholder="รหัสผ่าน">
                                <label for="password">{{ __('รหัสผ่าน') }}</label>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-floating mb-3">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" autocomplete="new-password"
                                    placeholder="ยืนยันรหัสผ่าน">
                                <label for="password-confirm">{{ __('ยืนยันรหัสผ่าน') }}</label>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
