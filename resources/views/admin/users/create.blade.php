@extends('admin.master')

@section('main-content')
<style>
    .usr-page { padding: 30px 24px; background: #f4f7fb; min-height: 100vh; }
    .usr-header { margin-bottom: 24px; }
    .usr-header h2 { margin: 0; font-size: 24px; font-weight: 700; color: #1e293b; letter-spacing: -0.5px; }
    .usr-header p { margin: 4px 0 0; font-size: 14px; color: #64748b; }
    
    .usr-card { background: #fff; border-radius: 16px; box-shadow: 0 2px 20px rgba(0,0,0,0.04); padding: 30px; max-width: 800px; margin: 0 auto; }
    .form-label { font-weight: 600; color: #334155; font-size: 14px; margin-bottom: 6px; }
    .form-control, .form-select { border-radius: 8px; border: 1px solid #cbd5e1; padding: 10px 14px; font-size: 14px; color: #1e293b; transition: all 0.2s; }
    .form-control:focus, .form-select:focus { border-color: #10b981; box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1); }
    
    .btn-submit { background: linear-gradient(135deg, #10b981, #059669); color: #fff; font-weight: 600; border: none; padding: 12px 24px; border-radius: 8px; font-size: 15px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2); transition: all 0.2s; }
    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(16, 185, 129, 0.3); }
    .btn-cancel { background: #f1f5f9; color: #475569; font-weight: 600; border: none; padding: 12px 24px; border-radius: 8px; font-size: 15px; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; transition: all 0.2s; }
    .btn-cancel:hover { background: #e2e8f0; color: #334155; }
    
    .role-box { border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px 18px; margin-bottom: 8px; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: 12px; }
    .role-box:hover { border-color: #cbd5e1; background: #f8fafc; }
    .role-box input[type="checkbox"] { width: 18px; height: 18px; accent-color: #10b981; cursor: pointer; }
    .role-info h6 { margin: 0; font-size: 14px; font-weight: 600; color: #1e293b; }
    .role-info p { margin: 2px 0 0; font-size: 12px; color: #64748b; }
</style>

<div class="usr-page">
    <div class="usr-header">
        <h2>Add Admin / Staff Member</h2>
        <p>সিস্টেমের জন্য নতুন অ্যাডমিন, ম্যানেজার বা স্টাফ মেম্বার তৈরি করুন</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger" style="border-radius:12px; margin-bottom: 24px; max-width: 800px; margin-left: auto; margin-right: auto;">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li><i class="bi bi-exclamation-triangle-fill me-2"></i> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="usr-card">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="row g-4">
                {{-- Name --}}
                <div class="col-md-6">
                    <label for="name" class="form-label">নাম (Full Name) <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="e.g. Elisa Maurer" value="{{ old('name') }}" required>
                </div>

                {{-- Email --}}
                <div class="col-md-6">
                    <label for="email" class="form-label">ইমেইল (Email Address) <span class="text-danger">*</span></label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="e.g. elisa@example.com" value="{{ old('email') }}" required>
                </div>

                {{-- Phone --}}
                <div class="col-md-6">
                    <label for="phone" class="form-label">ফোন নম্বর (Phone Number) <span class="text-danger">*</span></label>
                    <input type="text" name="phone" id="phone" class="form-control" placeholder="e.g. 01712345678" value="{{ old('phone') }}" required>
                </div>

                {{-- Status --}}
                <div class="col-md-6">
                    <label for="status" class="form-label">স্ট্যাটাস (Status) <span class="text-danger">*</span></label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active (সক্রিয়)</option>
                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive (নিষ্ক্রিয়)</option>
                        <option value="suspended" {{ old('status') === 'suspended' ? 'selected' : '' }}>Suspended (স্থগিত/ব্লকড)</option>
                        <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>Pending (অপেক্ষমান)</option>
                    </select>
                </div>

                {{-- Password --}}
                <div class="col-md-6">
                    <label for="password" class="form-label">পাসওয়ার্ড (Password) <span class="text-danger">*</span></label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
                </div>

                {{-- Confirm Password --}}
                <div class="col-md-6">
                    <label for="password_confirmation" class="form-label">পাসওয়ার্ড নিশ্চিত করুন <span class="text-danger">*</span></label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="••••••••" required>
                </div>

                {{-- Roles --}}
                <div class="col-12 mt-4">
                    <h5 class="mb-3" style="font-size:16px; font-weight:700; color:#1e293b;">ভূমিকা বা পদবি নির্ধারণ করুন (Select Roles)</h5>
                    
                    <div class="row g-3">
                        @foreach($roles as $role)
                        <div class="col-md-6">
                            <label class="role-box" for="role_{{ $role->id }}">
                                <input type="checkbox" name="roles[]" value="{{ $role->id }}" id="role_{{ $role->id }}" 
                                    {{ (is_array(old('roles')) && in_array($role->id, old('roles'))) ? 'checked' : '' }}>
                                <div class="role-info">
                                    <h6>{{ $role->name }}</h6>
                                    <p>{{ $role->description }}</p>
                                </div>
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="col-12 mt-5 d-flex gap-3 justify-content-end">
                    <a href="{{ route('admin.users.index') }}" class="btn-cancel">
                        <i class="bi bi-x-lg me-2"></i> বাতিল করুন
                    </a>
                    <button type="submit" class="btn-submit">
                        <i class="bi bi-check-circle me-2"></i> ইউজার তৈরি করুন
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
