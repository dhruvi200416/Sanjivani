@extends('layouts.admin')

@section('title', 'Manage Medicines - Sanjivani Admin')
@section('page_title')
    <i class="fas fa-pills"></i> Manage Medicines
@endsection

@section('styles')
<style>
    /* Reuse styles from orders page */
    .filter-card {
        background: var(--white);
        border-radius: 16px;
        padding: 20px;
        box-shadow: var(--shadow);
        margin-bottom: 20px;
    }

    .filter-input, .filter-select {
        width: 100%;
        padding: 10px 14px;
        border: 2px solid #E8E8E8;
        border-radius: 10px;
        font-size: 0.88rem;
        font-family: 'Poppins', sans-serif;
        outline: none;
        transition: var(--transition);
    }

    .filter-input:focus, .filter-select:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 3px rgba(76,175,80,0.1);
    }

    .filter-select {
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%232E7D32' viewBox='0 0 16 16'%3e%3cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 12px;
        padding-right: 35px;
        background-color: var(--white);
        cursor: pointer;
    }

    .search-wrap { position: relative; }
    .search-wrap i {
        position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
        color: var(--primary-green); font-size: 0.9rem;
    }
    .search-wrap input { padding-left: 40px; }

    .btn-primary-custom {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white); border: none;
        padding: 10px 22px; border-radius: 10px;
        font-weight: 600; font-size: 0.88rem;
        cursor: pointer; transition: var(--transition);
        display: inline-flex; align-items: center; gap: 6px;
        text-decoration: none;
    }
    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(46,125,50,0.3);
        color: var(--white);
    }

    /* Medicines Grid */
    .medicine-grid-card {
        background: var(--white);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: var(--shadow);
        transition: var(--transition);
        height: 100%;
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .medicine-grid-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(46,125,50,0.18);
    }

    .medicine-grid-card .med-image {
        position: relative;
        height: 180px;
        background: var(--pale-green);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .medicine-grid-card .med-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .medicine-grid-card .med-image .no-img {
        font-size: 3rem;
        color: var(--accent-green);
    }

    .med-badge-corner {
        position: absolute;
        top: 10px;
        padding: 4px 10px;
        border-radius: 15px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        z-index: 2;
    }

    .med-badge-corner.featured {
        left: 10px;
        background: linear-gradient(135deg, #FB8C00, #FFA726);
        color: var(--white);
    }

    .med-badge-corner.rx {
        left: 10px;
        background: linear-gradient(135deg, #E53935, #EF5350);
        color: var(--white);
    }

    .med-stock-corner {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 4px 10px;
        border-radius: 15px;
        font-size: 0.7rem;
        font-weight: 700;
        background: rgba(255,255,255,0.95);
        z-index: 2;
    }

    .med-stock-corner.in { color: #2E7D32; }
    .med-stock-corner.low { color: #FB8C00; }
    .med-stock-corner.out { color: #C62828; }

    .medicine-grid-card .med-body-info {
        padding: 15px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .med-category-tag {
        font-size: 0.7rem;
        color: var(--primary-green);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-bottom: 4px;
    }

    .medicine-grid-card h6 {
        font-size: 0.98rem;
        font-weight: 700;
        color: var(--dark-text);
        margin-bottom: 4px;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .med-pharmacy-info {
        font-size: 0.75rem;
        color: var(--gray-text);
        margin-bottom: 10px;
    }

    .med-price-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
        padding-top: 12px;
        border-top: 1px solid #F5F5F5;
    }

    .med-price-big {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--primary-green);
    }

    .med-price-big small {
        font-size: 0.7rem;
        color: #999;
        text-decoration: line-through;
        font-weight: 500;
    }

    .med-actions {
        display: flex;
        gap: 5px;
    }

    .med-action-btn {
        width: 30px;
        height: 30px;
        border-radius: 7px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        color: var(--white);
        cursor: pointer;
        transition: var(--transition);
        font-size: 0.75rem;
        text-decoration: none;
    }

    .med-action-btn.edit { background: #1976D2; }
    .med-action-btn.delete { background: #C62828; }

    .med-action-btn:hover {
        transform: translateY(-2px);
        color: var(--white);
    }

    /* Modal */
    .modal-content-custom {
        border: none;
        border-radius: 18px;
        overflow: hidden;
    }

    .modal-header-custom {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        padding: 18px 25px;
        border: none;
    }

    .modal-header-custom .btn-close {
        filter: brightness(0) invert(1);
    }

    .form-group-modal {
        margin-bottom: 16px;
    }

    .form-label-modal {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--dark-text);
        margin-bottom: 6px;
        display: block;
    }

    .form-label-modal .req { color: #E53935; }

    .form-control-modal {
        width: 100%;
        padding: 10px 14px;
        border: 2px solid #E8E8E8;
        border-radius: 10px;
        font-size: 0.88rem;
        outline: none;
        transition: var(--transition);
        font-family: 'Poppins', sans-serif;
    }

    .form-control-modal:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 3px rgba(76,175,80,0.1);
    }

    .form-control-modal.error {
        border-color: #E53935;
        background: #FFF5F5;
    }

    .err-msg {
        color: #E53935;
        font-size: 0.75rem;
        margin-top: 4px;
        display: none;
    }

    .err-msg.show { display: block; }

    .image-upload-preview {
        border: 2px dashed var(--mint-green);
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: var(--transition);
        background: var(--pale-green);
    }

    .image-upload-preview:hover {
        border-color: var(--primary-green);
        background: var(--mint-green);
    }

    .image-upload-preview img {
        max-width: 100%;
        max-height: 120px;
        border-radius: 8px;
    }

    .image-upload-preview i {
        font-size: 2.5rem;
        color: var(--primary-green);
        margin-bottom: 8px;
    }

    .image-upload-preview p {
        margin: 5px 0 0;
        font-size: 0.85rem;
        color: var(--primary-green);
        font-weight: 600;
    }

    .checkbox-row {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        margin-top: 10px;
    }

    .checkbox-item {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }

    .checkbox-item input[type="checkbox"] {
        accent-color: var(--primary-green);
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    .checkbox-item label {
        font-size: 0.88rem;
        color: var(--dark-text);
        margin: 0;
        cursor: pointer;
    }

    .no-results {
        text-align: center;
        padding: 60px 20px;
    }

    .no-results i {
        font-size: 4rem;
        color: var(--mint-green);
    }

    .no-results h5 {
        color: var(--gray-text);
        margin-top: 15px;
        font-weight: 600;
    }
</style>
@endsection

@section('content')

@php
    $demoMedicines = $medicines ?? [
        (object)['id'=>1,'name'=>'Paracetamol 500mg','brand'=>'Crocin','category'=>'Fever & Pain','price'=>25,'mrp'=>30,'stock'=>150,'featured'=>1,'prescription_required'=>0,'image'=>null,'pharmacy'=>(object)['pharmacy_name'=>'MediCare']],
        (object)['id'=>2,'name'=>'Vitamin C 500mg','brand'=>'Limcee','category'=>'Vitamins','price'=>180,'mrp'=>200,'stock'=>80,'featured'=>1,'prescription_required'=>0,'image'=>null,'pharmacy'=>(object)['pharmacy_name'=>'HealthPlus']],
        (object)['id'=>3,'name'=>'Amoxicillin 250mg','brand'=>'Mox','category'=>'Antibiotic','price'=>85,'mrp'=>100,'stock'=>8,'featured'=>0,'prescription_required'=>1,'image'=>null,'pharmacy'=>(object)['pharmacy_name'=>'MediCare']],
        (object)['id'=>4,'name'=>'Cough Syrup 100ml','brand'=>'Benadryl','category'=>'Cold & Cough','price'=>145,'mrp'=>160,'stock'=>45,'featured'=>0,'prescription_required'=>0,'image'=>null,'pharmacy'=>(object)['pharmacy_name'=>'HealthPlus']],
        (object)['id'=>5,'name'=>'Insulin Injection','brand'=>'Humulin','category'=>'Diabetes','price'=>450,'mrp'=>500,'stock'=>0,'featured'=>0,'prescription_required'=>1,'image'=>null,'pharmacy'=>(object)['pharmacy_name'=>'DiabetCare']],
        (object)['id'=>6,'name'=>'Antacid Tablets','brand'=>'ENO','category'=>'Digestive','price'=>60,'mrp'=>75,'stock'=>200,'featured'=>1,'prescription_required'=>0,'image'=>null,'pharmacy'=>(object)['pharmacy_name'=>'MediCare']],
        (object)['id'=>7,'name'=>'Multivitamin','brand'=>'Revital','category'=>'Vitamins','price'=>320,'mrp'=>360,'stock'=>65,'featured'=>0,'prescription_required'=>0,'image'=>null,'pharmacy'=>(object)['pharmacy_name'=>'HealthPlus']],
        (object)['id'=>8,'name'=>'Blood Pressure Med','brand'=>'Amlong','category'=>'Heart Care','price'=>75,'mrp'=>90,'stock'=>15,'featured'=>0,'prescription_required'=>1,'image'=>null,'pharmacy'=>(object)['pharmacy_name'=>'DiabetCare']],
    ];
@endphp

<!-- ============ FILTERS + ADD BUTTON ============ -->
<div class="filter-card" data-aos="fade-up">
    <form id="filterForm" method="GET" action="{{ url('/admin/medicines') }}">
        <div class="row g-3 align-items-end">
            <div class="col-lg-4 col-md-6">
                <label style="font-size:0.78rem;font-weight:600;color:var(--dark-text);text-transform:uppercase;margin-bottom:6px;display:block;"><i class="fas fa-search me-1"></i> Search</label>
                <div class="search-wrap">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" class="filter-input" placeholder="Medicine name, brand..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-lg-2 col-md-6">
                <label style="font-size:0.78rem;font-weight:600;color:var(--dark-text);text-transform:uppercase;margin-bottom:6px;display:block;"><i class="fas fa-tags me-1"></i> Category</label>
                <select name="category" class="filter-select">
                    <option value="">All Categories</option>
                    <option value="Fever & Pain" {{ request('category')=='Fever & Pain' ? 'selected' : '' }}>Fever & Pain</option>
                    <option value="Cold & Cough" {{ request('category')=='Cold & Cough' ? 'selected' : '' }}>Cold & Cough</option>
                    <option value="Vitamins" {{ request('category')=='Vitamins' ? 'selected' : '' }}>Vitamins</option>
                    <option value="Antibiotic" {{ request('category')=='Antibiotic' ? 'selected' : '' }}>Antibiotic</option>
                    <option value="Diabetes" {{ request('category')=='Diabetes' ? 'selected' : '' }}>Diabetes</option>
                    <option value="Heart Care" {{ request('category')=='Heart Care' ? 'selected' : '' }}>Heart Care</option>
                    <option value="Digestive" {{ request('category')=='Digestive' ? 'selected' : '' }}>Digestive</option>
                </select>
            </div>
            <div class="col-lg-2 col-md-6">
                <label style="font-size:0.78rem;font-weight:600;color:var(--dark-text);text-transform:uppercase;margin-bottom:6px;display:block;"><i class="fas fa-box me-1"></i> Stock</label>
                <select name="stock" class="filter-select">
                    <option value="">All Stock</option>
                    <option value="in" {{ request('stock')=='in' ? 'selected' : '' }}>In Stock</option>
                    <option value="low" {{ request('stock')=='low' ? 'selected' : '' }}>Low Stock (< 20)</option>
                    <option value="out" {{ request('stock')=='out' ? 'selected' : '' }}>Out of Stock</option>
                </select>
            </div>
            <div class="col-lg-2 col-md-6">
                <button type="submit" class="btn-primary-custom w-100 justify-content-center">
                    <i class="fas fa-filter"></i> Filter
                </button>
            </div>
            <div class="col-lg-2 col-md-6">
                <button type="button" class="btn-primary-custom w-100 justify-content-center" data-bs-toggle="modal" data-bs-target="#medicineModal" id="addMedicineBtn">
                    <i class="fas fa-plus"></i> Add Medicine
                </button>
            </div>
        </div>
    </form>
</div>

<!-- ============ MEDICINES GRID ============ -->
<div class="row g-3" data-aos="fade-up">
    @if(count($demoMedicines) > 0)
        @foreach($demoMedicines as $med)
            @php
                $stockClass = $med->stock <= 0 ? 'out' : ($med->stock < 20 ? 'low' : 'in');
                $stockText = $med->stock <= 0 ? 'Out' : ($med->stock < 20 ? 'Low: '.$med->stock : $med->stock);
            @endphp
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="medicine-grid-card">
                    <div class="med-image">
                        @if(!empty($med->image) && file_exists(public_path('uploads/medicines/'.$med->image)))
                            <img src="{{ asset('uploads/medicines/'.$med->image) }}" alt="{{ $med->name }}">
                        @else
                            <i class="fas fa-pills no-img"></i>
                        @endif

                        @if($med->prescription_required)
                            <span class="med-badge-corner rx"><i class="fas fa-file-prescription"></i> Rx</span>
                        @elseif($med->featured)
                            <span class="med-badge-corner featured"><i class="fas fa-star"></i> Featured</span>
                        @endif

                        <span class="med-stock-corner {{ $stockClass }}">
                            <i class="fas fa-cubes"></i> {{ $stockText }}
                        </span>
                    </div>

                    <div class="med-body-info">
                        <div class="med-category-tag">{{ $med->category }}</div>
                        <h6>{{ $med->name }}</h6>
                        <div class="med-pharmacy-info">
                            <i class="fas fa-store me-1"></i> {{ $med->pharmacy->pharmacy_name ?? 'N/A' }}
                            <br>
                            <span style="font-size:0.72rem;">{{ $med->brand }}</span>
                        </div>

                        <div class="med-price-row">
                            <div class="med-price-big">
                                ₹{{ number_format($med->price, 0) }}
                                @if($med->mrp > $med->price)
                                    <small>₹{{ number_format($med->mrp, 0) }}</small>
                                @endif
                            </div>
                            <div class="med-actions">
                                <button type="button" class="med-action-btn edit btn-edit-medicine"
                                        data-med='@json($med)'
                                        title="Edit"><i class="fas fa-edit"></i></button>
                                <button type="button" class="med-action-btn delete btn-delete-medicine"
                                        data-id="{{ $med->id }}"
                                        data-name="{{ $med->name }}"
                                        title="Delete"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="col-12">
            <div class="no-results">
                <i class="fas fa-pills"></i>
                <h5>No medicines found</h5>
                <p class="text-muted">Try changing your filters or add a new medicine.</p>
            </div>
        </div>
    @endif
</div>

<!-- ============ ADD/EDIT MEDICINE MODAL ============ -->
<div class="modal fade" id="medicineModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <div class="modal-header modal-header-custom">
                <h5 class="modal-title" id="modalTitle"><i class="fas fa-plus-circle me-2"></i> Add New Medicine</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="medicineForm" action="{{ url('/admin/medicine/save') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                <input type="hidden" name="medicine_id" id="medicineId">
                <div class="modal-body" style="padding:25px;">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group-modal">
                                        <label class="form-label-modal">Medicine Name <span class="req">*</span></label>
                                        <input type="text" name="name" id="med_name" class="form-control-modal" placeholder="e.g. Paracetamol 500mg">
                                        <span class="err-msg" id="err_name"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-modal">
                                        <label class="form-label-modal">Brand Name <span class="req">*</span></label>
                                        <input type="text" name="brand" id="med_brand" class="form-control-modal" placeholder="e.g. Crocin">
                                        <span class="err-msg" id="err_brand"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-modal">
                                        <label class="form-label-modal">Category <span class="req">*</span></label>
                                        <select name="category" id="med_category" class="form-control-modal">
                                            <option value="">-- Select --</option>
                                            <option value="Fever & Pain">Fever & Pain</option>
                                            <option value="Cold & Cough">Cold & Cough</option>
                                            <option value="Vitamins">Vitamins</option>
                                            <option value="Antibiotic">Antibiotic</option>
                                            <option value="Diabetes">Diabetes</option>
                                            <option value="Heart Care">Heart Care</option>
                                            <option value="Skin Care">Skin Care</option>
                                            <option value="Baby Care">Baby Care</option>
                                            <option value="Ayurvedic">Ayurvedic</option>
                                            <option value="Digestive">Digestive</option>
                                            <option value="First Aid">First Aid</option>
                                        </select>
                                        <span class="err-msg" id="err_category"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-modal">
                                        <label class="form-label-modal">Pharmacy <span class="req">*</span></label>
                                        <select name="pharmacy_id" id="med_pharmacy" class="form-control-modal">
                                            <option value="">-- Select Pharmacy --</option>
                                            @if(!empty($pharmacies))
                                                @foreach($pharmacies as $ph)
                                                    <option value="{{ $ph->id }}">{{ $ph->pharmacy_name }}</option>
                                                @endforeach
                                            @else
                                                <option value="1">MediCare Pharmacy</option>
                                                <option value="2">HealthPlus Pharmacy</option>
                                                <option value="3">DiabetCare Store</option>
                                            @endif
                                        </select>
                                        <span class="err-msg" id="err_pharmacy"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group-modal">
                                        <label class="form-label-modal">Price (₹) <span class="req">*</span></label>
                                        <input type="number" name="price" id="med_price" class="form-control-modal" placeholder="0.00" step="0.01" min="0">
                                        <span class="err-msg" id="err_price"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group-modal">
                                        <label class="form-label-modal">MRP (₹)</label>
                                        <input type="number" name="mrp" id="med_mrp" class="form-control-modal" placeholder="0.00" step="0.01" min="0">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group-modal">
                                        <label class="form-label-modal">Stock <span class="req">*</span></label>
                                        <input type="number" name="stock" id="med_stock" class="form-control-modal" placeholder="0" min="0">
                                        <span class="err-msg" id="err_stock"></span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group-modal">
                                        <label class="form-label-modal">Description</label>
                                        <textarea name="description" id="med_description" class="form-control-modal" rows="3" placeholder="Brief description of the medicine..."></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="checkbox-row">
                                        <div class="checkbox-item">
                                            <input type="checkbox" name="featured" id="med_featured" value="1">
                                            <label for="med_featured"><i class="fas fa-star" style="color:#FFA726;"></i> Featured Product</label>
                                        </div>
                                        <div class="checkbox-item">
                                            <input type="checkbox" name="prescription_required" id="med_rx" value="1">
                                            <label for="med_rx"><i class="fas fa-file-prescription" style="color:#E53935;"></i> Prescription Required</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group-modal">
                                <label class="form-label-modal">Medicine Image</label>
                                <div class="image-upload-preview" id="uploadPreview" onclick="$('#imageInput').click()">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <p>Click to Upload</p>
                                    <small style="color:var(--gray-text);font-size:0.7rem;">Max 2MB (JPG, PNG)</small>
                                </div>
                                <input type="file" name="image" id="imageInput" accept="image/*" style="display:none;">
                                <span class="err-msg" id="err_image"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border:none;padding:15px 25px 25px;">
                    <button type="button" class="btn-primary-custom" data-bs-dismiss="modal" style="background:linear-gradient(135deg,#607D8B,#90A4AE);">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn-primary-custom" id="saveMedBtn">
                        <i class="fas fa-save"></i> Save Medicine
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function () {

    /* ============ IMAGE UPLOAD PREVIEW ============ */
    $('#imageInput').on('change', function () {
        var file = this.files[0];
        if (file) {
            if (file.size > 2 * 1024 * 1024) {
                $('#err_image').text('⚠ Image size must be less than 2MB').addClass('show');
                $(this).val('');
                return;
            }
            if (!file.type.match('image.*')) {
                $('#err_image').text('⚠ Please upload a valid image file').addClass('show');
                $(this).val('');
                return;
            }

            var reader = new FileReader();
            reader.onload = function (e) {
                $('#uploadPreview').html('<img src="' + e.target.result + '" style="max-height:150px;"><p><i class="fas fa-check-circle" style="color:#2E7D32;"></i> Image Selected</p>');
            };
            reader.readAsDataURL(file);
            $('#err_image').text('').removeClass('show');
        }
    });

    /* ============ RESET FORM ON ADD ============ */
    $('#addMedicineBtn').on('click', function () {
        $('#medicineForm')[0].reset();
        $('#medicineId').val('');
        $('#modalTitle').html('<i class="fas fa-plus-circle me-2"></i> Add New Medicine');
        $('#uploadPreview').html('<i class="fas fa-cloud-upload-alt"></i><p>Click to Upload</p><small style="color:var(--gray-text);font-size:0.7rem;">Max 2MB (JPG, PNG)</small>');
        $('.err-msg').removeClass('show').text('');
        $('.form-control-modal').removeClass('error');
    });

    /* ============ EDIT MEDICINE ============ */
    $('.btn-edit-medicine').on('click', function () {
        var med = $(this).data('med');

        $('#medicineId').val(med.id);
        $('#med_name').val(med.name);
        $('#med_brand').val(med.brand);
        $('#med_category').val(med.category);
        $('#med_pharmacy').val(med.pharmacy_id || '');
        $('#med_price').val(med.price);
        $('#med_mrp').val(med.mrp);
        $('#med_stock').val(med.stock);
        $('#med_description').val(med.description || '');
        $('#med_featured').prop('checked', med.featured == 1);
        $('#med_rx').prop('checked', med.prescription_required == 1);

        $('#modalTitle').html('<i class="fas fa-edit me-2"></i> Edit Medicine');
        if (med.image) {
            $('#uploadPreview').html('<img src="{{ asset("uploads/medicines") }}/' + med.image + '" style="max-height:150px;"><p>Current Image</p>');
        }
        $('.err-msg').removeClass('show').text('');
        $('.form-control-modal').removeClass('error');
        $('#medicineModal').modal('show');
    });

    /* ============ DELETE MEDICINE ============ */
    $('.btn-delete-medicine').on('click', function () {
        var id = $(this).data('id');
        var name = $(this).data('name');

        if (confirm('Are you sure you want to delete "' + name + '"?\nThis action cannot be undone.')) {
            var $form = $('<form>', {
                method: 'POST',
                action: '{{ url("/admin/medicine/delete") }}/' + id
            });
            $form.append('<input type="hidden" name="_token" value="{{ csrf_token() }}">');
            $form.append('<input type="hidden" name="_method" value="DELETE">');
            $('body').append($form);
            $form.submit();
        }
    });

    /* ============ FORM VALIDATION ============ */
    function showFieldError($el, msg) {
        $el.addClass('error');
        $el.closest('.form-group-modal').find('.err-msg').text(msg).addClass('show');
    }

    function clearFieldError($el) {
        $el.removeClass('error');
        $el.closest('.form-group-modal').find('.err-msg').removeClass('show').text('');
    }

    $('#medicineForm').on('submit', function (e) {
        e.preventDefault();

        var isValid = true;
        $('.err-msg').removeClass('show').text('');
        $('.form-control-modal').removeClass('error');

        // Name
        var name = $.trim($('#med_name').val());
        if (name === '') { showFieldError($('#med_name'), '⚠ Medicine name required'); isValid = false; }
        else if (name.length < 2) { showFieldError($('#med_name'), '⚠ Min 2 characters'); isValid = false; }

        // Brand
        if ($.trim($('#med_brand').val()) === '') { showFieldError($('#med_brand'), '⚠ Brand required'); isValid = false; }

        // Category
        if ($('#med_category').val() === '') { showFieldError($('#med_category'), '⚠ Please select category'); isValid = false; }

        // Pharmacy
        if ($('#med_pharmacy').val() === '') { showFieldError($('#med_pharmacy'), '⚠ Please select pharmacy'); isValid = false; }

        // Price
        var price = parseFloat($('#med_price').val());
        if (!$('#med_price').val() || isNaN(price)) { showFieldError($('#med_price'), '⚠ Price required'); isValid = false; }
        else if (price <= 0) { showFieldError($('#med_price'), '⚠ Price must be greater than 0'); isValid = false; }

        // Stock
        var stock = parseInt($('#med_stock').val());
        if ($('#med_stock').val() === '' || isNaN(stock)) { showFieldError($('#med_stock'), '⚠ Stock required'); isValid = false; }
        else if (stock < 0) { showFieldError($('#med_stock'), '⚠ Stock cannot be negative'); isValid = false; }

        if (!isValid) return false;

        var $btn = $('#saveMedBtn');
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
        this.submit();
    });

    // Clear errors on input
    $('.form-control-modal').on('input change', function () {
        if ($(this).hasClass('error') && $.trim($(this).val()) !== '') {
            clearFieldError($(this));
        }
    });

});
</script>
@endsection