@extends('layouts.pharmacy')

@section('title', 'My Medicines')
@section('page_title')
<i class="fas fa-pills"></i> {{ app(\App\Services\GoogleTranslator::class)->translate('My Medicines') }}
@endsection

@section('styles')
<style>
    .med-header-ph {
        background: linear-gradient(135deg, var(--dark-green), var(--primary-green));
        border-radius: 18px;
        padding: 25px 30px;
        color: var(--white);
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }

    .med-header-ph h4 {
        margin: 0;
        font-weight: 800;
    }

    .med-header-ph p {
        margin: 0;
        opacity: 0.9;
        font-size: 0.9rem;
    }

    .btn-add-med-ph {
        background: var(--white);
        color: var(--primary-green);
        padding: 10px 22px;
        border-radius: 25px;
        font-weight: 700;
        font-size: 0.88rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: var(--transition);
        border: none;
    }

    .btn-add-med-ph:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        color: var(--dark-green);
    }

    .filter-bar-med {
        background: var(--white);
        border-radius: 14px;
        padding: 15px 20px;
        box-shadow: var(--shadow);
        margin-bottom: 20px;
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        align-items: center;
    }

    .med-card-ph {
        background: var(--white);
        border-radius: 14px;
        overflow: hidden;
        box-shadow: var(--shadow);
        transition: var(--transition);
        height: 100%;
    }

    .med-card-ph:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(46, 125, 50, 0.15);
    }

    .med-img-ph {
        height: 150px;
        background: var(--pale-green);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .med-img-ph i {
        font-size: 3rem;
        color: var(--accent-green);
    }

    .med-img-ph img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .stock-badge-ph {
        position: absolute;
        top: 8px;
        right: 8px;
        padding: 3px 10px;
        border-radius: 12px;
        font-size: 0.68rem;
        font-weight: 700;
        background: rgba(255, 255, 255, 0.95);
    }

    .stock-badge-ph.in {
        color: #2E7D32;
    }

    .stock-badge-ph.low {
        color: #FB8C00;
    }

    .stock-badge-ph.out {
        color: #C62828;
    }

    .med-body-ph {
        padding: 14px;
    }

    .med-cat-ph {
        font-size: 0.7rem;
        color: var(--primary-green);
        font-weight: 600;
        text-transform: uppercase;
    }

    .med-body-ph h6 {
        font-size: 0.92rem;
        font-weight: 700;
        color: var(--dark-text);
        margin: 4px 0;
    }

    .med-brand-ph {
        font-size: 0.75rem;
        color: var(--gray-text);
        margin-bottom: 8px;
    }

    .med-footer-ph {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 10px;
        border-top: 1px solid #F5F5F5;
    }

    .med-price-ph {
        font-size: 1.05rem;
        font-weight: 800;
        color: var(--primary-green);
    }

    .med-price-ph small {
        font-size: 0.7rem;
        color: #999;
        text-decoration: line-through;
        font-weight: 500;
    }

    .med-acts {
        display: flex;
        gap: 5px;
    }

    .med-act-btn {
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
        font-size: 0.72rem;
        text-decoration: none;
    }

    .med-act-btn.edit {
        background: #1976D2;
    }

    .med-act-btn.delete {
        background: #C62828;
    }

    .med-act-btn:hover {
        transform: translateY(-2px);
        color: var(--white);
    }
</style>
@endsection

@section('content')

@php
use App\Services\GoogleTranslator;

// Get medicines from controller; handle both Collection and Paginator
$medicinesCollection = $medicines ?? collect();

// If it's a paginator, extract the underlying items
if ($medicinesCollection instanceof \Illuminate\Pagination\LengthAwarePaginator) {
$medicinesCollection = $medicinesCollection->getCollection();
}

// If the collection is empty, use demo data (as Collection)
if ($medicinesCollection->isEmpty()) {
$demoMeds = collect([
(object)['id'=>1,'name'=>'Paracetamol 500mg','brand'=>'Crocin','category'=>'Fever & Pain','price'=>25,'mrp'=>30,'stock'=>150,'featured'=>1,'prescription_required'=>0,'image'=>null],
(object)['id'=>2,'name'=>'Vitamin C 500mg','brand'=>'Limcee','category'=>'Vitamins','price'=>180,'mrp'=>200,'stock'=>80,'featured'=>1,'prescription_required'=>0,'image'=>null],
(object)['id'=>3,'name'=>'Amoxicillin 250mg','brand'=>'Mox','category'=>'Antibiotic','price'=>85,'mrp'=>100,'stock'=>8,'featured'=>0,'prescription_required'=>1,'image'=>null],
(object)['id'=>4,'name'=>'Cough Syrup 100ml','brand'=>'Benadryl','category'=>'Cold & Cough','price'=>145,'mrp'=>160,'stock'=>5,'featured'=>0,'prescription_required'=>0,'image'=>null],
(object)['id'=>5,'name'=>'Insulin Injection','brand'=>'Humulin','category'=>'Diabetes','price'=>450,'mrp'=>500,'stock'=>0,'featured'=>0,'prescription_required'=>1,'image'=>null],
(object)['id'=>6,'name'=>'Antacid Tablets','brand'=>'ENO','category'=>'Digestive','price'=>60,'mrp'=>75,'stock'=>200,'featured'=>0,'prescription_required'=>0,'image'=>null],
(object)['id'=>7,'name'=>'Multivitamin','brand'=>'Revital','category'=>'Vitamins','price'=>320,'mrp'=>360,'stock'=>65,'featured'=>0,'prescription_required'=>0,'image'=>null],
(object)['id'=>8,'name'=>'BP Medicine','brand'=>'Amlong','category'=>'Heart Care','price'=>75,'mrp'=>90,'stock'=>15,'featured'=>0,'prescription_required'=>1,'image'=>null],
]);
} else {
$demoMeds = $medicinesCollection;
}

$strings = GoogleTranslator::translateBatch([
'header_title' => 'My Medicines',
'header_desc' => 'Manage your pharmacy inventory and product listings',
'btn_add' => 'Add New Medicine',
'search_placeholder' => 'Search medicine, brand...',
'filter_all_cats' => 'All Categories',
'filter_all_stock' => 'All Stock',
'stock_in' => 'In Stock',
'stock_low' => 'Low Stock',
'stock_out' => 'Out of Stock',
'badge_out' => 'Out',
'badge_low' => 'Low',
'js_delete_confirm' => 'Delete ":name"?'
]);
@endphp

<div class="med-header-ph">
    <div>
        <h4><i class="fas fa-pills me-2"></i> {{ $strings['header_title'] }} ({{ count($demoMeds) }})</h4>
        <p>{{ $strings['header_desc'] }}</p>
    </div>
    <a href="{{ url('/pharmacy/add-medicine') }}" class="btn-add-med-ph">
        <i class="fas fa-plus-circle"></i> {{ $strings['btn_add'] }}
    </a>
</div>

<div class="filter-bar-med">
    <div style="flex:1;position:relative;min-width:200px;">
        <i class="fas fa-search" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--primary-green);"></i>
        <input type="text" id="medSearchPh" class="search-input-ph" placeholder="{{ $strings['search_placeholder'] }}" style="padding-left:38px;width:100%;border:2px solid #E8E8E8;border-radius:25px;padding:10px 14px 10px 38px;font-size:0.88rem;outline:none;">
    </div>
    <select id="catFilterPh" class="filter-select-ph">
        <option value="">{{ $strings['filter_all_cats'] }}</option>
        <option value="Fever & Pain">{{ app(\App\Services\GoogleTranslator::class)->translate('Fever & Pain') }}</option>
        <option value="Cold & Cough">{{ app(\App\Services\GoogleTranslator::class)->translate('Cold & Cough') }}</option>
        <option value="Vitamins">{{ app(\App\Services\GoogleTranslator::class)->translate('Vitamins') }}</option>
        <option value="Antibiotic">{{ app(\App\Services\GoogleTranslator::class)->translate('Antibiotic') }}</option>
        <option value="Diabetes">{{ app(\App\Services\GoogleTranslator::class)->translate('Diabetes') }}</option>
        <option value="Heart Care">{{ app(\App\Services\GoogleTranslator::class)->translate('Heart Care') }}</option>
        <option value="Digestive">{{ app(\App\Services\GoogleTranslator::class)->translate('Digestive') }}</option>
    </select>
    <select id="stockFilterPh" class="filter-select-ph">
        <option value="">{{ $strings['filter_all_stock'] }}</option>
        <option value="in">{{ $strings['stock_in'] }}</option>
        <option value="low">{{ $strings['stock_low'] }}</option>
        <option value="out">{{ $strings['stock_out'] }}</option>
    </select>
