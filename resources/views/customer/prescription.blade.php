@extends('layouts.customer')

@section('title', 'My Prescriptions')
@section('page_title')
<i class="fas fa-file-prescription"></i> {{ __('messages.footer_prescription') ?? 'Prescriptions' }}
@endsection

@section('styles')
<style>
    /* Header Banner */
    .rx-header-banner {
        background: linear-gradient(135deg, var(--dark-green) 0%, var(--primary-green) 60%, var(--light-green) 100%);
        border-radius: 18px;
        padding: 30px 35px;
        margin-bottom: 25px;
        color: var(--white);
        position: relative;
        overflow: hidden;
    }

    .rx-header-banner::before {
        content: '';
        position: absolute;
        top: -100px;
        right: -100px;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, transparent 70%);
        border-radius: 50%;
    }

    .rx-header-banner::after {
        content: '\f572';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        right: 40px;
        bottom: -30px;
        font-size: 10rem;
        opacity: 0.08;
    }

    .rx-header-content {
        position: relative;
        z-index: 2;
    }

    .rx-header-content h3 {
        font-size: 1.8rem;
        font-weight: 800;
        margin: 0 0 8px;
    }

    .rx-header-content p {
        opacity: 0.9;
        font-size: 0.95rem;
        margin: 0 0 15px;
        max-width: 600px;
        line-height: 1.6;
    }

    .rx-steps {
        display: flex;
        gap: 25px;
        flex-wrap: wrap;
    }

    .rx-step {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .rx-step .step-num-rx {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.85rem;
    }

    .rx-step span {
        font-size: 0.85rem;
        font-weight: 500;
    }

    /* Upload Card */
    .upload-card {
        background: var(--white);
        border-radius: 18px;
        box-shadow: var(--shadow);
        overflow: hidden;
        margin-bottom: 25px;
    }

    .upload-card-header {
        padding: 18px 25px;
        background: var(--off-white);
        border-bottom: 1px solid #E0E0E0;
    }

    .upload-card-header h5 {
        margin: 0;
        font-weight: 700;
        color: var(--dark-text);
        font-size: 1.1rem;
    }

    .upload-card-header h5 i {
        color: var(--primary-green);
        margin-right: 8px;
    }

    .upload-card-body {
        padding: 30px 25px;
    }

    /* Drag & Drop Zone */
    .drop-zone {
        border: 3px dashed var(--mint-green);
        border-radius: 20px;
        padding: 50px 30px;
        text-align: center;
        cursor: pointer;
        transition: var(--transition);
        background: linear-gradient(135deg, var(--pale-green), var(--off-white));
        position: relative;
    }

    .drop-zone:hover,
    .drop-zone.drag-over {
        border-color: var(--primary-green);
        background: linear-gradient(135deg, var(--mint-green), var(--pale-green));
        transform: scale(1.01);
    }

    .drop-zone.drag-over {
        box-shadow: 0 0 0 4px rgba(46, 125, 50, 0.15);
    }

    .drop-zone .dz-icon {
        font-size: 4rem;
        color: var(--primary-green);
        margin-bottom: 15px;
        display: block;
    }

    .drop-zone h5 {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--dark-text);
        margin-bottom: 8px;
    }

    .drop-zone p {
        color: var(--gray-text);
        font-size: 0.9rem;
        margin-bottom: 15px;
    }

    .drop-zone .dz-formats {
        display: flex;
        justify-content: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .drop-zone .dz-format {
        background: var(--white);
        padding: 5px 12px;
        border-radius: 15px;
        font-size: 0.72rem;
        font-weight: 600;
        color: var(--primary-green);
        border: 1px solid var(--mint-green);
    }

    /* File Preview */
    .file-preview-area {
        display: none;
        margin-top: 20px;
    }

    .file-preview-area.show {
        display: block;
    }

    .file-preview-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px;
        background: var(--off-white);
        border-radius: 12px;
        margin-bottom: 10px;
        border: 2px solid var(--mint-green);
    }

    .file-preview-item .fp-thumb {
        width: 70px;
        height: 70px;
        border-radius: 10px;
        background: var(--white);
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .file-preview-item .fp-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .file-preview-item .fp-thumb i {
        font-size: 2rem;
        color: #E53935;
    }

    .file-preview-item .fp-info {
        flex: 1;
    }

    .file-preview-item .fp-info strong {
        display: block;
        font-size: 0.9rem;
        color: var(--dark-text);
        font-weight: 700;
    }

    .file-preview-item .fp-info span {
        font-size: 0.78rem;
        color: var(--gray-text);
    }

    .file-preview-item .fp-remove {
        background: #FFEBEE;
        color: #C62828;
        border: none;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .file-preview-item .fp-remove:hover {
        background: #C62828;
        color: var(--white);
    }

    /* Upload Form Fields */
    .rx-form-fields {
        margin-top: 25px;
        padding-top: 20px;
        border-top: 2px dashed #E0E0E0;
    }

    .form-group-rx {
        margin-bottom: 18px;
    }

    .form-label-rx {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--dark-text);
        margin-bottom: 6px;
        display: block;
    }

    .form-label-rx .req {
        color: #E53935;
    }

    .form-control-rx {
        width: 100%;
        padding: 11px 14px;
        border: 2px solid #E0E0E0;
        border-radius: 10px;
        font-size: 0.88rem;
        font-family: 'Poppins', sans-serif;
        outline: none;
        transition: var(--transition);
    }

    .form-control-rx:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
    }

    .form-control-rx.error {
        border-color: #E53935;
        background: #FFF5F5;
    }

    .form-select-rx {
        width: 100%;
        padding: 11px 14px;
        border: 2px solid #E0E0E0;
        border-radius: 10px;
        font-size: 0.88rem;
        font-family: 'Poppins', sans-serif;
        outline: none;
        background: var(--white);
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%232E7D32' viewBox='0 0 16 16'%3e%3cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 12px;
        padding-right: 35px;
    }

    textarea.form-control-rx {
        min-height: 80px;
        resize: vertical;
    }

    .err-msg-rx {
        color: #E53935;
        font-size: 0.75rem;
        margin-top: 4px;
        display: none;
    }

    .err-msg-rx.show {
        display: block;
    }

    .btn-submit-rx {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        border: none;
        padding: 13px 35px;
        border-radius: 25px;
        font-weight: 700;
        font-size: 0.95rem;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 6px 15px rgba(46, 125, 50, 0.25);
    }

    .btn-submit-rx:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(46, 125, 50, 0.35);
    }

    .btn-submit-rx:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    /* Info Cards */
    .rx-info-cards {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-bottom: 25px;
    }

    .rx-info-card {
        background: var(--white);
        border-radius: 14px;
        padding: 20px;
        box-shadow: var(--shadow);
        text-align: center;
        transition: var(--transition);
    }

    .rx-info-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(46, 125, 50, 0.15);
    }

    .rx-info-card .ric-icon {
        width: 55px;
        height: 55px;
        border-radius: 50%;
        background: var(--pale-green);
        color: var(--primary-green);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        margin: 0 auto 12px;
    }

    .rx-info-card h6 {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--dark-text);
        margin-bottom: 5px;
    }

    .rx-info-card p {
        font-size: 0.8rem;
        color: var(--gray-text);
        margin: 0;
        line-height: 1.5;
    }

    /* Prescription History */
    .history-card {
        background: var(--white);
        border-radius: 16px;
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .history-header {
        padding: 18px 22px;
        background: var(--off-white);
        border-bottom: 1px solid #E0E0E0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .history-header h5 {
        margin: 0;
        font-weight: 700;
        color: var(--dark-text);
    }

    .history-header h5 i {
        color: var(--primary-green);
        margin-right: 8px;
    }

    .history-header .rx-count {
        background: var(--pale-green);
        color: var(--primary-green);
        padding: 4px 12px;
        border-radius: 15px;
        font-size: 0.78rem;
        font-weight: 700;
    }

    /* Prescription Item */
    .rx-item {
        display: grid;
        grid-template-columns: 60px 1fr auto auto;
        gap: 15px;
        padding: 18px 22px;
        border-bottom: 1px solid #F5F5F5;
        align-items: center;
        transition: var(--transition);
    }

    .rx-item:last-child {
        border-bottom: none;
    }

    .rx-item:hover {
        background: var(--off-white);
    }

    .rx-item-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        background: var(--pale-green);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .rx-item-icon img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .rx-item-icon i {
        font-size: 1.5rem;
        color: var(--primary-green);
    }

    .rx-item-info h6 {
        font-size: 0.92rem;
        font-weight: 700;
        color: var(--dark-text);
        margin: 0 0 3px;
    }

    .rx-item-info .rx-meta {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .rx-item-info .rx-meta span {
        font-size: 0.75rem;
        color: var(--gray-text);
    }

    .rx-item-info .rx-meta span i {
        color: var(--primary-green);
        margin-right: 3px;
    }

    .rx-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 12px;
        border-radius: 15px;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .rxs-pending {
        background: #FFF3E0;
        color: #E65100;
    }

    .rxs-reviewed {
        background: #E3F2FD;
        color: #1565C0;
    }

    .rxs-approved {
        background: #E8F5E9;
        color: #1B5E20;
    }

    .rxs-rejected {
        background: #FFEBEE;
        color: #B71C1C;
    }

    .rxs-ordered {
        background: #F3E5F5;
        color: #6A1B9A;
    }

    .rx-item-actions {
        display: flex;
        gap: 6px;
    }

    .rx-action-btn {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        border: none;
        cursor: pointer;
        transition: var(--transition);
        font-size: 0.8rem;
        text-decoration: none;
    }

    .rx-action-btn.view {
        background: linear-gradient(135deg, #1976D2, #42A5F5);
    }

    .rx-action-btn.order {
        background: linear-gradient(135deg, #2E7D32, #66BB6A);
    }

    .rx-action-btn.delete {
        background: linear-gradient(135deg, #C62828, #EF5350);
    }

    .rx-action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        color: var(--white);
    }

    /* Empty History */
    .empty-rx-history {
        text-align: center;
        padding: 50px 20px;
        color: var(--gray-text);
    }

    .empty-rx-history i {
        font-size: 3.5rem;
        color: var(--mint-green);
        margin-bottom: 12px;
    }

    .empty-rx-history h6 {
        color: var(--dark-text);
        font-weight: 600;
    }

    /* Modal */
    .modal-content-rx {
        border: none;
        border-radius: 18px;
        overflow: hidden;
    }

    .modal-header-rx {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        padding: 18px 25px;
        border: none;
    }

    .modal-header-rx .btn-close {
        filter: brightness(0) invert(1);
    }

    .rx-preview-img {
        max-width: 100%;
        max-height: 500px;
        border-radius: 12px;
        margin: 0 auto;
        display: block;
    }

    /* Toast */
    .cart-toast {
        position: fixed;
        top: 90px;
        right: 20px;
        background: linear-gradient(135deg, #2E7D32, #66BB6A);
        color: var(--white);
        padding: 14px 22px;
        border-radius: 12px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        z-index: 10000;
        display: none;
        align-items: center;
        gap: 10px;
        font-size: 0.9rem;
        font-weight: 500;
    }

    @media (max-width: 767px) {
        .rx-info-cards {
            grid-template-columns: 1fr;
        }

        .rx-steps {
            flex-direction: column;
            gap: 10px;
        }

        .drop-zone {
            padding: 30px 20px;
        }

        .drop-zone .dz-icon {
            font-size: 3rem;
        }

        .rx-item {
            grid-template-columns: 50px 1fr;
            gap: 10px;
        }

        .rx-status-badge {
            grid-column: 2;
        }

        .rx-item-actions {
            grid-column: 1 / -1;
        }
    }
</style>
@endsection

@section('content')

{{-- Shared batch translation for the Prescriptions page --}}
@php
use App\Services\GoogleTranslator;

// Prescriptions passed from controller; fallback to demo
$prescriptions = $prescriptions ?? collect([
(object)['id'=>1,'file_name'=>'prescription_001.jpg','doctor_name'=>'Dr. Sharma','notes'=>'For fever and cold','status'=>'approved','created_at'=>now()->subDays(2)],
(object)['id'=>2,'file_name'=>'prescription_002.pdf','doctor_name'=>'Dr. Verma','notes'=>'Monthly diabetes medicines','status'=>'pending','created_at'=>now()->subHours(6)],
(object)['id'=>3,'file_name'=>'prescription_003.jpg','doctor_name'=>'Dr. Patel','notes'=>'Skin allergy treatment','status'=>'reviewed','created_at'=>now()->subDays(5)],
(object)['id'=>4,'file_name'=>'prescription_004.jpg','doctor_name'=>'Dr. Kumar','notes'=>'Antibiotic course 5 days','status'=>'ordered','created_at'=>now()->subDays(10)],
(object)['id'=>5,'file_name'=>'prescription_005.pdf','doctor_name'=>'Dr. Joshi','notes'=>'BP medicines refill','status'=>'rejected','created_at'=>now()->subDays(15)],
]);

// Fetch actual villages from database
$villages = $villages ?? App\Models\Village::active()->orderBy('name')->get();

// Ensure it's iterable
$rxArr = is_array($prescriptions) ? $prescriptions : (method_exists($prescriptions, 'all') ? $prescriptions->all() : []);

// Batch-translate doctor names and notes
if (!empty($rxArr)) {
$doctorNames = GoogleTranslator::translateBatch(array_map(fn($r) => $r->doctor_name ?? '', $rxArr));
$notesArr = GoogleTranslator::translateBatch(array_map(fn($r) => $r->notes ?? '', $rxArr));
foreach ($rxArr as $i => $r) {
if (!empty($r->doctor_name)) $r->doctor_name = $doctorNames[$i] ?? $r->doctor_name;
if (!empty($r->notes)) $r->notes = $notesArr[$i] ?? $r->notes;
}
$prescriptions = collect($rxArr);
}

// Status → icon
$statusIcons = [
'pending' => 'fa-clock',
'reviewed' => 'fa-eye',
'approved' => 'fa-check-circle',
'rejected' => 'fa-times-circle',
'ordered' => 'fa-shopping-cart',
];

// Translate everything on the page
$strings = GoogleTranslator::translateBatch([
'header_title' => 'Upload Prescription',
'header_desc' => "Upload a clear photo of your doctor's prescription. Our verified pharmacists will review it and prepare your medicines for delivery.",
'step_upload' => 'Upload Photo',
'step_review' => 'Pharmacist Reviews',
'step_prepare' => 'Medicines Prepared',
'step_deliver' => 'Delivered to You',
'info_secure_title' => '100% Secure',
'info_secure_desc' => 'Your prescriptions are encrypted and stored securely. Only verified pharmacists can access them.',
'info_quick_title' => 'Quick Review',
'info_quick_desc' => 'Our pharmacists review prescriptions within 30 minutes during working hours.',
'info_expert_title' => 'Expert Verification',
'info_expert_desc' => 'Licensed pharmacists verify dosage, interactions and authenticity of every prescription.',
'upload_title' => 'Upload New Prescription',
'drop_h5' => 'Drag & Drop Your Prescription Here',
'drop_p' => 'Drag and drop your file into this area',
'drop_max' => 'Max 5MB',
'label_doctor' => "Doctor's Name",
'ph_doctor' => 'e.g. Dr. Sharma',
'label_patient' => 'Patient Name',
'ph_patient' => 'Your name (auto-filled)',
'label_village' => 'Delivery Village',
'ph_select_village' => '-- Select Village --',
'label_urgency' => 'Urgency',
'urg_normal' => 'Normal (24-48 hrs)',
'urg_urgent' => 'Urgent (Same Day)',
'urg_emergency' => 'Emergency (2-4 hrs)',
'label_notes' => 'Additional Notes',
'ph_notes' => 'Any specific instructions, allergies, preferred brand, etc.',
'notes_max' => 'Max 300 characters',
'btn_submit' => 'Submit Prescription',
'btn_uploading' => 'Uploading...',
'history_title' => 'Prescription History',
'history_total' => 'Total',
'no_rx_title' => 'No prescriptions yet',
'no_rx_desc' => 'Upload your first prescription to get started.',
'modal_title' => 'Prescription Details',
'modal_doctor' => 'Doctor',
'modal_date' => 'Date',
'modal_file' => 'File',
'modal_status' => 'Status',
'modal_notes' => 'Notes',
'modal_pdf_msg' => 'PDF preview not available.',
'modal_pdf_download' => 'Download PDF',
'modal_img_msg' => 'Prescription image would appear here',
'status_pending' => 'Pending',
'status_reviewed' => 'Reviewed',
'status_approved' => 'Approved',
'status_rejected' => 'Rejected',
'status_ordered' => 'Ordered',
'js_invalid_type' => '⚠ Only JPG, PNG or PDF files are allowed.',
'js_size_exceeded' => '⚠ File size must be less than 5MB. Current: :size',
'js_file_required' => '⚠ Please upload a prescription file.',
'js_doctor_required' => '⚠ Doctor name required',
'js_doctor_min' => '⚠ Min 3 characters',
'js_village_required' => '⚠ Please select village',
'js_delete_confirm' => '⚠ Are you sure you want to delete this prescription?',
]);
@endphp

<!-- Header Banner -->
<div class="rx-header-banner">
    <div class="rx-header-content">
        <h3><i class="fas fa-file-prescription me-2"></i> {{ $strings['header_title'] }}</h3>
        <p>{{ $strings['header_desc'] }}</p>

        <div class="rx-steps">
            <div class="rx-step">
                <div class="step-num-rx">1</div>
                <span>{{ $strings['step_upload'] }}</span>
            </div>
            <div class="rx-step">
                <div class="step-num-rx">2</div>
                <span>{{ $strings['step_review'] }}</span>
            </div>
            <div class="rx-step">
                <div class="step-num-rx">3</div>
                <span>{{ $strings['step_prepare'] }}</span>
            </div>
            <div class="rx-step">
                <div class="step-num-rx">4</div>
                <span>{{ $strings['step_deliver'] }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Info Cards -->
<div class="rx-info-cards" data-aos="fade-up">
    <div class="rx-info-card">
        <div class="ric-icon"><i class="fas fa-shield-halved"></i></div>
        <h6>{{ $strings['info_secure_title'] }}</h6>
        <p>{{ $strings['info_secure_desc'] }}</p>
    </div>
    <div class="rx-info-card">
        <div class="ric-icon"><i class="fas fa-clock"></i></div>
        <h6>{{ $strings['info_quick_title'] }}</h6>
        <p>{{ $strings['info_quick_desc'] }}</p>
    </div>
    <div class="rx-info-card">
        <div class="ric-icon"><i class="fas fa-user-doctor"></i></div>
        <h6>{{ $strings['info_expert_title'] }}</h6>
        <p>{{ $strings['info_expert_desc'] }}</p>
    </div>
</div>

<div class="row g-4">
    <!-- ============ UPLOAD SECTION ============ -->
    <div class="col-lg-7">
        <div class="upload-card" data-aos="fade-up">
            <div class="upload-card-header">
                <h5><i class="fas fa-cloud-upload-alt"></i> {{ $strings['upload_title'] }}</h5>
            </div>
            <div class="upload-card-body">
                <form id="prescriptionForm" action="{{ url('/customer/prescription/upload') }}" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf

                    <!-- Drop Zone -->
                    <div class="drop-zone" id="dropZone">
                        <i class="fas fa-cloud-upload-alt dz-icon"></i>
                        <h5>{{ $strings['drop_h5'] }}</h5>
                        <p>{{ $strings['drop_p'] }}</p>
                        <div class="dz-formats">
                            <span class="dz-format">JPG</span>
                            <span class="dz-format">PNG</span>
                            <span class="dz-format">PDF</span>
                            <span class="dz-format">{{ $strings['drop_max'] }}</span>
                        </div>
                        <input type="file" name="prescription_file" id="rxFileInput"
                            accept="image/jpeg,image/png,image/jpg,application/pdf"
                            style="display:none;">
                    </div>
                    <span class="err-msg-rx" id="err_file" style="text-align:center;margin-top:8px;"></span>

                    <!-- File Preview -->
                    <div class="file-preview-area" id="filePreviewArea">
                        <div class="file-preview-item" id="filePreviewItem">
                            <div class="fp-thumb" id="fpThumb">
                                <i class="fas fa-file-image"></i>
                            </div>
                            <div class="fp-info">
                                <strong id="fpName">filename.jpg</strong>
                                <span id="fpSize">0 KB</span>
                            </div>
                            <button type="button" class="fp-remove" id="fpRemove" title="Remove file">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Form Fields -->
                    <div class="rx-form-fields">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-rx">
                                    <label class="form-label-rx">{{ $strings['label_doctor'] }} <span class="req">*</span></label>
                                    <input type="text" name="doctor_name" id="doctorName" class="form-control-rx" placeholder="{{ $strings['ph_doctor'] }}">
                                    <span class="err-msg-rx" id="err_doctorName"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-rx">
                                    <label class="form-label-rx">{{ $strings['label_patient'] }}</label>
                                    <input type="text" name="patient_name" id="patientName" class="form-control-rx" placeholder="{{ $strings['ph_patient'] }}" value="{{ session('customer_name') ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-rx">
                                    <label class="form-label-rx">{{ $strings['label_village'] }} <span class="req">*</span></label>
                                    <select name="village_id" id="rxVillage" class="form-select-rx">
                                        <option value="">{{ $strings['ph_select_village'] }}</option>
                                        @foreach($villages as $v)
                                        <option value="{{ $v->id }}">{{ GoogleTranslator::translate($v->name) }}</option>
                                        @endforeach
                                    </select>
                                    <span class="err-msg-rx" id="err_rxVillage"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-rx">
                                    <label class="form-label-rx">{{ $strings['label_urgency'] }}</label>
                                    <select name="urgency" id="rxUrgency" class="form-select-rx">
                                        <option value="normal">{{ $strings['urg_normal'] }}</option>
                                        <option value="urgent">{{ $strings['urg_urgent'] }}</option>
                                        <option value="emergency">{{ $strings['urg_emergency'] }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group-rx">
                                    <label class="form-label-rx">{{ $strings['label_notes'] }}</label>
                                    <textarea name="notes" id="rxNotes" class="form-control-rx" placeholder="{{ $strings['ph_notes'] }}" maxlength="300"></textarea>
                                    <small style="color:var(--gray-text);font-size:0.72rem;">{{ $strings['notes_max'] }}</small>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn-submit-rx" id="submitRxBtn">
                            <i class="fas fa-paper-plane"></i> {{ $strings['btn_submit'] }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ============ PRESCRIPTION HISTORY ============ -->
    <div class="col-lg-5">
        <div class="history-card" data-aos="fade-up" data-aos-delay="100">
            <div class="history-header">
                <h5><i class="fas fa-history"></i> {{ $strings['history_title'] }}</h5>
                <span class="rx-count">{{ count($prescriptions) }} {{ $strings['history_total'] }}</span>
            </div>

            @if(count($prescriptions) > 0)
            @foreach($prescriptions as $rx)
            @php
            $st = strtolower($rx->status ?? 'pending');
            $stLabel = $strings['status_' . $st] ?? ucfirst($st);
            @endphp
            <div class="rx-item">
                <div class="rx-item-icon">
                    @if(preg_match('/\.pdf$/i', $rx->file_name))
                    <i class="fas fa-file-pdf" style="color:#E53935;"></i>
                    @else
                    <i class="fas fa-file-image"></i>
                    @endif
                </div>

                <div class="rx-item-info">
                    <h6>{{ $rx->doctor_name }}</h6>
                    <div class="rx-meta">
                        <span><i class="fas fa-calendar"></i> {{ date('d M Y', strtotime($rx->created_at)) }}</span>
                        <span><i class="fas fa-file"></i> {{ $rx->file_name }}</span>
                    </div>
                    @if(!empty($rx->notes))
                    <div style="font-size:0.75rem;color:var(--gray-text);margin-top:3px;">
                        <i class="fas fa-sticky-note me-1" style="color:#FB8C00;"></i>{{ \Illuminate\Support\Str::limit($rx->notes, 40) }}
                    </div>
                    @endif
                </div>

                <span class="rx-status-badge rxs-{{ $st }}">
                    <i class="fas {{ $statusIcons[$st] ?? 'fa-circle' }}"></i>
                    {{ $stLabel }}
                </span>

                <div class="rx-item-actions">
                    <button type="button" class="rx-action-btn view btn-view-rx"
                        data-file="{{ $rx->file_name }}"
                        data-doctor="{{ $rx->doctor_name }}"
                        data-status="{{ $st }}"
                        data-status-label="{{ $stLabel }}"
                        data-date="{{ date('d M Y, h:i A', strtotime($rx->created_at)) }}"
                        data-notes="{{ $rx->notes }}"
                        title="View">
                        <i class="fas fa-eye"></i>
                    </button>

                    @if($st == 'approved')
                    <a href="{{ url('/customer/medicines') }}" class="rx-action-btn order" title="Order Medicines">
                        <i class="fas fa-cart-plus"></i>
                    </a>
                    @endif

                    @if(in_array($st, ['pending', 'rejected']))
                    <button type="button" class="rx-action-btn delete btn-delete-rx"
                        data-id="{{ $rx->id }}"
                        title="Delete">
                        <i class="fas fa-trash"></i>
                    </button>
                    @endif
                </div>
            </div>
            @endforeach
            @else
            <div class="empty-rx-history">
                <i class="fas fa-file-prescription"></i>
                <h6>{{ $strings['no_rx_title'] }}</h6>
                <p style="font-size:0.85rem;">{{ $strings['no_rx_desc'] }}</p>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- ============ VIEW PRESCRIPTION MODAL ============ -->
<div class="modal fade" id="viewRxModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-content-rx">
            <div class="modal-header modal-header-rx">
                <h5 class="modal-title"><i class="fas fa-file-prescription me-2"></i> {{ $strings['modal_title'] }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding:25px;" id="viewRxContent">
                <!-- Filled by jQuery -->
            </div>
        </div>
    </div>
</div>

<!-- Toast -->
<div class="cart-toast" id="cartToast">
    <i class="fas fa-check-circle"></i>
    <span id="toastMessage">Success!</span>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {

        var selectedFile = null;

        /* ============ TRANSLATED JS STRINGS ============ */
        var jsStrings = {
            invalidType: "{{ $strings['js_invalid_type'] ?? 'Only JPG, PNG or PDF files are allowed.' }}",
            sizeExceeded: "{{ $strings['js_size_exceeded'] ?? 'File size must be less than 5MB. Current: :size' }}",
            fileRequired: "{{ $strings['js_file_required'] ?? 'Please upload a prescription file.' }}",
            doctorRequired: "{{ $strings['js_doctor_required'] ?? 'Doctor name required' }}",
            doctorMin: "{{ $strings['js_doctor_min'] ?? 'Min 3 characters' }}",
            villageRequired: "{{ $strings['js_village_required'] ?? 'Please select village' }}",
            deleteConfirm: "{{ $strings['js_delete_confirm'] ?? 'Are you sure you want to delete this prescription?' }}",
            uploading: "{{ $strings['btn_uploading'] ?? 'Uploading...' }}"
        };

        function tpl(str, key, val) {
            return str.replace(':' + key, val);
        }

        /* 
         * ==========================================
         * DRAG & DROP LOGIC ONLY
         * ==========================================
         */
        var $dropZone = $('#dropZone');
        var $fileInput = $('#rxFileInput');

        // Clicking anywhere on Drop Zone opens file dialog (since there's no button now)
        $dropZone.on('click', function(e) {
            $fileInput.trigger('click');
        });

        // File Input Change
        $fileInput.on('change', function() {
            if (this.files.length > 0) {
                handleFile(this.files[0]);
            }
        });

        // Drag and Drop Handlers
        $dropZone.on('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).addClass('drag-over');
        });

        $dropZone.on('dragleave drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).removeClass('drag-over');
        });

        $dropZone.on('drop', function(e) {
            var files = e.originalEvent.dataTransfer.files;
            if (files.length > 0) {
                // Assign the dropped file to the hidden input using DataTransfer
                var dt = new DataTransfer();
                dt.items.add(files[0]);
                $fileInput[0].files = dt.files;

                // Now process the file for preview
                handleFile(files[0]);
            }
        });

        // Process and Preview File
        function handleFile(file) {
            var validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];
            var maxSize = 5 * 1024 * 1024; // 5MB

            $('#err_file').removeClass('show').text('');

            // Validate Type
            if (!validTypes.includes(file.type)) {
                $('#err_file').text(jsStrings.invalidType).addClass('show');
                $fileInput.val(''); // Clear input
                return;
            }

            // Validate Size
            if (file.size > maxSize) {
                var sizeStr = (file.size / 1024 / 1024).toFixed(1) + 'MB';
                $('#err_file').text(tpl(jsStrings.sizeExceeded, 'size', sizeStr)).addClass('show');
                $fileInput.val(''); // Clear input
                return;
            }

            selectedFile = file;

            // Format size string
            var sizeDisplay = file.size < 1024 ? file.size + ' B' :
                file.size < 1024 * 1024 ? (file.size / 1024).toFixed(1) + ' KB' :
                (file.size / (1024 * 1024)).toFixed(1) + ' MB';

            // Update Preview UI
            $('#fpName').text(file.name);
            $('#fpSize').text(sizeDisplay + ' · ' + file.type.split('/')[1].toUpperCase());

            if (file.type.startsWith('image/')) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#fpThumb').html('<img src="' + e.target.result + '">');
                };
                reader.readAsDataURL(file);
            } else {
                $('#fpThumb').html('<i class="fas fa-file-pdf" style="color:#E53935;"></i>');
            }

            $('#filePreviewArea').addClass('show');
            $dropZone.css({
                'border-color': 'var(--primary-green)',
                'background': 'var(--pale-green)'
            });
        }

        /* ============ REMOVE FILE ============ */
        $('#fpRemove').on('click', function(e) {
            e.stopPropagation(); // Stop drop zone from opening dialog
            selectedFile = null;
            $fileInput.val('');
            $('#filePreviewArea').removeClass('show');
            $dropZone.css({
                'border-color': '',
                'background': ''
            });
            $('#err_file').removeClass('show').text('');
        });

        /* ============ FORM VALIDATION & SUBMIT ============ */
        function showErr($el, msg) {
            $el.addClass('error');
            $el.closest('.form-group-rx').find('.err-msg-rx').text(msg).addClass('show');
        }

        function clearErr($el) {
            $el.removeClass('error');
            $el.closest('.form-group-rx').find('.err-msg-rx').removeClass('show').text('');
        }

        $('.form-control-rx, .form-select-rx').on('input change', function() {
            if ($(this).hasClass('error') && $.trim($(this).val()) !== '') {
                clearErr($(this));
            }
        });

        $('#prescriptionForm').on('submit', function(e) {
            e.preventDefault();

            var isValid = true;
            $('.err-msg-rx').removeClass('show').text('');
            $('.form-control-rx, .form-select-rx').removeClass('error');

            // File Validation
            if (!selectedFile && !$fileInput[0].files[0]) {
                $('#err_file').text(jsStrings.fileRequired).addClass('show');
                isValid = false;
            }

            // Doctor Name Validation
            var doctor = $.trim($('#doctorName').val());
            if (doctor === '') {
                showErr($('#doctorName'), jsStrings.doctorRequired);
                isValid = false;
            } else if (doctor.length < 3) {
                showErr($('#doctorName'), jsStrings.doctorMin);
                isValid = false;
            }

            // Village Validation
            if ($('#rxVillage').val() === '') {
                showErr($('#rxVillage'), jsStrings.villageRequired);
                isValid = false;
            }

            if (!isValid) {
                var $firstErr = $('.form-control-rx.error, .form-select-rx.error').first();
                if ($firstErr.length) {
                    $('html, body').animate({
                        scrollTop: $firstErr.offset().top - 120
                    }, 400);
                }
                return false;
            }

            // Ensure the file is actually attached before submitting
            if (selectedFile && (!$fileInput[0].files || $fileInput[0].files.length === 0)) {
                var dt = new DataTransfer();
                dt.items.add(selectedFile);
                $fileInput[0].files = dt.files;
            }

            var $btn = $('#submitRxBtn');
            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> ' + jsStrings.uploading);

            // Submit the form natively (bypasses jQuery submit to prevent infinite loops)
            this.submit();
        });

        /* ============ VIEW PRESCRIPTION ============ */
        $('.btn-view-rx').on('click', function() {
            var file = $(this).data('file');
            var doctor = $(this).data('doctor');
            var statusLabel = $(this).data('status-label');
            var status = $(this).data('status');
            var date = $(this).data('date');
            var notes = $(this).data('notes');

            var isPdf = file.match(/\.pdf$/i);
            var statusClass = 'rxs-' + status;

            var lblDoctor = "{{ $strings['modal_doctor'] ?? 'Doctor' }}";
            var lblDate = "{{ $strings['modal_date'] ?? 'Date' }}";
            var lblFile = "{{ $strings['modal_file'] ?? 'File' }}";
            var lblStatus = "{{ $strings['modal_status'] ?? 'Status' }}";
            var lblNotes = "{{ $strings['modal_notes'] ?? 'Notes' }}";
            var pdfMsg = "{{ $strings['modal_pdf_msg'] ?? 'PDF preview not available.' }}";
            var pdfBtn = "{{ $strings['modal_pdf_download'] ?? 'Download PDF' }}";

            var fileUrl = "{{ asset('images') }}/" + file;

            var html = `
            <div class="row g-3 mb-3">
                <div class="col-md-6"><strong style="color:var(--primary-green);">${lblDoctor}:</strong><br>${doctor}</div>
                <div class="col-md-6"><strong style="color:var(--primary-green);">${lblDate}:</strong><br>${date}</div>
                <div class="col-md-6"><strong style="color:var(--primary-green);">${lblFile}:</strong><br><a href="${fileUrl}" target="_blank">${file}</a></div>
                <div class="col-md-6"><strong style="color:var(--primary-green);">${lblStatus}:</strong><br><span class="rx-status-badge ${statusClass}">${statusLabel.toUpperCase()}</span></div>
                ${notes ? '<div class="col-12"><strong style="color:var(--primary-green);">' + lblNotes + ':</strong><br>' + notes + '</div>' : ''}
            </div>
            <div style="background:var(--pale-green);border-radius:12px;padding:40px;text-align:center;">
                ${isPdf
                    ? '<i class="fas fa-file-pdf" style="font-size:5rem;color:#E53935;"></i><p style="margin-top:10px;color:var(--gray-text);">' + pdfMsg + ' <a href="' + fileUrl + '" target="_blank">' + pdfBtn + '</a></p>'
                    : '<img src="' + fileUrl + '" class="rx-preview-img" alt="Prescription">'
                }
            </div>
        `;

            $('#viewRxContent').html(html);
            $('#viewRxModal').modal('show');
        });

        /* ============ DELETE PRESCRIPTION ============ */
        $('.btn-delete-rx').on('click', function() {
            var id = $(this).data('id');
            if (!confirm(jsStrings.deleteConfirm)) return;

            var $form = $('<form>', {
                method: 'POST',
                action: '{{ url("/customer/prescription/delete") }}'
            });
            $form.append('<input type="hidden" name="_token" value="{{ csrf_token() }}">');
            $form.append('<input type="hidden" name="prescription_id" value="' + id + '">');
            $form.append('<input type="hidden" name="_method" value="DELETE">');
            $('body').append($form);
            $form.submit();
        });

    });
</script>
@endsection