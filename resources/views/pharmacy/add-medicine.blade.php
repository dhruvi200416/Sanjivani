@extends('layouts.pharmacy')

@section('title', 'Add Medicine')
@section('page_title')
<i class="fas fa-plus-circle"></i> {{ app(\App\Services\GoogleTranslator::class)->translate('Add Medicine') }}
@endsection

@section('styles')
<style>
    .add-med-card {
        background: var(--white);
        border-radius: 18px;
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .add-med-header {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        padding: 20px 25px;
    }

    .add-med-header h5 {
        margin: 0;
        font-weight: 700;
    }

    .add-med-body {
        padding: 30px;
    }

    .fg-ph {
        margin-bottom: 18px;
    }

    .fl-ph {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--dark-text);
        margin-bottom: 6px;
        display: block;
    }

    .fl-ph .req {
        color: #E53935;
    }

    .fc-ph {
        width: 100%;
        padding: 11px 14px;
        border: 2px solid #E0E0E0;
        border-radius: 10px;
        font-size: 0.9rem;
        outline: none;
        transition: var(--transition);
        font-family: 'Poppins', sans-serif;
    }

    .fc-ph:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
    }

    .fc-ph.error {
        border-color: #E53935;
        background: #FFF5F5;
    }

    .fs-ph {
        width: 100%;
        padding: 11px 14px;
        border: 2px solid #E0E0E0;
        border-radius: 10px;
        font-size: 0.9rem;
        outline: none;
        background: var(--white);
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%232E7D32' viewBox='0 0 16 16'%3e%3cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 12px;
        font-family: 'Poppins', sans-serif;
    }

    textarea.fc-ph {
        min-height: 80px;
        resize: vertical;
    }

    .err-ph {
        color: #E53935;
        font-size: 0.75rem;
        margin-top: 4px;
        display: none;
    }

    .err-ph.show {
        display: block;
    }

    .img-upload-ph {
        border: 2px dashed var(--mint-green);
        border-radius: 12px;
        padding: 30px;
        text-align: center;
        cursor: pointer;
        transition: var(--transition);
        background: var(--pale-green);
    }

    .img-upload-ph:hover {
        border-color: var(--primary-green);
        background: var(--mint-green);
    }

    .img-upload-ph i {
        font-size: 2.5rem;
        color: var(--primary-green);
        margin-bottom: 8px;
    }

    .img-upload-ph p {
        margin: 0;
        color: var(--primary-green);
        font-weight: 600;
        font-size: 0.88rem;
    }

    .img-upload-ph img {
        max-height: 120px;
        border-radius: 8px;
    }

    .cb-row {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        margin-top: 10px;
    }

    .cb-item {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }

    .cb-item input {
        accent-color: var(--primary-green);
        width: 18px;
        height: 18px;
    }

    .cb-item label {
        font-size: 0.88rem;
        color: var(--dark-text);
        margin: 0;
        cursor: pointer;
    }

    .btn-save-med {
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

    .btn-save-med:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(46, 125, 50, 0.35);
    }
</style>
@endsection

@section('content')

@php
use App\Services\GoogleTranslator;

$medicine = $medicine ?? null;
$isEdit = !empty($medicine);

// Translate the existing medicine data if editing
$tMedName = $isEdit ? GoogleTranslator::translate($medicine->name) : '';
$tMedBrand = $isEdit ? GoogleTranslator::translate($medicine->brand) : '';
$tMedComp = $isEdit ? GoogleTranslator::translate($medicine->composition ?? '') : '';
$tMedDesc = $isEdit ? GoogleTranslator::translate($medicine->description ?? '') : '';