</div>

<div class="row g-3" id="medGridPh">
    @foreach($demoMeds as $med)
    @php $sc = $med->stock <= 0 ? 'out' : ($med->stock < 20 ? 'low' : 'in' ); @endphp
            <div class="col-xl-3 col-lg-4 col-md-6 med-item-ph" data-cat="{{ $med->category }}" data-stock="{{ $sc }}">
            <div class="med-card-ph">
                <div class="med-img-ph">
                    @if(!empty($med->image))<img src="{{ asset('uploads/medicines/'.$med->image) }}" alt="{{ $med->name }}">@else<i class="fas fa-pills"></i>@endif
                    <span class="stock-badge-ph {{ $sc }}">
                        {{ $med->stock <= 0 ? $strings['badge_out'] : ($med->stock < 20 ? $strings['badge_low'].': '.$med->stock : $med->stock) }}
                    </span>
                </div>
                <div class="med-body-ph">
                    <div class="med-cat-ph">{{ app(\App\Services\GoogleTranslator::class)->translate($med->category) }}</div>
                    <h6>{{ app(\App\Services\GoogleTranslator::class)->translate($med->name) }}</h6>
                    <div class="med-brand-ph"><i class="fas fa-tag me-1"></i>{{ app(\App\Services\GoogleTranslator::class)->translate($med->brand) }}@if($med->prescription_required) · <span style="color:#E53935;">Rx</span>@endif</div>
                    <div class="med-footer-ph">
                        <div class="med-price-ph">₹{{ $med->price }}@if($med->mrp > $med->price)<small>₹{{ $med->mrp }}</small>@endif</div>
                        <div class="med-acts">
                            <a href="{{ url('/pharmacy/add-medicine?id='.$med->id) }}" class="med-act-btn edit" title="{{ app(\App\Services\GoogleTranslator::class)->translate('Edit') }}"><i class="fas fa-edit"></i></a>
                            <button type="button" class="med-act-btn delete btn-del-med-ph" data-id="{{ $med->id }}" data-name="{{ $med->name }}" title="{{ app(\App\Services\GoogleTranslator::class)->translate('Delete') }}"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>
