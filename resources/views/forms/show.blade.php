@extends('layouts.app')

@section('title', $form->name . ' - সাইমুম শিল্পীগোষ্ঠী')

@section('content')
<!-- Custom Styles for this page -->
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #4a90e2, #2a5ba0);
        --secondary-gradient: linear-gradient(135deg, #6a11cb, #2575fc);
        --accent-color: #4a90e2;
        --light-bg: #f8f9fa;
        --dark-bg: #1e293b;
        --card-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        --transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .form-header {
        background: var(--primary-gradient);
        border-radius: 15px 15px 0 0;
        padding: 2rem;
        color: white;
        text-align: center;
        margin-bottom: -2rem;
        position: relative;
        z-index: 1;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }
    
    .form-container {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: var(--card-shadow);
        transition: var(--transition);
    }
    
    .form-container:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
    }
    
    .form-body {
        padding: 3rem;
        background: white;
    }
    
    .section-title {
        position: relative;
        padding-bottom: 15px;
        margin: 2rem 0 1.5rem;
        font-weight: 700;
        color: #2a5ba0;
    }
    
    .section-title::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 4px;
        background: var(--primary-gradient);
        border-radius: 2px;
    }
    
    .form-control, .form-select {
        border: 2px solid #e1e5eb;
        padding: 14px 18px;
        border-radius: 12px;
        transition: var(--transition);
        background: #fff;
        font-size: 1rem;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--accent-color);
        box-shadow: 0 0 0 0.25rem rgba(74, 144, 226, 0.25);
        background: #fff;
    }
    
    .form-label {
        font-weight: 600;
        margin-bottom: 0.75rem;
        color: #333;
        display: flex;
        align-items: center;
    }
    
    .form-label i {
        margin-right: 8px;
        font-size: 1.1rem;
        color: var(--accent-color);
    }
    
    .btn-primary {
        background: var(--primary-gradient);
        border: none;
        padding: 12px 25px;
        font-weight: 600;
        transition: var(--transition);
        border-radius: 50px;
        font-size: 1.1rem;
        box-shadow: 0 5px 15px rgba(42, 91, 160, 0.3);
    }
    
    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(42, 91, 160, 0.4);
    }
    
    .btn-outline-primary {
        border: 2px solid var(--accent-color);
        color: var(--accent-color);
        padding: 12px 25px;
        font-weight: 600;
        transition: var(--transition);
        border-radius: 50px;
        font-size: 1.1rem;
    }
    
    .btn-outline-primary:hover {
        background: var(--primary-gradient);
        border-color: var(--accent-color);
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(42, 91, 160, 0.3);
    }
    
    .subject-option {
        transition: var(--transition);
        background: #fff;
        border: 2px solid #e1e5eb;
        border-radius: 12px;
        padding: 1.25rem;
        height: 100%;
        cursor: pointer;
    }
    
    .subject-option:hover {
        border-color: var(--accent-color);
        background: rgba(74, 144, 226, 0.05);
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }
    
    .subject-option.active {
        border-color: var(--accent-color);
        background: rgba(74, 144, 226, 0.1);
    }
    
    .fee-badge {
        background: linear-gradient(135deg, #eef2ff, #e0e7ff);
        color: #4a90e2;
        font-weight: 700;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.9rem;
    }
    
    .form-check-input {
        width: 1.5rem;
        height: 1.5rem;
        margin-top: 0;
        border: 2px solid #ced4da;
        transition: var(--transition);
    }
    
    .form-check-input:checked {
        background-color: var(--accent-color);
        border-color: var(--accent-color);
    }
    
    .alert {
        border-radius: 12px;
        border: none;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .alert-danger {
        background: linear-gradient(135deg, #fff5f5, #fed7d7);
        border-left: 4px solid #e53e3e;
    }
    
    .alert-success {
        background: linear-gradient(135deg, #f0fff4, #c6f6d5);
        border-left: 4px solid #38a169;
    }
    
    :root.dark-mode .form-body {
        background: var(--dark-bg);
    }
    
    :root.dark-mode .form-control, 
    :root.dark-mode .form-select {
        background: #2d3748;
        border-color: #4a5568;
        color: #e2e8f0;
    }
    
    :root.dark-mode .form-label {
        color: #e2e8f0;
    }
    
    :root.dark-mode .section-title {
        color: #90cdf4;
    }
    
    :root.dark-mode .subject-option {
        background: #2d3748;
        border-color: #4a5568;
    }
    
    :root.dark-mode .subject-option:hover {
        background: #4a5568;
        border-color: #63b3ed;
    }
    
    :root.dark-mode .form-text {
        color: #a0aec0 !important;
    }
    
    .file-upload-wrapper {
        position: relative;
    }
    
    .file-input {
        display: none;
    }
    
    .file-upload-area {
        border: 2px dashed #ced4da;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: var(--transition);
        background-color: #f8f9fa;
    }
    
    .file-upload-area:hover {
        border-color: var(--accent-color);
        background-color: rgba(74, 144, 226, 0.05);
    }
    
    .file-upload-area.dragover {
        border-color: var(--accent-color);
        background-color: rgba(74, 144, 226, 0.1);
        transform: scale(1.02);
    }
    
    .file-upload-icon {
        color: #6c757d;
        margin-bottom: 1rem;
    }
    
    .file-upload-text p {
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #495057;
    }
    
    .file-selected-info .badge {
        font-size: 0.9rem;
        padding: 0.75rem 1.25rem;
        border-radius: 50px;
    }
    
    :root.dark-mode .file-upload-area {
        background-color: #2d3748;
        border-color: #4a5568;
    }
    
    :root.dark-mode .file-upload-area:hover {
        border-color: #63b3ed;
        background-color: rgba(74, 144, 226, 0.1);
    }
    
    :root.dark-mode .file-upload-text p {
        color: #e2e8f0;
    }
    
    :root.dark-mode .file-upload-icon {
        color: #a0aec0;
    }
    
    /* Enhanced date input styling */
    .date-input {
        position: relative;
        padding: 14px 18px;
        border: 2px solid #e1e5eb;
        border-radius: 12px;
        transition: var(--transition);
        background: #fff;
        font-size: 1rem;
        cursor: pointer;
    }
    
    .date-input:focus {
        border-color: var(--accent-color);
        box-shadow: 0 0 0 0.25rem rgba(74, 144, 226, 0.25);
        background: #fff;
    }
    
    .date-input::-webkit-calendar-picker-indicator {
        cursor: pointer;
        padding: 8px;
        border-radius: 8px;
        background: rgba(74, 144, 226, 0.1);
        transition: var(--transition);
    }
    
    .date-input::-webkit-calendar-picker-indicator:hover {
        background: rgba(74, 144, 226, 0.2);
    }
    
    .form-text {
        margin-top: 0.5rem;
        font-size: 0.875rem;
        color: #6c757d;
    }
    
    .invalid-feedback {
        display: none;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 0.875rem;
        color: #dc3545;
    }
    
    /* Custom Date Picker Styles */
    .custom-date-picker {
        position: relative;
        display: flex;
        align-items: center;
    }
    
    .date-input-display {
        flex: 1;
        padding: 14px 18px;
        border: 2px solid #e1e5eb;
        border-radius: 12px 0 0 12px;
        transition: var(--transition);
        background: #fff;
        font-size: 1rem;
        cursor: pointer;
    }
    
    .date-input-display:focus {
        border-color: var(--accent-color);
        box-shadow: 0 0 0 0.25rem rgba(74, 144, 226, 0.25);
    }
    
    .date-picker-toggle {
        background: var(--accent-color);
        color: white;
        border: none;
        padding: 0 15px;
        height: 52px;
        border-radius: 0 12px 12px 0;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .date-picker-toggle:hover {
        background: #3a7bc8;
    }
    
    .date-picker-calendar {
        position: absolute;
        top: 100%;
        left: 0;
        width: 300px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        z-index: 1000;
        margin-top: 5px;
        animation: fadeIn 0.3s ease;
    }
    
    .calendar-header {
        display: flex;
        align-items: center;
        padding: 15px;
        background: var(--accent-color);
        color: white;
        border-radius: 12px 12px 0 0;
    }
    
    .calendar-nav {
        background: none;
        border: none;
        color: white;
        font-size: 1.2rem;
        cursor: pointer;
        padding: 5px;
        border-radius: 5px;
        transition: var(--transition);
    }
    
    .calendar-nav:hover {
        background: rgba(255, 255, 255, 0.2);
    }
    
    .calendar-title {
        flex: 1;
        text-align: center;
        font-weight: 600;
    }
    
    .calendar-body {
        padding: 15px;
    }
    
    .weekdays {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 5px;
        margin-bottom: 10px;
    }
    
    .weekday {
        text-align: center;
        font-weight: 600;
        font-size: 0.85rem;
        color: #6c757d;
        padding: 8px 0;
    }
    
    .days {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 5px;
    }
    
    .day {
        text-align: center;
        padding: 10px 5px;
        border-radius: 8px;
        cursor: pointer;
        transition: var(--transition);
        font-size: 0.9rem;
    }
    
    .day:hover {
        background: rgba(74, 144, 226, 0.1);
    }
    
    .day.selected {
        background: var(--accent-color);
        color: white;
    }
    
    .day.disabled {
        color: #ced4da;
        cursor: not-allowed;
    }
    
    .day.disabled:hover {
        background: none;
    }
    
    .day.today {
        background: rgba(74, 144, 226, 0.2);
        font-weight: 600;
    }
    
    .day.other-month {
        color: #adb5bd;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    :root.dark-mode .date-picker-calendar {
        background: #2d3748;
        color: #e2e8f0;
    }
    
    :root.dark-mode .day:hover {
        background: rgba(74, 144, 226, 0.2);
    }
    
    :root.dark-mode .day.disabled {
        color: #4a5568;
    }
    
    :root.dark-mode .weekday {
        color: #a0aec0;
    }
    
    @media (max-width: 768px) {
        .form-body {
            padding: 2rem 1.5rem;
        }
        
        .form-header {
            padding: 1.5rem;
        }
        
        .btn {
            width: 100%;
            margin-bottom: 0.5rem;
        }
    }
    
    /* Three-field Date Input Styles */
    .date-part {
        padding: 14px 18px;
        border: 2px solid #e1e5eb;
        border-radius: 12px;
        transition: var(--transition);
        background: #fff;
        font-size: 1rem;
        text-align: center;
    }
    
    .date-part:focus {
        border-color: var(--accent-color);
        box-shadow: 0 0 0 0.25rem rgba(74, 144, 226, 0.25);
        background: #fff;
    }
    
    .day-input::-webkit-outer-spin-button,
    .day-input::-webkit-inner-spin-button,
    .year-input::-webkit-outer-spin-button,
    .year-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        appearance: none;
        margin: 0;
    }
    
    .day-input, .year-input {
        -moz-appearance: textfield;
        appearance: textfield;
    }
    
    .month-input {
        padding: 14px 18px;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 18px center;
        background-size: 16px 12px;
    }
    
    :root.dark-mode .date-part {
        background: #2d3748;
        border-color: #4a5568;
        color: #e2e8f0;
    }
    
    :root.dark-mode .month-input {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23e2e8f0' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
    }
    
    /* Field-specific error highlighting */
    .has-error .form-control, 
    .has-error .form-select {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
    }
    
    .has-error .form-label {
        color: #dc3545;
    }
    
    .is-invalid {
        border-color: #dc3545;
    }
    
</style>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Modern Form Header -->
            <div class="form-header animate__animated animate__fadeInDown">
                <h1 class="display-5 fw-bold mb-3">{{ $form->name }}</h1>
                @if($form->description)
                    <p class="lead mb-0">{{ $form->description }}</p>
                @endif
            </div>
            
            <div class="form-container">
                <div class="form-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('forms.submit', $form) }}" enctype="multipart/form-data">
                        @csrf

                        @if($errors->any())
                            <div class="alert alert-danger shadow-sm">
                                <div class="fw-semibold mb-1">
                                    <i class="fas fa-exclamation-triangle me-2"></i>ফর্মে কিছু সমস্যা আছে:
                                </div>
                                <ul class="mb-0 ps-3">
                                    @foreach($errors->all() as $err)
                                        <li>{{ $err }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @php
                            // No static basic fields now; all personal info must come from form builder elements.
                        @endphp

                        @php
                            $advancedAddress = false; // dual present/permanent custom UI
                            $renderAnyAddress = false; // whether we should render any address block at all
                            $legacyCustomAddress = false; // single (legacy) custom UI

                            $fieldNames = [];
                            if(isset($form->fields['elements'])) {
                                $fieldNames = collect($form->fields['elements'])->pluck('fieldName')->toArray();
                            }

                            // Base (present) address field names that indicate the form builder actually included address fields
                            $baseAddressFields = ['division','district','upazila','address_details'];
                            $hasBaseAddress = count(array_intersect($baseAddressFields, $fieldNames)) > 0;
                            $hasPermanent = count(array_intersect(['permanent_division','permanent_district','permanent_upazila','permanent_address_details'], $fieldNames)) > 0;

                            if($hasBaseAddress && $hasPermanent) {
                                $advancedAddress = true;
                                $renderAnyAddress = true;
                            } elseif($hasBaseAddress) {
                                // Only present address fields in builder: show single legacy custom block
                                $legacyCustomAddress = true;
                                $renderAnyAddress = true;
                            } else {
                                // Builder did not include ANY address fields -> do not auto render address UI
                                $advancedAddress = false;
                                $legacyCustomAddress = false;
                                $renderAnyAddress = false;
                            }
                        @endphp

                        {{-- Address UI will now render inline at the position of the address section (if any). If no section, we will fallback to rendering at top only when needed. --}}
                        @php $renderedAddressInline = false; @endphp
                        @if(!$advancedAddress && !$legacyCustomAddress)
                            {{-- No address fields at all; nothing to render. --}}
                        @endif

                        <!-- Dynamic Fields based on form configuration -->
                        @if(isset($form->fields['elements']))
                            @php
                                // Ensure deterministic ordering if 'order' indices exist
                                $elements = $form->fields['elements'];
                                // Backward compatibility: map legacy fieldName 'desired_subject_or_department' to new 'desired_subject'
                                foreach($elements as &$el){
                                    if(isset($el['fieldName']) && $el['fieldName']==='desired_subject_or_department'){
                                        $el['fieldName'] = 'desired_subject';
                                        // If legacy label still contains '/বিভাগ', shorten it
                                        if(isset($el['label']) && Str::contains($el['label'],'/')){
                                            $el['label'] = preg_replace('#/.*$#','',$el['label']);
                                        }
                                    }
                                }
                                unset($el);
                                $hasOrder = collect($elements)->every(function($e){ return is_array($e) && array_key_exists('order',$e); });
                                if($hasOrder) {
                                    usort($elements, function($a,$b){ return ($a['order'] ?? 0) <=> ($b['order'] ?? 0); });
                                }
                            @endphp
                            @php
                                $skipFields = [];
                                if($advancedAddress || $legacyCustomAddress) {
                                    // Skip dynamic rendering of address-related fields because we already rendered custom UI
                                    $skipFields = [
                                        // Atomic present address fields (we render custom block instead)
                                        'division','district','upazila','address_details',
                                        // Do NOT include the 'address' section anchor so we can inject custom UI there
                                        'is_permanent_address_same_as_present','permanent_division',
                                        'permanent_district','permanent_upazila','permanent_address_details',
                                        'permanent_address_combined'
                                    ];
                                }
                            @endphp
                            @foreach($elements as $element)
                                @php
                                    $fname = $element['fieldName'] ?? null;
                                    // Normalize 'required' which may come as true/false / 'true'/'false' / '1'/'0'
                                    $isRequired = false;
                                    if(array_key_exists('required',$element)) {
                                        $val = $element['required'];
                                        if(is_bool($val)) { $isRequired = $val; }
                                        else { $isRequired = filter_var($val, FILTER_VALIDATE_BOOLEAN); }
                                    }
                                @endphp
                                @if(($advancedAddress || $legacyCustomAddress) && ($fname && in_array($fname, $skipFields)))
                                    @continue
                                @endif
                                @if($element['type'] === 'section')
                                    @if($fname === 'address' && ($advancedAddress || $legacyCustomAddress))
                                        {{-- Render the address section heading and custom address UI inline here --}}
                                        <h4 class="section-title">{{ $element['label'] }}</h4>
                                        @php $renderedAddressInline = true; @endphp
                                        @if($advancedAddress)
                                            @php $addrReq = $isRequired; @endphp
                                            <div class="mb-5">
                                                <h5 class="mb-4 fw-semibold d-flex align-items-center">
                                                    <i class='bx bx-home-circle me-2'></i>বর্তমান ঠিকানা @if($addrReq)<span class="text-danger">*</span>@endif
                                                </h5>
                                                <div class="row g-4">
                                                    <div class="col-md-4">
                                                        <label for="division" class="form-label">
                                                            <i class='bx bx-map'></i>বিভাগ @if($addrReq)<span class="text-danger">*</span>@endif
                                                        </label>
                                                        <select class="form-select" id="division" name="division" @if($addrReq) required @endif>
                                                            <option value="">বিভাগ নির্বাচন করুন</option>
                                                            @foreach($divisions as $division)
                                                                <option value="{{ $division['name'] }}">{{ $division['name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="district" class="form-label">
                                                            <i class='bx bx-map-pin'></i>জেলা @if($addrReq)<span class="text-danger">*</span>@endif
                                                        </label>
                                                        <select class="form-select" id="district" name="district" @if($addrReq) required @endif disabled>
                                                            <option value="">জেলা নির্বাচন করুন</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="upazila" class="form-label">
                                                            <i class='bx bx-buildings'></i>উপজেলা @if($addrReq)<span class="text-danger">*</span>@endif
                                                        </label>
                                                        <select class="form-select" id="upazila" name="upazila" @if($addrReq) required @endif disabled>
                                                            <option value="">উপজেলা নির্বাচন করুন</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="detailed_address" class="form-label">
                                                            <i class='bx bx-detail'></i>বিস্তারিত ঠিকানা @if($addrReq)<span class="text-danger">*</span>@endif
                                                        </label>
                                                        <textarea class="form-control" id="detailed_address" name="detailed_address" rows="3" placeholder="গ্রাম/পাড়া/রাস্তা, হোল্ডিং নং ইত্যাদি" @if($addrReq) required @endif></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-4 form-check">
                                                <input type="checkbox" class="form-check-input" id="same_as_present" name="is_permanent_address_same_as_present" value="1">
                                                <label class="form-check-label fw-medium" for="same_as_present">
                                                    বর্তমান ও স্থায়ী ঠিকানা একই
                                                </label>
                                            </div>
                                            <div class="mb-5" id="permanent_address_block">
                                                <h5 class="mb-4 fw-semibold d-flex align-items-center">
                                                    <i class='bx bx-home-heart me-2'></i>স্থায়ী ঠিকানা
                                                </h5>
                                                <div class="row g-4">
                                                    <div class="col-md-4">
                                                        <label for="permanent_division" class="form-label">
                                                            <i class='bx bx-map'></i>বিভাগ
                                                        </label>
                                                        <select class="form-select" id="permanent_division" name="permanent_division">
                                                            <option value="">বিভাগ নির্বাচন করুন</option>
                                                            @foreach($divisions as $division)
                                                                <option value="{{ $division['name'] }}">{{ $division['name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="permanent_district" class="form-label">
                                                            <i class='bx bx-map-pin'></i>জেলা
                                                        </label>
                                                        <select class="form-select" id="permanent_district" name="permanent_district" disabled>
                                                            <option value="">জেলা নির্বাচন করুন</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="permanent_upazila" class="form-label">
                                                            <i class='bx bx-buildings'></i>উপজেলা
                                                        </label>
                                                        <select class="form-select" id="permanent_upazila" name="permanent_upazila" disabled>
                                                            <option value="">উপজেলা নির্বাচন করুন</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="permanent_address_details" class="form-label">
                                                            <i class='bx bx-detail'></i>বিস্তারিত ঠিকানা
                                                        </label>
                                                        <textarea class="form-control" id="permanent_address_details" name="permanent_address_details" rows="3" placeholder="গ্রাম/পাড়া/রাস্তা, হোল্ডিং নং ইত্যাদি"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" id="address" name="address">
                                            <input type="hidden" id="permanent_address_combined" name="permanent_address_combined">
                                        @elseif($legacyCustomAddress)
                                            @php $addrReq = $isRequired; @endphp
                                            <div class="mb-5">
                                                <label class="form-label d-none">ঠিকানা @if($addrReq)<span class="text-danger">*</span>@endif</label>
                                                <div class="row g-4">
                                                    <div class="col-md-4">
                                                        <label for="division" class="form-label">
                                                            <i class='bx bx-map'></i>বিভাগ @if($addrReq)<span class="text-danger">*</span>@endif
                                                        </label>
                                                        <select class="form-select" id="division" name="division" @if($addrReq) required @endif>
                                                            <option value="">বিভাগ নির্বাচন করুন</option>
                                                            @foreach($divisions as $division)
                                                                <option value="{{ $division['name'] }}">{{ $division['name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="district" class="form-label">
                                                            <i class='bx bx-map-pin'></i>জেলা @if($addrReq)<span class="text-danger">*</span>@endif
                                                        </label>
                                                        <select class="form-select" id="district" name="district" @if($addrReq) required @endif disabled>
                                                            <option value="">জেলা নির্বাচন করুন</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="upazila" class="form-label">
                                                            <i class='bx bx-buildings'></i>উপজেলা @if($addrReq)<span class="text-danger">*</span>@endif
                                                        </label>
                                                        <select class="form-select" id="upazila" name="upazila" @if($addrReq) required @endif disabled>
                                                            <option value="">উপজেলা নির্বাচন করুন</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="detailed_address" class="form-label">
                                                            <i class='bx bx-detail'></i>বিস্তারিত ঠিকানা @if($addrReq)<span class="text-danger">*</span>@endif
                                                        </label>
                                                        <textarea class="form-control" id="detailed_address" name="detailed_address" rows="3" placeholder="গ্রাম/পাড়া/রাস্তা, হোল্ডিং নং ইত্যাদি" @if($addrReq) required @endif></textarea>
                                                    </div>
                                                </div>
                                                <input type="hidden" id="address" name="address">
                                            </div>
                                        @endif
                                    @else
                                        <h4 class="section-title">{{ $element['label'] }}</h4>
                                    @endif
                                @elseif($element['type'] === 'text')
                                    <div class="mb-4 @if($errors->has($element['fieldName'])) has-error @endif">
                                        <label for="{{ $element['fieldName'] }}" class="form-label">
                                            <i class='bx bx-font'></i>{{ $element['label'] }}
                                            @if($isRequired)
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>
                                        @if(($element['fieldName'] ?? '') === 'desired_subject')
                                            @if(isset($subjects) && $subjects->count())
                                                <div id="desiredSubjectGroup" class="row g-4 mt-1" aria-describedby="desiredSubjectHelp" role="group" aria-label="ভর্তিচ্ছু বিষয় তালিকা">
                                                    @foreach($subjects as $sub)
                                                        <div class="col-12 col-md-6">
                                                            <div class="subject-option h-100 position-relative">
                                                                <div class="form-check m-0 d-flex align-items-start">
                                                                    <input class="form-check-input subject-checkbox me-3 mt-1" type="checkbox" name="desired_subject[]" id="desired_subject_{{ $sub->id }}" value="{{ $sub->code }}" aria-describedby="desiredSubjectHelp">
                                                                    <label class="form-check-label d-block w-100" for="desired_subject_{{ $sub->id }}">
                                                                        <div class="d-flex justify-content-between align-items-start">
                                                                            <span class="fw-semibold">{{ $sub->name }}</span>
                                                                        </div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div id="desiredSubjectHelp" class="form-text mt-3">এক বা একাধিক বিষয় নির্বাচন করুন @if($isRequired)(কমপক্ষে ১টি আবশ্যক)@endif।</div>
                                                <div id="desiredSubjectError" class="invalid-feedback d-block" style="display:none">কমপক্ষে ১টি বিষয় নির্বাচন করুন।</div>
                                                <script>
                                                    (function(){
                                                        const group = document.getElementById('desiredSubjectGroup');
                                                        const checkboxes = group.querySelectorAll('.subject-checkbox');
                                                        const errorBox = document.getElementById('desiredSubjectError');
                                                        const formEl = group.closest('form');
                                                        const pricingEnabled = <?php echo \Illuminate\Support\Facades\Config::get('payment.enabled') ? 'true' : 'false'; ?>;
                                                        const subjectRequired = <?php echo $isRequired ? 'true' : 'false'; ?>;
                                                        
                                                        // Add active class to selected subjects
                                                        checkboxes.forEach(cb => {
                                                            cb.addEventListener('change', function() {
                                                                const option = this.closest('.subject-option');
                                                                if (this.checked) {
                                                                    option.classList.add('active');
                                                                } else {
                                                                    option.classList.remove('active');
                                                                }
                                                                validateSelection(false);
                                                                updateTotal();
                                                            });
                                                        });
                                                        
                                                        function validateSelection(show){
                                                            if(!subjectRequired){
                                                                // If not required, never block
                                                                errorBox.style.display='none';
                                                                group.classList.remove('needs-selection');
                                                                return true;
                                                            }
                                                            const any = Array.from(checkboxes).some(cb=>cb.checked);
                                                            if(!any && show){
                                                                errorBox.style.display='block';
                                                                group.classList.add('needs-selection');
                                                            } else if(any) {
                                                                errorBox.style.display='none';
                                                                group.classList.remove('needs-selection');
                                                            }
                                                            return any;
                                                        }
                                                        
                                                        function updateTotal(){
                                                            if(!pricingEnabled) return;
                                                            let total = 0;
                                                            checkboxes.forEach(cb=>{
                                                                if(cb.checked){
                                                                    const wrap = cb.closest('.subject-option');
                                                                    if(wrap){
                                                                        const fee = parseFloat(wrap.getAttribute('data-fee')||'0');
                                                                        if(!isNaN(fee)) total += fee;
                                                                    }
                                                                }
                                                            });
                                                            const totalBadge = document.getElementById('runningTotalBadge');
                                                            if(totalBadge) {
                                                                totalBadge.textContent = 'মোট: '+ total.toLocaleString('bn-BD', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                                                            }
                                                        }
                                                        
                                                        formEl.addEventListener('submit', function(e){
                                                            if(!validateSelection(true)){
                                                                e.preventDefault();
                                                                group.scrollIntoView({behavior:'smooth', block:'center'});
                                                            }
                                                        });
                                                        
                                                        updateTotal();
                                                    })();
                                                </script>
                                            @else
                                                <div class="alert alert-warning py-3 rounded-3" role="alert">
                                                    <i class='bx bx-info-circle me-2'></i>বর্তমানে কোনো বিষয় সক্রিয় নেই। পরে চেষ্টা করুন।
                                                </div>
                                            @endif
                                        @else
                                            <input
                                                type="text"
                                                class="form-control @if($errors->has($element['fieldName'])) is-invalid @endif"
                                                id="{{ $element['fieldName'] }}"
                                                name="{{ $element['fieldName'] }}"
                                                @if($isRequired) required @endif
                                                placeholder="{{ $element['label'] }}"
                                                value="{{ old($element['fieldName']) }}"
                                            >
                                            @if($errors->has($element['fieldName']))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first($element['fieldName']) }}
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                @elseif($element['type'] === 'email')
                                    <div class="mb-4 @if($errors->has($element['fieldName'])) has-error @endif">
                                        <label for="{{ $element['fieldName'] }}" class="form-label">
                                            <i class='bx bx-envelope'></i>{{ $element['label'] }}
                                            @if($isRequired)
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>
                                        <input
                                            type="email"
                                            class="form-control @if($errors->has($element['fieldName'])) is-invalid @endif"
                                            id="{{ $element['fieldName'] }}"
                                            name="{{ $element['fieldName'] }}"
                                            @if($isRequired) required @endif
                                            placeholder="{{ $element['label'] }}"
                                            value="{{ old($element['fieldName']) }}"
                                        >
                                        @if($errors->has($element['fieldName']))
                                            <div class="invalid-feedback">
                                                {{ $errors->first($element['fieldName']) }}
                                            </div>
                                        @endif
                                    </div>
                                    
                                @elseif($element['type'] === 'number')
                                    <div class="mb-4 @if($errors->has($element['fieldName'])) has-error @endif">
                                        <label for="{{ $element['fieldName'] }}" class="form-label">
                                            <i class='bx bx-hash'></i>{{ $element['label'] }}
                                            @if($isRequired)
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>
                                        <input
                                            type="number"
                                            class="form-control @if($errors->has($element['fieldName'])) is-invalid @endif"
                                            id="{{ $element['fieldName'] }}"
                                            name="{{ $element['fieldName'] }}"
                                            @if($isRequired) required @endif
                                            placeholder="{{ $element['label'] }}"
                                            value="{{ old($element['fieldName']) }}"
                                        >
                                        @if($errors->has($element['fieldName']))
                                            <div class="invalid-feedback">
                                                {{ $errors->first($element['fieldName']) }}
                                            </div>
                                        @endif
                                    </div>
                                @elseif($element['type'] === 'textarea')
                                    <div class="mb-4 @if($errors->has($element['fieldName'])) has-error @endif">
                                        <label for="{{ $element['fieldName'] }}" class="form-label">
                                            <i class='bx bx-text'></i>{{ $element['label'] }}
                                            @if($isRequired)
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>
                                        <textarea
                                            class="form-control @if($errors->has($element['fieldName'])) is-invalid @endif"
                                            id="{{ $element['fieldName'] }}"
                                            name="{{ $element['fieldName'] }}"
                                            rows="5"
                                            @if($isRequired) required @endif
                                            placeholder="{{ $element['label'] }}"
                                        >{{ old($element['fieldName']) }}</textarea>
                                        @if($errors->has($element['fieldName']))
                                            <div class="invalid-feedback">
                                                {{ $errors->first($element['fieldName']) }}
                                            </div>
                                        @endif
                                    </div>
                                    
                                @elseif($element['type'] === 'select')
                                    <div class="mb-4 @if($errors->has($element['fieldName'])) has-error @endif">
                                        <label for="{{ $element['fieldName'] }}" class="form-label">
                                            <i class='bx bx-chevron-down'></i>{{ $element['label'] }}
                                            @if($isRequired)
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>
                                        <select
                                            class="form-select @if($errors->has($element['fieldName'])) is-invalid @endif"
                                            id="{{ $element['fieldName'] }}"
                                            name="{{ $element['fieldName'] }}"
                                            @if($isRequired) required @endif
                                        >
                                            <option value="">নির্বাচন করুন</option>
                                            @if(isset($element['options']) && is_array($element['options']))
                                                @foreach($element['options'] as $option)
                                                    @if(is_string($option))
                                                        <option value="{{ $option }}" @if(old($element['fieldName']) == $option) selected @endif>{{ $option }}</option>
                                                    @elseif(is_array($option))
                                                        @if(isset($option['value']) && isset($option['label']))
                                                            <option value="{{ $option['value'] }}" @if(old($element['fieldName']) == $option['value']) selected @endif>{{ $option['label'] }}</option>
                                                        @else
                                                            {{-- Handle simple array values properly --}}
                                                            @foreach($option as $key => $value)
                                                                @if(is_string($value))
                                                                    <option value="{{ $value }}" @if(old($element['fieldName']) == $value) selected @endif>{{ $value }}</option>
                                                                @elseif(is_numeric($value))
                                                                    <option value="{{ $value }}" @if(old($element['fieldName']) == $value) selected @endif>{{ $value }}</option>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @elseif(is_numeric($option))
                                                        <option value="{{ $option }}" @if(old($element['fieldName']) == $option) selected @endif>{{ $option }}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                        @if($errors->has($element['fieldName']))
                                            <div class="invalid-feedback">
                                                {{ $errors->first($element['fieldName']) }}
                                            </div>
                                        @endif
                                    </div>
                                    
                                @elseif($element['type'] === 'radio')
                                    <div class="mb-4 @if($errors->has($element['fieldName'])) has-error @endif">
                                        <label class="form-label">
                                            <i class='bx bx-radio-circle-marked'></i>{{ $element['label'] }}
                                            @if($isRequired)
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>
                                        <div class="mt-3">
                                            @if(isset($element['options']) && is_array($element['options']))
                                                @foreach($element['options'] as $option)
                                                    <div class="form-check mb-3 p-3 border rounded-3" style="background-color: rgba(74, 144, 226, 0.05);">
                                                        <input
                                                            class="form-check-input"
                                                            type="radio"
                                                            name="{{ $element['fieldName'] }}"
                                                            id="{{ $element['fieldName'] . '_' . $loop->index }}"
                                                            value="{{ $option }}"
                                                            @if($isRequired && $loop->first) required @endif
                                                            @if(old($element['fieldName']) == $option) checked @endif
                                                        >
                                                        <label class="form-check-label fw-medium" for="{{ $element['fieldName'] . '_' . $loop->index }}">
                                                            {{ $option }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        @if($errors->has($element['fieldName']))
                                            <div class="invalid-feedback d-block">
                                                {{ $errors->first($element['fieldName']) }}
                                            </div>
                                        @endif
                                    </div>
                                @elseif($element['type'] === 'checkbox')
                                    <div class="mb-4 @if($errors->has($element['fieldName'])) has-error @endif">
                                        <div class="form-check p-3 border rounded-3" style="background-color: rgba(74, 144, 226, 0.05);">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                name="{{ $element['fieldName'] }}"
                                                id="{{ $element['fieldName'] }}"
                                                @if($isRequired) required @endif
                                                @if(old($element['fieldName'])) checked @endif
                                            >
                                            <label class="form-check-label fw-medium" for="{{ $element['fieldName'] }}">
                                                <i class='bx bx-checkbox-checked me-2'></i>{{ $element['label'] }}
                                                @if($isRequired)
                                                    <span class="text-danger">*</span>
                                                @endif
                                            </label>
                                        </div>
                                        @if($errors->has($element['fieldName']))
                                            <div class="invalid-feedback d-block">
                                                {{ $errors->first($element['fieldName']) }}
                                            </div>
                                        @endif
                                    </div>
                                @elseif($element['type'] === 'file')
                                    <div class="mb-4 @if($errors->has($element['fieldName'])) has-error @endif">
                                        <label for="{{ $element['fieldName'] }}" class="form-label">
                                            <i class='bx bx-file'></i>{{ $element['label'] }}
                                            @if($isRequired)
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>
                                        <div class="file-upload-wrapper">
                                            @php
                                                $fieldId = $element['fieldName'];
                                            @endphp
                                            <input
                                                type="file"
                                                class="file-input @if($errors->has($element['fieldName'])) is-invalid @endif"
                                                id="{{ $fieldId }}"
                                                name="{{ $fieldId }}"
                                                @if($isRequired) required @endif
                                            >
                                            <div class="file-upload-area" id="{{ $fieldId }}_dropzone">
                                                <div class="file-upload-icon">
                                                    <i class='bx bx-cloud-upload bx-lg'></i>
                                                </div>
                                                <div class="file-upload-text">
                                                    <p class="mb-1">ফাইল নির্বাচন করুন অথবা এখানে টেনে আনুন</p>
                                                    <small class="text-muted">JPG, PNG, PDF (সর্বোচ্চ 5MB)</small>
                                                </div>
                                            </div>
                                            <div class="file-selected-info mt-2" id="{{ $fieldId }}_info" style="display: none;">
                                                <span class="badge bg-success">
                                                    <i class='bx bx-check-circle me-1'></i>
                                                    <span id="{{ $fieldId }}_name"></span>
                                                </span>
                                            </div>
                                        </div>
                                        @if($errors->has($element['fieldName']))
                                            <div class="invalid-feedback d-block">
                                                {{ $errors->first($element['fieldName']) }}
                                            </div>
                                        @endif
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                const fileInput = document.getElementById('{{ $fieldId }}');
                                                const dropZone = document.getElementById('{{ $fieldId }}_dropzone');
                                                const infoDiv = document.getElementById('{{ $fieldId }}_info');
                                                const nameSpan = document.getElementById('{{ $fieldId }}_name');
                                                
                                                if (fileInput && dropZone) {
                                                    // Click to select file
                                                    dropZone.addEventListener('click', function() {
                                                        fileInput.click();
                                                    });
                                                    
                                                    // Drag and drop events
                                                    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                                                        dropZone.addEventListener(eventName, preventDefaults, false);
                                                    });
                                                    
                                                    function preventDefaults(e) {
                                                        e.preventDefault();
                                                        e.stopPropagation();
                                                    }
                                                    
                                                    ['dragenter', 'dragover'].forEach(eventName => {
                                                        dropZone.addEventListener(eventName, highlight, false);
                                                    });
                                                    
                                                    ['dragleave', 'drop'].forEach(eventName => {
                                                        dropZone.addEventListener(eventName, unhighlight, false);
                                                    });
                                                    
                                                    function highlight() {
                                                        dropZone.classList.add('dragover');
                                                    }
                                                    
                                                    function unhighlight() {
                                                        dropZone.classList.remove('dragover');
                                                    }
                                                    
                                                    // Handle dropped files
                                                    dropZone.addEventListener('drop', handleDrop, false);
                                                    
                                                    function handleDrop(e) {
                                                        const dt = e.dataTransfer;
                                                        const files = dt.files;
                                                        if (files.length) {
                                                            fileInput.files = files;
                                                            updateFileInfo(files[0].name);
                                                        }
                                                    }
                                                    
                                                    // Handle file selection via dialog
                                                    fileInput.addEventListener('change', function(e) {
                                                        if (e.target.files.length) {
                                                            updateFileInfo(e.target.files[0].name);
                                                        } else {
                                                            hideFileInfo();
                                                        }
                                                    });
                                                    
                                                    function updateFileInfo(fileName) {
                                                        nameSpan.textContent = fileName;
                                                        infoDiv.style.display = 'block';
                                                    }
                                                    
                                                    function hideFileInfo() {
                                                        infoDiv.style.display = 'none';
                                                    }
                                                }
                                            });
                                        </script>
                                    </div>
                                @elseif($element['type'] === 'date')
                                    <div class="mb-4 @if($errors->has($element['fieldName'])) has-error @endif">
                                        <label for="{{ $element['fieldName'] }}" class="form-label">
                                            <i class='bx bx-calendar'></i>{{ $element['label'] }}
                                            @if($isRequired)
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>
                                        @php
                                            // Set date limits from 1978 to current year
                                            $maxDate = date('Y-m-d');
                                            $minDate = '1978-01-01';
                                            $fieldId = $element['fieldName'];
                                        @endphp
                                        <div class="row g-3">
                                            <div class="col-4">
                                                <input
                                                    type="number"
                                                    class="form-control date-part day-input @if($errors->has($element['fieldName'].'_day')) is-invalid @endif"
                                                    id="{{ $fieldId }}_day"
                                                    name="{{ $fieldId }}_day"
                                                    placeholder="দিন"
                                                    min="1"
                                                    max="31"
                                                    value="{{ old($fieldId.'_day') }}"
                                                >
                                            </div>
                                            <div class="col-4">
                                                <select class="form-select date-part month-input @if($errors->has($element['fieldName'].'_month')) is-invalid @endif" id="{{ $fieldId }}_month" name="{{ $fieldId }}_month">
                                                    <option value="">মাস</option>
                                                    <option value="01" @if(old($fieldId.'_month') == '01') selected @endif>জানুয়ারি</option>
                                                    <option value="02" @if(old($fieldId.'_month') == '02') selected @endif>ফেব্রুয়ারি</option>
                                                    <option value="03" @if(old($fieldId.'_month') == '03') selected @endif>মার্চ</option>
                                                    <option value="04" @if(old($fieldId.'_month') == '04') selected @endif>এপ্রিল</option>
                                                    <option value="05" @if(old($fieldId.'_month') == '05') selected @endif>মে</option>
                                                    <option value="06" @if(old($fieldId.'_month') == '06') selected @endif>জুন</option>
                                                    <option value="07" @if(old($fieldId.'_month') == '07') selected @endif>জুলাই</option>
                                                    <option value="08" @if(old($fieldId.'_month') == '08') selected @endif>আগস্ট</option>
                                                    <option value="09" @if(old($fieldId.'_month') == '09') selected @endif>সেপ্টেম্বর</option>
                                                    <option value="10" @if(old($fieldId.'_month') == '10') selected @endif>অক্টোবর</option>
                                                    <option value="11" @if(old($fieldId.'_month') == '11') selected @endif>নভেম্বর</option>
                                                    <option value="12" @if(old($fieldId.'_month') == '12') selected @endif>ডিসেম্বর</option>
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <input
                                                    type="number"
                                                    class="form-control date-part year-input @if($errors->has($element['fieldName'].'_year')) is-invalid @endif"
                                                    id="{{ $fieldId }}_year"
                                                    name="{{ $fieldId }}_year"
                                                    placeholder="বছর"
                                                    min="1978"
                                                    max="{{ date('Y') }}"
                                                    value="{{ old($fieldId.'_year') }}"
                                                >
                                            </div>
                                        </div>
                                        <input
                                            type="date"
                                            class="date-input-hidden"
                                            id="{{ $fieldId }}"
                                            name="{{ $fieldId }}"
                                            @if($isRequired) required @endif
                                            min="{{ $minDate }}"
                                            max="{{ $maxDate }}"
                                            style="display: none;"
                                        >
                                        @if($errors->has($element['fieldName']))
                                            <div class="invalid-feedback d-block" id="{{ $fieldId }}_error">
                                                {{ $errors->first($element['fieldName']) }}
                                            </div>
                                        @else
                                            <div class="invalid-feedback" id="{{ $fieldId }}_error"></div>
                                        @endif
                                    </div>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            const fieldId = '{{ $fieldId }}';
                                            const minDate = '{{ $minDate }}';
                                            const maxDate = '{{ $maxDate }}';
                                            initializeDateFields(fieldId, minDate, maxDate);
                                        });
                                    </script>
                                    
                                @endif
                            @endforeach
                        @endif

                        <div class="mb-5 form-check p-4 border rounded-3" style="background-color: rgba(74, 144, 226, 0.05);">
                            <input type="checkbox" class="form-check-input" id="terms" required>
                            <label class="form-check-label fw-medium" for="terms">
                                <i class='bx bx-check-circle me-2'></i>আমি সাইমুম শিল্পীগোষ্ঠীর নিয়ম-কানুন মেনে চলতে সম্মত হচ্ছি *
                            </label>
                        </div>

                        <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mt-5 pt-4 border-top">
                            <a href="{{ route('application') }}" class="btn btn-outline-primary">
                                <i class='bx bx-arrow-back me-2'></i>ফিরে যান
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class='bx bx-send me-2'></i>আবেদন করুন
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Store divisions data in a JavaScript variable using PHP echo
    var divisionsData = <?php echo json_encode($divisions); ?>;
    var advancedAddress = <?php echo $advancedAddress ? 'true' : 'false'; ?>;
    
    // Initialize all date fields
    function initializeDateFields(fieldId, minDate, maxDate) {
        const dayInput = document.getElementById(fieldId + '_day');
        const monthInput = document.getElementById(fieldId + '_month');
        const yearInput = document.getElementById(fieldId + '_year');
        const hiddenInput = document.getElementById(fieldId);
        const errorDiv = document.getElementById(fieldId + '_error');
        
        // Add input validation and formatting
        [dayInput, yearInput].forEach(input => {
            input.addEventListener('input', function() {
                // Remove any non-numeric characters
                this.value = this.value.replace(/[^0-9]/g, '');
                
                // Limit length
                if (input === dayInput && this.value.length > 2) {
                    this.value = this.value.slice(0, 2);
                } else if (input === yearInput && this.value.length > 4) {
                    this.value = this.value.slice(0, 4);
                }
                
                // Validate ranges only when field is complete
                if (input === dayInput && this.value.length === 2) {
                    const day = parseInt(this.value);
                    if (day > 31) this.value = '31';
                    if (day < 1) this.value = '01';
                } else if (input === yearInput && this.value.length === 4) {
                    const year = parseInt(this.value);
                    const currentYear = new Date().getFullYear();
                    if (year > currentYear) this.value = currentYear.toString();
                    if (year < 1978) this.value = '1978';
                }
                
                updateHiddenDate();
            });
            
            // Prevent more than allowed digits
            input.addEventListener('keydown', function(e) {
                // Allow: backspace, delete, tab, escape, enter
                if ([46, 8, 9, 27, 13].indexOf(e.keyCode) !== -1 ||
                    // Allow: Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
                    (e.keyCode === 65 && e.ctrlKey === true) ||
                    (e.keyCode === 67 && e.ctrlKey === true) ||
                    (e.keyCode === 86 && e.ctrlKey === true) ||
                    (e.keyCode === 88 && e.ctrlKey === true) ||
                    // Allow: home, end, left, right
                    (e.keyCode >= 35 && e.keyCode <= 39)) {
                    return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
                // Prevent more than allowed digits
                let maxLength = 2;
                if (input === yearInput) maxLength = 4;
                if (this.value.length >= maxLength && ![46, 8, 9, 27, 13].includes(e.keyCode)) {
                    e.preventDefault();
                }
            });
        });
        
        monthInput.addEventListener('change', function() {
            updateHiddenDate();
        });
        
        // Function to update the hidden date input
        function updateHiddenDate() {
            const day = dayInput.value.padStart(2, '0');
            const month = monthInput.value;
            const year = yearInput.value;
            
            // Only update if we have all parts
            if (day && month && year && day.length === 2 && month.length === 2 && year.length === 4) {
                const isoDate = year + '-' + month + '-' + day;
                hiddenInput.value = isoDate;
                validateDate(hiddenInput, minDate, maxDate);
            } else {
                hiddenInput.value = '';
                if (errorDiv) {
                    errorDiv.style.display = 'none';
                }
            }
        }
        
        // Validate date
        function validateDate(input, minDate, maxDate) {
            const value = input.value;
            if (!value) return;
            
            const selectedDate = new Date(value);
            const maxDateObj = new Date(maxDate);
            const minDateObj = new Date(minDate);
            
            // Reset custom validity first
            input.setCustomValidity('');
            
            if (selectedDate > maxDateObj) {
                const errorMessage = 'জন্ম তারিখ আজকের তারিখের পরে হতে পারবে না';
                input.setCustomValidity(errorMessage);
                if (errorDiv) {
                    errorDiv.textContent = errorMessage;
                    errorDiv.style.display = 'block';
                }
            } else if (selectedDate < minDateObj) {
                const errorMessage = 'জন্ম তারিখ ১ জানুয়ারি, ১৯৭৮ এর আগে হতে পারবে না';
                input.setCustomValidity(errorMessage);
                if (errorDiv) {
                    errorDiv.textContent = errorMessage;
                    errorDiv.style.display = 'block';
                }
            } else {
                // Valid date - clear error messages
                input.setCustomValidity('');
                if (errorDiv) {
                    errorDiv.style.display = 'none';
                }
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Get DOM elements
    const divisionSelect = document.getElementById('division');
    const districtSelect = document.getElementById('district');
    const upazilaSelect = document.getElementById('upazila');
    const detailedAddress = document.getElementById('detailed_address');
    const addressInput = document.getElementById('address');

    // Permanent selectors (may be null in legacy mode)
    const sameAsPresent = document.getElementById('same_as_present');
    const permDivision = document.getElementById('permanent_division');
    const permDistrict = document.getElementById('permanent_district');
    const permUpazila = document.getElementById('permanent_upazila');
    const permDetails = document.getElementById('permanent_address_details');
    const permCombined = document.getElementById('permanent_address_combined');

        // Helper to populate district options given a division select & target district select
        function populateDistricts(srcDivisionSelect, targetDistrictSelect) {
            const selectedDivision = srcDivisionSelect.value;
            targetDistrictSelect.innerHTML = '<option value="">জেলা নির্বাচন করুন</option>';
            targetDistrictSelect.disabled = true;
            if (!selectedDivision) return;
            const divisionData = divisionsData.find(div => div.name === selectedDivision);
            if (divisionData && divisionData.districts) {
                divisionData.districts.forEach(district => {
                    const opt = document.createElement('option');
                    opt.value = district.name;
                    opt.textContent = district.name;
                    targetDistrictSelect.appendChild(opt);
                });
                targetDistrictSelect.disabled = false;
            }
        }

        function populateUpazilas(srcDivisionSelect, srcDistrictSelect, targetUpazilaSelect) {
            const divisionName = srcDivisionSelect.value;
            const districtName = srcDistrictSelect.value;
            targetUpazilaSelect.innerHTML = '<option value="">উপজেলা নির্বাচন করুন</option>';
            targetUpazilaSelect.disabled = true;
            if (!divisionName || !districtName) return;
            const divisionData = divisionsData.find(div => div.name === divisionName);
            if (!divisionData) return;
            const districtData = divisionData.districts.find(dist => dist.name === districtName);
            if (districtData && districtData.upazilas) {
                districtData.upazilas.forEach(up => {
                    const opt = document.createElement('option');
                    opt.value = up;
                    opt.textContent = up;
                    targetUpazilaSelect.appendChild(opt);
                });
                targetUpazilaSelect.disabled = false;
            }
        }

        // Present division change
        divisionSelect.addEventListener('change', function() {
            populateDistricts(divisionSelect, districtSelect);
            upazilaSelect.innerHTML = '<option value="">উপজেলা নির্বাচন করুন</option>';
            upazilaSelect.disabled = true;
            updateCombinedAddress();
        });

        // Present district change
        districtSelect.addEventListener('change', function() {
            populateUpazilas(divisionSelect, districtSelect, upazilaSelect);
            updateCombinedAddress();
        });

        upazilaSelect.addEventListener('change', updateCombinedAddress);
        detailedAddress.addEventListener('input', updateCombinedAddress);

        // Permanent address events (only if advanced)
        if (advancedAddress && permDivision) {
            permDivision.addEventListener('change', function() {
                populateDistricts(permDivision, permDistrict);
                permUpazila.innerHTML = '<option value="">উপজেলা নির্বাচন করুন</option>';
                permUpazila.disabled = true;
                updateCombinedAddress();
            });
            permDistrict.addEventListener('change', function() {
                populateUpazilas(permDivision, permDistrict, permUpazila);
                updateCombinedAddress();
            });
            permUpazila.addEventListener('change', updateCombinedAddress);
            if (permDetails) permDetails.addEventListener('input', updateCombinedAddress);
            if (sameAsPresent) {
                sameAsPresent.addEventListener('change', function() {
                    const block = document.getElementById('permanent_address_block');
                    if (this.checked) {
                        block.style.display = 'none';
                        // copy values
                        if (permDivision) permDivision.value = divisionSelect.value;
                        populateDistricts(permDivision, permDistrict);
                        permDistrict.value = districtSelect.value;
                        populateUpazilas(permDivision, permDistrict, permUpazila);
                        permUpazila.value = upazilaSelect.value;
                        if (permDetails) permDetails.value = detailedAddress.value;
                    } else {
                        block.style.display = '';
                    }
                    updateCombinedAddress();
                });
            }
        }

        // Function to update combined address
        function updateCombinedAddress() {
            // Present combined
            const parts = [divisionSelect.value, districtSelect.value, upazilaSelect.value, detailedAddress.value].filter(Boolean);
            addressInput.value = parts.join(', ');
            // Permanent combined if advanced
            if (advancedAddress && permCombined) {
                if (sameAsPresent && sameAsPresent.checked) {
                    permCombined.value = addressInput.value;
                } else {
                    const permParts = [permDivision?.value, permDistrict?.value, permUpazila?.value, permDetails?.value].filter(Boolean);
                    permCombined.value = permParts.join(', ');
                }
            }
        }

        // Initialize the form
        updateCombinedAddress();
        
        // Add date validation for all date inputs
        const dateInputs = document.querySelectorAll('.date-input');
        dateInputs.forEach(function(input) {
            input.addEventListener('change', function() {
                validateDateInput(this);
            });
        });
        
        function validateDateInput(input) {
            const value = input.value;
            if (!value) return;
            
            const selectedDate = new Date(value);
            const today = new Date();
            const maxDate = new Date(today.getFullYear(), today.getMonth(), today.getDate());
            const minDate = new Date(1978, 0, 1); // January 1, 1978
            
            const errorDiv = document.getElementById(input.id + '_error');
            
            // Reset custom validity first
            input.setCustomValidity('');
            
            if (selectedDate > maxDate) {
                const errorMessage = 'জন্ম তারিখ আজকের তারিখের পরে হতে পারবে না';
                input.setCustomValidity(errorMessage);
                if (errorDiv) {
                    errorDiv.textContent = errorMessage;
                    errorDiv.style.display = 'block';
                }
            } else if (selectedDate < minDate) {
                const errorMessage = 'জন্ম তারিখ ১ জানুয়ারি, ১৯৭৮ এর আগে হতে পারবে না';
                input.setCustomValidity(errorMessage);
                if (errorDiv) {
                    errorDiv.textContent = errorMessage;
                    errorDiv.style.display = 'block';
                }
            } else {
                // Valid date - clear error messages
                input.setCustomValidity('');
                if (errorDiv) {
                    errorDiv.style.display = 'none';
                }
            }
        }
        
        // Add real-time feedback without being intrusive
        dateInputs.forEach(function(input) {
            // Validate on change
            input.addEventListener('change', function() {
                validateDateInput(this);
            });
            
            // Also validate on input for real-time feedback
            input.addEventListener('input', function() {
                // Small delay to allow user to finish typing
                setTimeout(() => {
                    validateDateInput(this);
                }, 500);
            });
        });
        
    });
</script>
@endsection