$strings = GoogleTranslator::translateBatch([
'header_edit' => 'Edit Medicine',
'header_add' => 'Add New Medicine',
'lbl_name' => 'Medicine Name',
'ph_name' => 'e.g. Paracetamol 500mg',
'lbl_brand' => 'Brand',
'ph_brand' => 'e.g. Crocin',
'lbl_category' => 'Category',
'select_placeholder' => '-- Select --',
'lbl_price' => 'Price (₹)',
'lbl_mrp' => 'MRP (₹)',
'lbl_stock' => 'Stock',
'lbl_composition' => 'Composition',
'ph_composition' => 'e.g. Paracetamol 500mg',
'lbl_expiry' => 'Expiry Date',
'lbl_desc' => 'Description',
'ph_desc' => 'Describe the usage, benefits, and precautions of the medicine...',
'lbl_featured' => 'Featured Product',
'lbl_rx' => 'Prescription Required',
'lbl_image' => 'Medicine Image',
'btn_change_img' => 'Change Image',
'btn_upload_img' => 'Click to Upload',
'max_size' => 'Max size: 2MB (JPG, PNG)',
'img_selected' => 'Image Selected',
'btn_cancel' => 'Cancel',
'btn_save' => 'Save Medicine',
'js_img_size' => '⚠ Image size must be less than 2MB',
'js_img_type' => '⚠ Please upload a valid image file',
'js_name_req' => '⚠ Medicine name is required',
'js_name_min' => '⚠ Medicine name must be at least 2 characters',
'js_brand_req' => '⚠ Brand name is required',
'js_cat_req' => '⚠ Please select a health category',
'js_price_req' => '⚠ Price is required',
'js_price_gt' => '⚠ Price must be greater than 0',
'js_stock_req' => '⚠ Stock quantity is required',
'js_stock_neg' => '⚠ Stock cannot be a negative value',
'js_saving' => 'Saving...',
// Categories
'cat_fever' => 'Fever & Pain',
'cat_cold' => 'Cold & Cough',
'cat_vitamins' => 'Vitamins',
'cat_antibiotic' => 'Antibiotic',
'cat_diabetes' => 'Diabetes',
'cat_heart' => 'Heart Care',
'cat_skin' => 'Skin Care',
'cat_baby' => 'Baby Care',
'cat_ayurvedic' => 'Ayurvedic',
'cat_digestive' => 'Digestive',
'cat_firstaid' => 'First Aid'
]);
@endphp