</div>
@endforeach
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {

        var jsStrings = {
            deleteConfirm: @json($strings['js_delete_confirm'])
        };

        $('#medSearchPh').on('input', function() {
            var q = $(this).val().toLowerCase();
            $('.med-item-ph').each(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(q) > -1);
            });
        });

        $('#catFilterPh').on('change', function() {
            var c = $(this).val();
            if (!c) $('.med-item-ph').show();
            else {
                $('.med-item-ph').hide();
                $('.med-item-ph[data-cat="' + c + '"]').show();
            }
        });

        $('#stockFilterPh').on('change', function() {
            var s = $(this).val();
            if (!s) $('.med-item-ph').show();
            else {
                $('.med-item-ph').hide();
                $('.med-item-ph[data-stock="' + s + '"]').show();
            }
        });

        $('.btn-del-med-ph').on('click', function() {
            var id = $(this).data('id'),
                name = $(this).data('name');
            var msg = jsStrings.deleteConfirm.replace(':name', name);

            if (!confirm(msg)) return;

            var $f = $('<form>', {
                method: 'POST',
                action: '{{ url("/pharmacy/medicine/delete") }}'
            });
            $f.append('<input type="hidden" name="_token" value="{{ csrf_token() }}">');
            $f.append('<input type="hidden" name="medicine_id" value="' + id + '">');
            $f.append('<input type="hidden" name="_method" value="DELETE">');
            $('body').append($f);
            $f.submit();
        });
    });
</script>
@endsection