@extends('admin.master')

@section('main-content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

.hrm-page {
    padding: 30px 24px;
    background: #f8fafc;
    min-height: 100vh;
    font-family: 'Plus Jakarta Sans', sans-serif;
}

.hrm-back-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: #64748b;
    font-weight: 700;
    font-size: 14px;
    text-decoration: none;
    margin-bottom: 20px;
    transition: color 0.2s;
}

.hrm-back-link:hover { color: #3b82f6; }

.hrm-header {
    margin-bottom: 30px;
}

.hrm-header h1 {
    margin: 0;
    font-size: 26px;
    font-weight: 800;
    color: #0f172a;
    letter-spacing: -0.5px;
}

.hrm-header p {
    margin: 4px 0 0;
    font-size: 14px;
    color: #64748b;
    font-weight: 500;
}

.hrm-form-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 30px;
}

@media(max-width: 1024px) {
    .hrm-form-grid { grid-template-columns: 1fr; }
}

.hrm-card {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
    border: 1px solid rgba(0,0,0,0.04);
    margin-bottom: 30px;
    overflow: hidden;
}

.hrm-card-header {
    padding: 20px 24px;
    border-bottom: 1px solid #f1f5f9;
    background: #fafafb;
}

.hrm-card-title {
    margin: 0;
    font-size: 16px;
    font-weight: 700;
    color: #0f172a;
    display: flex;
    align-items: center;
    gap: 8px;
}

.hrm-card-title i { color: #3b82f6; }

.hrm-card-body {
    padding: 24px;
}

/* ── FORM ELEMENTS ── */
.form-group-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
}

@media(max-width: 600px) {
    .form-group-grid { grid-template-columns: 1fr; }
}

.form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 20px;
}