<div class="add-med-card">
    <div class="add-med-header">
        <h5><i class="fas {{ $isEdit ? 'fa-edit' : 'fa-plus-circle' }} me-2"></i>{{ $isEdit ? $strings['header_edit'] : $strings['header_add'] }}</h5>
    </div>
    <div class="add-med-body">
        <form id="medicineFormPh" action="{{ url('/pharmacy/medicine/save') }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf
            @if($isEdit)<input type="hidden" name="medicine_id" value="{{ $medicine->id }}">@endif

            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="fg-ph">
                                <label class="fl-ph">{{ $strings['lbl_name'] }} <span class="req">*</span></label>
                                <input type="text" name="name" id="m_name" class="fc-ph" placeholder="{{ $strings['ph_name'] }}" value="{{ $tMedName }}">
                                <span class="err-ph" id="err_m_name"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="fg-ph">
                                <label class="fl-ph">{{ $strings['lbl_brand'] }} <span class="req">*</span></label>
                                <input type="text" name="brand" id="m_brand" class="fc-ph" placeholder="{{ $strings['ph_brand'] }}" value="{{ $tMedBrand }}">
                                <span class="err-ph" id="err_m_brand"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="fg-ph">
                                <label class="fl-ph">{{ $strings['lbl_category'] }} <span class="req">*</span></label>
                                <select name="category" id="m_category" class="fs-ph">
                                    <option value="">{{ $strings['select_placeholder'] }}</option>
                                    <option value="Fever & Pain" {{ ($medicine->category ?? '') == 'Fever & Pain' ? 'selected' : '' }}>{{ $strings['cat_fever'] }}</option>
                                    <option value="Cold & Cough" {{ ($medicine->category ?? '') == 'Cold & Cough' ? 'selected' : '' }}>{{ $strings['cat_cold'] }}</option>
                                    <option value="Vitamins" {{ ($medicine->category ?? '') == 'Vitamins' ? 'selected' : '' }}>{{ $strings['cat_vitamins'] }}</option>
                                    <option value="Antibiotic" {{ ($medicine->category ?? '') == 'Antibiotic' ? 'selected' : '' }}>{{ $strings['cat_antibiotic'] }}</option>
                                    <option value="Diabetes" {{ ($medicine->category ?? '') == 'Diabetes' ? 'selected' : '' }}>{{ $strings['cat_diabetes'] }}</option>
                                    <option value="Heart Care" {{ ($medicine->category ?? '') == 'Heart Care' ? 'selected' : '' }}>{{ $strings['cat_heart'] }}</option>
                                    <option value="Skin Care" {{ ($medicine->category ?? '') == 'Skin Care' ? 'selected' : '' }}>{{ $strings['cat_skin'] }}</option>
                                    <option value="Baby Care" {{ ($medicine->category ?? '') == 'Baby Care' ? 'selected' : '' }}>{{ $strings['cat_baby'] }}</option>
                                    <option value="Ayurvedic" {{ ($medicine->category ?? '') == 'Ayurvedic' ? 'selected' : '' }}>{{ $strings['cat_ayurvedic'] }}</option>
                                    <option value="Digestive" {{ ($medicine->category ?? '') == 'Digestive' ? 'selected' : '' }}>{{ $strings['cat_digestive'] }}</option>
                                    <option value="First Aid" {{ ($medicine->category ?? '') == 'First Aid' ? 'selected' : '' }}>{{ $strings['cat_firstaid'] }}</option>
                                </select>
                                <span class="err-ph" id="err_m_category"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="fg-ph">
                                <label class="fl-ph">{{ $strings['lbl_price'] }} <span class="req">*</span></label>
                                <input type="number" name="price" id="m_price" class="fc-ph" placeholder="0.00" step="0.01" min="0" value="{{ $medicine->price ?? '' }}">
                                <span class="err-ph" id="err_m_price"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="fg-ph">
                                <label class="fl-ph">{{ $strings['lbl_mrp'] }}</label>
                                <input type="number" name="mrp" id="m_mrp" class="fc-ph" placeholder="0.00" step="0.01" min="0" value="{{ $medicine->mrp ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="fg-ph">
                                <label class="fl-ph">{{ $strings['lbl_stock'] }} <span class="req">*</span></label>
                                <input type="number" name="stock" id="m_stock" class="fc-ph" placeholder="0" min="0" value="{{ $medicine->stock ?? '' }}">
                                <span class="err-ph" id="err_m_stock"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="fg-ph">
                                <label class="fl-ph">{{ $strings['lbl_composition'] }}</label>
                                <input type="text" name="composition" class="fc-ph" placeholder="{{ $strings['ph_composition'] }}" value="{{ $tMedComp }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="fg-ph">
                                <label class="fl-ph">{{ $strings['lbl_expiry'] }}</label>
                                <input type="date" name="expiry_date" class="fc-ph" value="{{ $medicine->expiry_date ?? '' }}" min="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="fg-ph">
                                <label class="fl-ph">{{ $strings['lbl_desc'] }}</label>
                                <textarea name="description" id="m_description" class="fc-ph" rows="3" placeholder="{{ $strings['ph_desc'] }}">{{ $tMedDesc }}</textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="cb-row">
                                <div class="cb-item">
                                    <input type="checkbox" name="featured" id="m_featured" value="1" {{ ($medicine->featured ?? 0) == 1 ? 'checked' : '' }}>
                                    <label for="m_featured"><i class="fas fa-star text-warning"></i> {{ $strings['lbl_featured'] }}</label>
                                </div>
                                <div class="cb-item">
                                    <input type="checkbox" name="prescription_required" id="m_rx" value="1" {{ ($medicine->prescription_required ?? 0) == 1 ? 'checked' : '' }}>
                                    <label for="m_rx"><i class="fas fa-file-prescription text-danger"></i> {{ $strings['lbl_rx'] }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Image Upload -->
                <div class="col-md-4">
                    <div class="fg-ph">
                        <label class="fl-ph">{{ $strings['lbl_image'] }}</label>
                        <div class="img-upload-ph" id="uploadPreviewPh" onclick="$('#medImageInput').click()">
                            @if($isEdit && !empty($medicine->image) && file_exists(public_path('uploads/medicines/'.$medicine->image)))
                            <img src="{{ asset('uploads/medicines/'.$medicine->image) }}" alt="Preview" style="max-height: 120px;">
                            <p class="mt-2"><i class="fas fa-edit"></i> {{ $strings['btn_change_img'] }}</p>
                            @else
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p>{{ $strings['btn_upload_img'] }}</p>
                            <small style="color: var(--gray-text); font-size: 0.72rem; display: block; margin-top: 5px;">{{ $strings['max_size'] }}</small>
                            @endif
                        </div>
                        <input type="file" name="image" id="medImageInput" accept="image/*" style="display:none;">
                        <span class="err-ph text-center" id="err_m_image"></span>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="text-end mt-4">
                <a href="{{ url('/pharmacy/medicines') }}" class="btn-save-med me-2" style="background: linear-gradient(135deg, #607D8B, #90A4AE); color: white; box-shadow: none;">
                    <i class="fas fa-times"></i> {{ $strings['btn_cancel'] }}
                </a>
                <button type="submit" class="btn-save-med" id="saveMedBtnPh">
                    <i class="fas fa-save"></i> {{ $strings['btn_save'] }}
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {

        var jsStrings = {
            imgSize: "{{ $strings['js_img_size'] ?? 'Image size must be less than 2MB' }}",
            imgType: "{{ $strings['js_img_type'] ?? 'Please upload a valid image file' }}",
            nameReq: "{{ $strings['js_name_req'] ?? 'Medicine name is required' }}",
            nameMin: "{{ $strings['js_name_min'] ?? 'Medicine name must be at least 2 characters' }}",
            brandReq: "{{ $strings['js_brand_req'] ?? 'Brand name is required' }}",
            catReq: "{{ $strings['js_cat_req'] ?? 'Please select a health category' }}",
            priceReq: "{{ $strings['js_price_req'] ?? 'Price is required' }}",
            priceGt: "{{ $strings['js_price_gt'] ?? 'Price must be greater than 0' }}",
            stockReq: "{{ $strings['js_stock_req'] ?? 'Stock quantity is required' }}",
            stockNeg: "{{ $strings['js_stock_neg'] ?? 'Stock cannot be a negative value' }}",
            saving: "{{ $strings['js_saving'] ?? 'Saving...' }}",
            imgSelected: "{{ $strings['img_selected'] ?? 'Image Selected' }}"
        };

        /* ============ IMAGE UPLOAD PREVIEW ============ */
        $('#medImageInput').on('change', function() {
            var file = this.files[0];
            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    $('#err_m_image').text(jsStrings.imgSize).addClass('show');
                    $(this).val('');
                    return;
                }
                if (!file.type.match('image.*')) {
                    $('#err_m_image').text(jsStrings.imgType).addClass('show');
                    $(this).val('');
                    return;
                }

                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#uploadPreviewPh').html('<img src="' + e.target.result + '" style="max-height:120px;"><p class="mt-2"><i class="fas fa-check-circle" style="color:var(--primary-green);"></i> ' + jsStrings.imgSelected + '</p>');
                };
                reader.readAsDataURL(file);
                $('#err_m_image').text('').removeClass('show');
            }
        });

        /* ============ VALIDATION HELPERS ============ */
        function showFieldError($el, msg) {
            $el.addClass('error');
            $el.closest('.fg-ph').find('.err-ph').text(msg).addClass('show');
        }

        function clearFieldError($el) {
            $el.removeClass('error');
            $el.closest('.fg-ph').find('.err-ph').removeClass('show').text('');
        }

        /* ============ REAL-TIME VALIDATION ============ */
        $('.fc-ph, .fs-ph').on('input change', function() {
            if ($(this).hasClass('error') && $.trim($(this).val()) !== '') {
                clearFieldError($(this));
            }
        });

        /* ============ FORM VALIDATION ON SUBMIT ============ */
        $('#medicineFormPh').on('submit', function(e) {
            e.preventDefault();

            var isValid = true;
            $('.err-ph').removeClass('show').text('');
            $('.fc-ph, .fs-ph').removeClass('error');

            // Validate Medicine Name
            var name = $.trim($('#m_name').val());
            if (name === '') {
                showFieldError($('#m_name'), jsStrings.nameReq);
                isValid = false;
            } else if (name.length < 2) {
                showFieldError($('#m_name'), jsStrings.nameMin);
                isValid = false;
            }

            // Validate Brand
            var brand = $.trim($('#m_brand').val());
            if (brand === '') {
                showFieldError($('#m_brand'), jsStrings.brandReq);
                isValid = false;
            }

            // Validate Category
            var category = $('#m_category').val();
            if (category === '') {
                showFieldError($('#m_category'), jsStrings.catReq);
                isValid = false;
            }

            // Validate Price
            var price = parseFloat($('#m_price').val());
            if (!$('#m_price').val() || isNaN(price)) {
                showFieldError($('#m_price'), jsStrings.priceReq);
                isValid = false;
            } else if (price <= 0) {
                showFieldError($('#m_price'), jsStrings.priceGt);
                isValid = false;
            }

            // Validate Stock
            var stock = parseInt($('#m_stock').val());
            if ($('#m_stock').val() === '' || isNaN(stock)) {
                showFieldError($('#m_stock'), jsStrings.stockReq);
                isValid = false;
            } else if (stock < 0) {
                showFieldError($('#m_stock'), jsStrings.stockNeg);
                isValid = false;
            }

            if (!isValid) {
                // Scroll to the first validation error
                var $firstError = $('.fc-ph.error, .fs-ph.error').first();
                if ($firstError.length) {
                    $('html, body').animate({
                        scrollTop: $firstError.offset().top - 120
                    }, 400);
                    $firstError.focus();
                }
                return false;
            }

            var $btn = $('#saveMedBtnPh');
            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> ' + jsStrings.saving);
            this.submit();
        });

    });
</script>
@endsection