.form-label {
    font-size: 13px;
    font-weight: 700;
    color: #475569;
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.form-label .required { color: #ef4444; margin-left: 2px; }

.hrm-input {
    background: #ffffff;
    border: 1.5px solid #cbd5e1;
    border-radius: 10px;
    padding: 12px 16px;
    font-size: 14px;
    color: #1e293b;
    font-weight: 500;
    transition: all 0.2s;
    outline: none;
}

.hrm-input:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.hrm-textarea {
    min-height: 100px;
    resize: vertical;
}

/* ── DRAG DROP UPLOAD PREVIEW ── */
.upload-box {
    border: 2px dashed #cbd5e1;
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    background: #f8fafc;
    transition: all 0.2s;
    cursor: pointer;
    position: relative;
    margin-bottom: 20px;
}

.upload-box:hover {
    border-color: #3b82f6;
    background: rgba(59,130,246,0.02);
}

.upload-box i {
    font-size: 32px;
    color: #64748b;
    margin-bottom: 8px;
    display: block;
}

.upload-box span {
    font-size: 13px;
    font-weight: 700;
    color: #475569;
    display: block;
}

.upload-box p {
    font-size: 11px;
    color: #94a3b8;
    margin: 4px 0 0 0;
}

.upload-box input[type="file"] {
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    opacity: 0;
    cursor: pointer;
}

.preview-container {
    margin-top: 10px;
    display: none;
    text-align: center;
}

.preview-container img {
    max-width: 100%;
    max-height: 120px;
    border-radius: 8px;
    object-fit: contain;
    border: 2px solid #e2e8f0;
}

.hrm-btn-submit {
    background: #3b82f6;
    color: #ffffff;
    font-weight: 700;
    font-size: 15px;
    padding: 14px 28px;
    border-radius: 12px;
    border: none;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(59, 130, 246, 0.3);
    transition: all 0.2s;
    width: 100%;
}

.hrm-btn-submit:hover {
    background: #2563eb;
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
}
</style>

<div class="hrm-page">
    <a href="{{ route('admin.hrm.employees.index') }}" class="hrm-back-link">
        <i class="bi bi-arrow-left"></i> Back to Employee Directory
    </a>

    {{-- HEADER --}}
    <div class="hrm-header">
        <h1>Register New Employee</h1>
        <p>Complete basic info, family records, monthly base salaries, and upload verify files.</p>
    </div>

    {{-- Error Block --}}
    @if($errors->any())
        <div class="alert alert-danger" style="border-radius: 12px; margin-bottom: 24px; padding: 16px 20px;">
            <h5 style="margin: 0 0 8px 0; font-weight: 700; font-size: 15px;"><i class="bi bi-exclamation-triangle-fill me-2"></i> Please correct the following errors:</h5>
            <ul style="margin: 0; padding-left: 20px; font-size: 14px; font-weight: 500;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.hrm.employees.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="hrm-form-grid">
            {{-- Left Side: Info cards --}}
            <div>
                {{-- Card 1: Basic Info --}}
                <div class="hrm-card">
                    <div class="hrm-card-header">
                        <h4 class="hrm-card-title"><i class="bi bi-person-badge-fill"></i> Employee Basic Details</h4>
                    </div>
                    <div class="hrm-card-body">
                        <div class="form-group-grid">
                            <div class="form-group">
                                <label class="form-label">Full Name <span class="required">*</span></label>
                                <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter full name..." class="hrm-input" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Phone Number <span class="required">*</span></label>
                                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Enter contact phone..." class="hrm-input" required>
                            </div>
                        </div>

                        <div class="form-group-grid">
                            <div class="form-group">
                                <label class="form-label">NID Number <span class="required">*</span></label>
                                <input type="text" name="nid_number" value="{{ old('nid_number') }}" placeholder="Enter national identification number..." class="hrm-input" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Monthly Base Salary <span class="required">*</span></label>
                                <input type="number" name="salary" value="{{ old('salary') }}" placeholder="Enter base monthly salary (৳)..." class="hrm-input" min="0" required>
                            </div>
                        </div>

                        <div class="form-group-grid">
                            <div class="form-group">
                                <label class="form-label">District</label>
                                <input type="text" name="district" value="{{ old('district') }}" placeholder="e.g. Dhaka" class="hrm-input">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Thana</label>
                                <input type="text" name="thana" value="{{ old('thana') }}" placeholder="e.g. Mirpur" class="hrm-input">
                            </div>
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label">Full Address</label>
                            <textarea name="address" placeholder="Enter complete home address details..." class="hrm-input hrm-textarea">{{ old('address') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Card 2: Family Info --}}
                <div class="hrm-card">
                    <div class="hrm-card-header">
                        <h4 class="hrm-card-title"><i class="bi bi-people-fill"></i> Parent & Family Details</h4>
                    </div>
                    <div class="hrm-card-body">
                        <div class="form-group-grid">
                            <div class="form-group">
                                <label class="form-label">Father's Name</label>
                                <input type="text" name="father_name" value="{{ old('father_name') }}" placeholder="Father's full name..." class="hrm-input">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Father's Phone Number</label>
                                <input type="text" name="father_phone" value="{{ old('father_phone') }}" placeholder="Father's contact number..." class="hrm-input">
                            </div>
                        </div>

                        <div class="form-group-grid">
                            <div class="form-group">
                                <label class="form-label">Mother's Name</label>
                                <input type="text" name="mother_name" value="{{ old('mother_name') }}" placeholder="Mother's full name..." class="hrm-input">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Mother's Phone Number</label>
                                <input type="text" name="mother_phone" value="{{ old('mother_phone') }}" placeholder="Mother's contact number..." class="hrm-input">
                            </div>
                        </div>

                        <div class="form-group-grid" style="grid-template-columns: 1fr; margin-bottom: 0;">
                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="form-label">Mother's NID Number</label>
                                <input type="text" name="mother_nid_number" value="{{ old('mother_nid_number') }}" placeholder="Mother's national identification number..." class="hrm-input">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Side: Uploads & Submit --}}
            <div>
                {{-- Card 3: Photo Uploader --}}
                <div class="hrm-card">
                    <div class="hrm-card-header">
                        <h4 class="hrm-card-title"><i class="bi bi-camera-fill"></i> Employee Photo</h4>
                    </div>
                    <div class="hrm-card-body" style="text-align: center;">
                        <div class="upload-box">
                            <i class="bi bi-cloud-upload"></i>
                            <span>Upload Employee Photo</span>
                            <p>JPEG, PNG up to 2MB</p>
                            <input type="file" name="employee_image" class="file-input-preview">
                        </div>
                        <div class="preview-container">
                            <img src="" alt="Employee Preview">
                        </div>
                    </div>
                </div>

                {{-- Card 4: Documents Upload --}}
                <div class="hrm-card">
                    <div class="hrm-card-header">
                        <h4 class="hrm-card-title"><i class="bi bi-file-earmark-pdf-fill"></i> Verify Documents</h4>
                    </div>
                    <div class="hrm-card-body">
                        {{-- Emp NID --}}
                        <div style="margin-bottom: 20px;">
                            <label class="form-label" style="font-size: 11px;">Employee NID Copy</label>
                            <div class="upload-box" style="padding: 14px;">
                                <i class="bi bi-file-earmark-image" style="font-size: 24px;"></i>
                                <span>Employee NID Image</span>
                                <input type="file" name="nid_image" class="file-input-preview">
                            </div>
                            <div class="preview-container">
                                <img src="" alt="NID Preview">
                            </div>
                        </div>

                        {{-- Father NID --}}
                        <div style="margin-bottom: 20px;">
                            <label class="form-label" style="font-size: 11px;">Father's NID Copy</label>
                            <div class="upload-box" style="padding: 14px;">
                                <i class="bi bi-file-earmark-image" style="font-size: 24px;"></i>
                                <span>Father NID Image</span>
                                <input type="file" name="father_nid_image" class="file-input-preview">
                            </div>
                            <div class="preview-container">
                                <img src="" alt="Father NID Preview">
                            </div>
                        </div>

                        {{-- Mother NID --}}
                        <div style="margin-bottom: 20px;">
                            <label class="form-label" style="font-size: 11px;">Mother's NID Copy</label>
                            <div class="upload-box" style="padding: 14px;">
                                <i class="bi bi-file-earmark-image" style="font-size: 24px;"></i>
                                <span>Mother NID Image</span>
                                <input type="file" name="mother_nid_image" class="file-input-preview">
                            </div>
                            <div class="preview-container">
                                <img src="" alt="Mother NID Preview">
                            </div>
                        </div>

                        {{-- Joint Picture --}}
                        <div style="margin-bottom: 0;">
                            <label class="form-label" style="font-size: 11px;">Parents Joint Photo</label>
                            <div class="upload-box" style="padding: 14px;">
                                <i class="bi bi-file-earmark-image" style="font-size: 24px;"></i>
                                <span>Father & Mother Together</span>
                                <input type="file" name="parents_image" class="file-input-preview">
                            </div>
                            <div class="preview-container">
                                <img src="" alt="Joint Preview">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="hrm-btn-submit">
                    <i class="bi bi-check2-circle me-1"></i> Register Employee
                </button>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Dynamic image preview updates
    const fileInputs = document.querySelectorAll(".file-input-preview");
    
    fileInputs.forEach(input => {
        input.addEventListener("change", function() {
            const file = this.files[0];
            const uploadBox = this.parentElement;
            const previewContainer = uploadBox.nextElementSibling;
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewContainer.querySelector("img").src = e.target.result;
                    previewContainer.style.display = "block";
                    uploadBox.style.display = "none";
                }
                reader.readAsDataURL(file);
            }
        });
    });
});
</script>
@endsection
