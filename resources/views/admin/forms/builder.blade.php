@extends('admin.layouts.app')

@section('title', 'ফর্ম বিল্ডার - ' . $form->name)

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex align-items-center mb-4 fade-in">
        <h4 class="mb-0">ফর্ম বিল্ডার: {{ $form->name }}</h4>
        <div class="ms-auto">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">হোম</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.forms.index') }}">ফর্মসমূহ</a></li>
</original_code>```

```

                <li class="breadcrumb-item active" aria-current="page">ফর্ম বিল্ডার</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <!-- Form Builder Area - Google Forms Style -->
        <div class="col-lg-8 fade-in">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center bg-white">
                    <h5 class="mb-0 d-flex align-items-center gap-2">ফর্ম ডিজাইন <button type="button" id="showKbHelpBtn" class="btn btn-sm btn-outline-secondary" title="কিবোর্ড শর্টকাট (? বা Shift+/)"><i class='bx bx-keyboard'></i></button></h5>
                    <div>
                        <button id="saveFormBtn" class="btn btn-success me-2">
                            <i class='bx bx-save me-1'></i>ফর্ম সংরক্ষণ করুন
                        </button>
                        <button id="previewFormBtn" class="btn btn-outline-primary me-2">
                            <i class='bx bx-show me-1'></i>প্রিভিউ
                        </button>
                        <button id="applyAdmissionTemplateBtn" class="btn btn-info me-2" title="সম্পূর্ণ ভর্তি ফর্মের পূর্বনির্ধারিত কাঠামো লোড করুন">
                            <i class='bx bx-copy me-1'></i>ভর্তি টেমপ্লেট
                        </button>
                        <button id="clearFieldsBtn" class="btn btn-outline-danger">
                            <i class='bx bx-trash me-1'></i>Clear Fields
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div id="formBuilderArea" class="form-builder-area">
                        <!-- Form fields will be added here dynamically -->
                        <div class="text-center py-5" id="emptyFormMessage">
                            <i class='bx bx-plus-circle bx-lg text-muted mb-3'></i>
                            <h5 class="text-muted">প্রশ্ন যুক্ত করতে ডান পাশের অপশনগুলো ব্যবহার করুন</h5>
                            <p class="text-muted">অথবা "ভর্তি টেমপ্লেট" বাটনে ক্লিক করে সম্পূর্ণ প্রস্তাবিত কাঠামো যোগ করুন</p>
                        </div>

                        <!-- This is where form elements will be rendered -->
                        <div id="formElementsContainer"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Elements Panel - Google Forms Style -->
        <div class="col-lg-4 fade-in">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">প্রশ্নের ধরন</h5>
                </div>
                <div class="card-body scrollable-panel">
                    <!-- Quick Add Section -->
                    <div class="mb-4">
                        <h6 class="mb-3">দ্রুত যুক্ত করুন</h6>
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-primary btn-sm draggable-element" data-type="text">
                                <i class='bx bx-text me-2'></i>Short Answer
                            </button>
                            <button class="btn btn-outline-primary btn-sm draggable-element" data-type="textarea">
                                <i class='bx bx-text me-2'></i>Paragraph
                            </button>
                            <button class="btn btn-outline-primary btn-sm draggable-element" data-type="radio">
                                <i class='bx bx-radio-circle-marked me-2'></i>Multiple Choice
                            </button>
                            <button class="btn btn-outline-primary btn-sm draggable-element" data-type="checkbox">
                                <i class='bx bx-checkbox-checked me-2'></i>Checkboxes
                            </button>
                            <button class="btn btn-outline-primary btn-sm draggable-element" data-type="select">
                                <i class='bx bx-collapse-alt me-2'></i>Dropdown
                            </button>
                            <button class="btn btn-outline-primary btn-sm draggable-element" data-type="file">
                                <i class='bx bx-file me-2'></i>File Upload
                            </button>
                            <button class="btn btn-outline-primary btn-sm draggable-element" data-type="date">
                                <i class='bx bx-calendar me-2'></i>Date
                            </button>
                            <button class="btn btn-outline-primary btn-sm draggable-element" data-type="section">
                                <i class='bx bx-heading me-2'></i>Section
                            </button>
                        </div>
                    </div>

                    <!-- Admission Form Template Elements (Refactored Grouped Layout) -->
                    <div class="mb-4">
                        <h6 class="mb-2">ভর্তি ফর্মের দ্রুত ফিল্ডসমূহ</h6>
                        <p class="text-muted small mb-3">
                            নিচের গ্রুপগুলো থেকে প্রয়োজনীয় ফিল্ড ড্র্যাগ/ক্লিক করে যুক্ত করুন। পাবলিক আবেদন ফর্ম সর্বনিম্ন <strong>নাম</strong>, <strong>ই-মেইল</strong>, <strong>মোবাইল</strong>, <strong>ঠিকানা</strong> (সেকশন + উপাদান) এবং <strong>ভর্তিচ্ছু বিষয় (মাল্টি)</strong> থাকলে পূর্ণাঙ্গভাবে কাজ করবে।
                        </p>

                        <div class="accordion" id="quickAdmissionFieldsAccordion">
                            <!-- Core Required (System) -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="qafHeadingCore">
                                    <button class="accordion-button py-2 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#qafCollapseCore" aria-expanded="false" aria-controls="qafCollapseCore">
                                        প্রাথমিক ও শিক্ষার্থীর তথ্য
                                    </button>
                                </h2>
                                <div id="qafCollapseCore" class="accordion-collapse collapse" aria-labelledby="qafHeadingCore" data-bs-parent="#quickAdmissionFieldsAccordion">
                                    <div class="accordion-body p-2">
                                        <div class="d-grid gap-2">
                                            <button class="btn btn-outline-secondary btn-sm draggable-template" data-field-name="section_title" data-label="সেকশন শিরোনাম" data-type="section"><i class='bx bx-heading me-2'></i>সেকশন</button>
                                            <button class="btn btn-outline-secondary btn-sm draggable-template" data-field-name="name" data-label="পূর্ণ নাম" data-type="text" data-required="1"><i class='bx bx-user me-2'></i>পূর্ণ নাম</button>
                                            <button class="btn btn-outline-secondary btn-sm draggable-template" data-field-name="student_name_bengali" data-label="শিক্ষার্থীর নাম (বাংলায়)" data-type="text" data-required="1"><i class='bx bx-user me-2'></i>নাম (বাংলা)</button>
                                            <button class="btn btn-outline-secondary btn-sm draggable-template" data-field-name="student_name_english" data-label="শিক্ষার্থীর নাম (ইংরেজিতে, বড় হাতের অক্ষরে)" data-type="text" data-required="1"><i class='bx bx-user me-2'></i>নাম (English)</button>
                                            <button class="btn btn-outline-secondary btn-sm draggable-template" data-field-name="student_photo" data-label="ছবি সংযুক্ত করার বক্স" data-type="file"><i class='bx bx-image-alt me-2'></i>ছবি</button>
                                            <button class="btn btn-outline-secondary btn-sm draggable-template" data-field-name="date_of_birth" data-label="জন্ম তারিখ (দিন/মাস/বছর)" data-type="date"><i class='bx bx-calendar me-2'></i>জন্ম তারিখ</button>
                                            <button class="btn btn-outline-secondary btn-sm draggable-template" data-field-name="religion" data-label="ধর্ম" data-type="select" data-options='["ইসলাম","হিন্দু","খ্রিস্টান","বৌদ্ধ","অন্যান্য"]'><i class='bx bx-book me-2'></i>ধর্ম</button>
                                            <button class="btn btn-outline-secondary btn-sm draggable-template" data-field-name="gender" data-label="লিঙ্গ" data-type="select" data-options='["পুরুষ","মহিলা","অন্যান্য"]'><i class='bx bx-male-female me-2'></i>লিঙ্গ</button>
                                            <button class="btn btn-outline-secondary btn-sm draggable-template" data-field-name="blood_group" data-label="রক্তের গ্রুপ" data-type="select" data-options='["A+","A-","B+","B-","AB+","AB-","O+","O-"]'><i class='bx bx-droplet me-2'></i>রক্তের গ্রুপ</button>
                                            <button class="btn btn-outline-secondary btn-sm draggable-template" data-field-name="email" data-label="ই-মেইল" data-type="text" data-required="1"><i class='bx bx-envelope me-2'></i>ই-মেইল</button>
                                            <button class="btn btn-outline-secondary btn-sm draggable-template" data-field-name="phone" data-label="মোবাইল নম্বর" data-type="text" data-required="1"><i class='bx bx-phone me-2'></i>মোবাইল</button>
                                        </div>
                                        <div class="small text-muted mt-2">এই ফিল্ডগুলো ছাড়া সাবমিশন ভ্যালিডেশন ফেল করবে।</div>
                                    </div>
                                </div>
                            </div>
                            <!-- Address -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="qafHeadingAddress">
                                    <button class="accordion-button py-2 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#qafCollapseAddress" aria-expanded="false" aria-controls="qafCollapseAddress">
                                        ঠিকানা
                                    </button>
                                </h2>
                                <div id="qafCollapseAddress" class="accordion-collapse collapse" aria-labelledby="qafHeadingAddress" data-bs-parent="#quickAdmissionFieldsAccordion">
                                    <div class="accordion-body p-2">
                                        <div class="d-grid gap-2">
                                            <button class="btn btn-outline-info btn-sm draggable-template" data-field-name="address" data-label="ঠিকানা" data-type="section"><i class='bx bx-heading me-2'></i>ঠিকানা সেকশন</button>
                                            <button class="btn btn-outline-info btn-sm draggable-template" data-field-name="division" data-label="বর্তমান ঠিকানা - বিভাগ" data-type="select"><i class='bx bx-map me-2'></i>বিভাগ</button>
                                            <button class="btn btn-outline-info btn-sm draggable-template" data-field-name="district" data-label="বর্তমান ঠিকানা - জেলা" data-type="select"><i class='bx bx-map-pin me-2'></i>জেলা</button>
                                            <button class="btn btn-outline-info btn-sm draggable-template" data-field-name="upazila" data-label="বর্তমান ঠিকানা - উপজেলা" data-type="select"><i class='bx bx-map-alt me-2'></i>উপজেলা</button>
                                            <button class="btn btn-outline-info btn-sm draggable-template" data-field-name="address_details" data-label="বর্তমান ঠিকানা - গ্রাম/মহল্লা, বাসা/হোল্ডিং নং, ডাকঘর" data-type="text"><i class='bx bx-home me-2'></i>ঠিকানার বিস্তারিত</button>
                                            <button class="btn btn-outline-info btn-sm draggable-template" data-field-name="is_permanent_address_same_as_present" data-label="বর্তমান ও স্থায়ী ঠিকানা একই হলে টিক দিন" data-type="checkbox"><i class='bx bx-check-square me-2'></i>একই (স্থায়ী)</button>
                                            <button class="btn btn-outline-info btn-sm draggable-template" data-field-name="permanent_division" data-label="স্থায়ী ঠিকানা - বিভাগ" data-type="select"><i class='bx bx-map me-2'></i>স্থায়ী বিভাগ</button>
                                            <button class="btn btn-outline-info btn-sm draggable-template" data-field-name="permanent_district" data-label="স্থায়ী ঠিকানা - জেলা" data-type="select"><i class='bx bx-map-pin me-2'></i>স্থায়ী জেলা</button>
                                            <button class="btn btn-outline-info btn-sm draggable-template" data-field-name="permanent_upazila" data-label="স্থায়ী ঠিকানা - উপজেলা" data-type="select"><i class='bx bx-map-alt me-2'></i>স্থায়ী উপজেলা</button>
                                            <button class="btn btn-outline-info btn-sm draggable-template" data-field-name="permanent_address_details" data-label="স্থায়ী ঠিকানা - গ্রাম/মহল্লা, বাসা/হোল্ডিং নং, ডাকঘর" data-type="text"><i class='bx bx-home me-2'></i>স্থায়ী বিস্তারিত</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Guardian / Parents -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="qafHeadingGuardian">
                                    <button class="accordion-button py-2 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#qafCollapseGuardian" aria-expanded="false" aria-controls="qafCollapseGuardian">
                                        অভিভাবকের তথ্য
                                    </button>
                                </h2>
                                <div id="qafCollapseGuardian" class="accordion-collapse collapse" aria-labelledby="qafHeadingGuardian" data-bs-parent="#quickAdmissionFieldsAccordion">
                                    <div class="accordion-body p-2">
                                        <div class="d-grid gap-2">
                                            <button class="btn btn-outline-info btn-sm draggable-template" data-field-name="guardian_info" data-label="অভিভাবকের তথ্য" data-type="section"><i class='bx bx-heading me-2'></i>অভিভাবক সেকশন</button>
                                            <button class="btn btn-outline-info btn-sm draggable-template" data-field-name="father_name_bengali" data-label="পিতার নাম (বাংলায়)" data-type="text"><i class='bx bx-user me-2'></i>পিতা (বাংলা)</button>
                                            <button class="btn btn-outline-info btn-sm draggable-template" data-field-name="father_occupation" data-label="পিতার পেশা" data-type="text"><i class='bx bx-briefcase me-2'></i>পিতার পেশা</button>
                                            <button class="btn btn-outline-info btn-sm draggable-template" data-field-name="father_mobile_number" data-label="পিতার মোবাইল নম্বর" data-type="text"><i class='bx bx-phone me-2'></i>পিতার মোবাইল</button>
                                            <button class="btn btn-outline-info btn-sm draggable-template" data-field-name="mother_name_bengali" data-label="মাতার নাম (বাংলায়)" data-type="text"><i class='bx bx-user me-2'></i>মাতা (বাংলা)</button>
                                            <button class="btn btn-outline-info btn-sm draggable-template" data-field-name="mother_occupation" data-label="মাতার পেশা" data-type="text"><i class='bx bx-briefcase me-2'></i>মাতার পেশা</button>
                                            <button class="btn btn-outline-info btn-sm draggable-template" data-field-name="mother_mobile_number" data-label="মাতার মোবাইল নম্বর" data-type="text"><i class='bx bx-phone me-2'></i>মাতার মোবাইল</button>
                                            <button class="btn btn-outline-info btn-sm draggable-template" data-field-name="guardian_mobile_number" data-label="মোবাইল নম্বর (অভিভাবকের)" data-type="text"><i class='bx bx-phone-call me-2'></i>অভিভাবক মোবাইল</button>
                                        </div>
                                        <div class="small text-muted mt-2">পিতা/মাতা ছাড়া অন্য কোনো অভিভাবকের যোগাযোগের জন্য</div>
                                    </div>
                                </div>
                            </div>
                            <!-- Academic / Workshop -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="qafHeadingAcademic">
                                    <button class="accordion-button py-2 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#qafCollapseAcademic" aria-expanded="false" aria-controls="qafCollapseAcademic">
                                        একাডেমিক ও কর্মশালা
                                    </button>
                                </h2>
                                <div id="qafCollapseAcademic" class="accordion-collapse collapse" aria-labelledby="qafHeadingAcademic" data-bs-parent="#quickAdmissionFieldsAccordion">
                                    <div class="accordion-body p-2">
                                        <div class="d-grid gap-2">
                                            <button class="btn btn-outline-info btn-sm draggable-template" data-field-name="academic_workshop" data-label="একাডেমিক ও কর্মশালা" data-type="section"><i class='bx bx-heading me-2'></i>একাডেমিক সেকশন</button>
                                            <button class="btn btn-outline-info btn-sm draggable-template" data-field-name="workshop_passing_date" data-label="কর্মশালায় উত্তীর্ণের তারিখ" data-type="date"><i class='bx bx-calendar-check me-2'></i>উত্তীর্ণের তারিখ</button>
                                            <button class="btn btn-outline-info btn-sm draggable-template" data-field-name="workshop_passing_subject" data-label="কর্মশালায় উত্তীর্ণের বিষয়" data-type="text"><i class='bx bx-certification me-2'></i>উত্তীর্ণের বিষয়</button>
                                            <button class="btn btn-outline-info btn-sm draggable-template" data-field-name="workshop_registration_no" data-label="কর্মশালার রেজিস্ট্রেশন নম্বর" data-type="text"><i class='bx bx-id-card me-2'></i>রেজি. নম্বর</button>
                                            <button class="btn btn-outline-info btn-sm draggable-template" data-field-name="desired_subject" data-label="ভর্তিচ্ছু বিষয়" data-type="text" data-multisubject="1" title="পাবলিক ফর্মে এটি মাল্টি-সিলেক্ট বিষয় তালিকা হিসেবে দেখাবে"><i class='bx bx-target-lock me-2'></i>ভর্তিচ্ছু বিষয় (মাল্টি)</button>
                                            @if(isset($subjects) && $subjects->count())
                                                <div class="small text-muted ms-1">বর্তমান বিষয়সমূহ: {{ $subjects->pluck('name')->join(', ') }} <span class="d-block">(কোডগুলো CSV আকারে সংরক্ষিত হয়)</span></div>
                                            @else
                                                <div class="small text-warning ms-1">কোনো সক্রিয় বিষয় পাওয়া যায়নি – SubjectSeeder চালান।</div>
                                            @endif
                                            <button class="btn btn-outline-info btn-sm draggable-template" data-field-name="last_educational_institute" data-label="শিক্ষা প্রতিষ্ঠানের নাম" data-type="text"><i class='bx bx-building-house me-2'></i>প্রতিষ্ঠানের নাম</button>
                                            <button class="btn btn-outline-info btn-sm draggable-template" data-field-name="last_class_or_year" data-label="শ্রেণি/বর্ষ" data-type="text"><i class='bx bx-book-open me-2'></i>শ্রেণি/বর্ষ</button>
                                            <button class="btn btn-outline-info btn-sm draggable-template" data-field-name="last_department_or_subject" data-label="বিভাগ/বিষয়" data-type="text"><i class='bx bx-category-alt me-2'></i>বিভাগ/বিষয়</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Other / Identification -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="qafHeadingOther">
                                    <button class="accordion-button py-2 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#qafCollapseOther" aria-expanded="false" aria-controls="qafCollapseOther">
                                        অন্যান্য / পরিচয়
                                    </button>
                                </h2>
                                <div id="qafCollapseOther" class="accordion-collapse collapse" aria-labelledby="qafHeadingOther" data-bs-parent="#quickAdmissionFieldsAccordion">
                                    <div class="accordion-body p-2">
                                        <div class="d-grid gap-2">
                                            <button class="btn btn-outline-info btn-sm draggable-template" data-field-name="other_identification" data-label="অন্যান্য / পরিচয়" data-type="section"><i class='bx bx-heading me-2'></i>অন্যান্য সেকশন</button>
                                            <button class="btn btn-outline-info btn-sm draggable-template" data-field-name="nid_or_birth_certificate_no" data-label="জাতীয় পরিচয়পত্র / জন্ম নিবন্ধন নম্বর" data-type="text"><i class='bx bx-id-card me-2'></i>NID / জন্ম নিবন্ধন</button>
                                            <button class="btn btn-outline-info btn-sm draggable-template" data-field-name="facebook_id" data-label="ফেসবুক আইডি (যদি থাকে)" data-type="text"><i class='bx bxl-facebook me-2'></i>ফেসবুক আইডি</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button id="addAllAdmissionFieldsBtn" class="btn btn-info btn-sm w-100">
                                <i class='bx bx-plus me-1'></i>সম্পূর্ণ ভর্তি ফর্মের সব ফিল্ড যোগ করুন
                            </button>
                        </div>
                    </div>

                    <!-- Settings Panel -->
                    <div>
                        <h6 class="mb-3">ফর্ম সেটিংস</h6>
                        <div class="mb-3">
                            <label class="form-label">ফর্মের শিরোনাম</label>
                            <input type="text" class="form-control" id="formName" value="{{ $form->name }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ফর্মের বর্ণনা</label>
                            <textarea class="form-control" id="formDescription" rows="2">{{ $form->description }}</textarea>
                        </div>

                        <div class="accordion" id="advancedSettingsAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                        অ্যাডভান্স সেটিংস
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#advancedSettingsAccordion">
                                    <div class="accordion-body">
                                        <div class="mb-3">
                                            <label class="form-label">Application ID Prefix</label>
                                            <input type="text" class="form-control" id="appIdPrefix" placeholder="যেমন: SRI-" value="{{ $form->fields['settings']['appIdPrefix'] ?? '' }}">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label">ID Number Start</label>
                                                <input type="number" class="form-control" id="idStart" placeholder="1001" value="{{ $form->fields['settings']['idRange']['start'] ?? '' }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">ID Number End</label>
                                                <input type="number" class="form-control" id="idEnd" placeholder="2000" value="{{ $form->fields['settings']['idRange']['end'] ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="form-check mt-3">
                                            <input class="form-check-input" type="checkbox" id="paymentOption" @if(($form->fields['settings']['paymentRequired'] ?? false)) checked @endif>
                                            <label class="form-check-label" for="paymentOption">Payment Required</label>
                                        </div>
                                        <div class="mb-3" id="paymentAmountSection" style="display: <?php echo ($form->fields['settings']['paymentRequired'] ?? false) ? 'block' : 'none'; ?>;">
                                            <label class="form-label" for="paymentTypeLabel">Fee Name (Label)</label>
                                            <input type="text" class="form-control" id="paymentTypeLabel" placeholder="যেমন: আবেদন ফি, রেজিস্ট্রেশন ফি" value="{{ $form->fields['settings']['paymentTypeLabel'] ?? '' }}">
                                            <div class="form-text">এখানে আপনি ফি-এর নাম লিখবেন</div>
                                        </div>
                                        <div class="mb-3" id="paymentAmountSection" style="display: <?php echo ($form->fields['settings']['paymentRequired'] ?? false) ? 'block' : 'none'; ?>;">
                                            <label class="form-label" for="paymentAmount">Fee Amount (BDT)</label>
                                            <input type="number" class="form-control" id="paymentAmount" placeholder="ফি-এর পরিমাণ" value="{{ $form->fields['settings']['paymentAmount'] ?? '' }}" step="0.01" min="0">
                                            <div class="form-text">এখানে আপনি টাকার পরিমাণ লিখবেন</div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Form Active Date</label>
                                            <input type="date" class="form-control" id="formActiveDate" value="{{ $form->fields['settings']['activeDate'] ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Google Forms Style */
    .form-builder-area {
        min-height: 500px;
        background-color: #f8f9fa;
        border-radius: 0 0 8px 8px;
        border: 1px solid #e0e0e0;
        max-height: 70vh;
        overflow-y: auto;
    }

    /* Scrollable panels */
    .scrollable-panel {
        max-height: 70vh;
        overflow-y: auto;
    }

    /* Custom scrollbar for panels */
    .scrollable-panel::-webkit-scrollbar, .form-builder-area::-webkit-scrollbar {
        width: 8px;
    }

    .scrollable-panel::-webkit-scrollbar-track, .form-builder-area::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.05);
    }

    .scrollable-panel::-webkit-scrollbar-thumb, .form-builder-area::-webkit-scrollbar-thumb {
        background: #4a90e2;
        border-radius: 4px;
    }

    .scrollable-panel::-webkit-scrollbar-thumb:hover, .form-builder-area::-webkit-scrollbar-thumb:hover {
        background: #3a7bc8;
    }

    .form-element {
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 20px;
        margin: 15px;
        position: relative;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

    :root.dark-mode .form-element {
        background: #334155 !important;
        border-color: #475569 !important;
        color: #e2e8f0 !important;
    }

    .form-element:hover {
        box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        border-color: #4a90e2;
    }

    .form-element.selected {
        border-color: #4a90e2;
        box-shadow: 0 0 0 2px rgba(74, 144, 226, 0.2);
    }

    /* Keyboard shortcuts overlay */
    #kbShortcutsOverlay code {
        background: rgba(0,0,0,0.08);
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 11px;
        display: inline-block;
        margin: 2px 0;
    }
    :root.dark-mode #kbShortcutsOverlay code { background: rgba(255,255,255,0.12); }
    :root.dark-mode #kbShortcutsOverlay { background: #1e293b !important; }
    @media (max-width: 600px){
        #kbShortcutsOverlay { left:10px !important; right:10px !important; max-width:none !important; }
    }

    .form-element-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
    }

    .element-actions {
        display: flex;
        gap: 5px;
    }

    .element-actions button {
        padding: 4px 8px;
        font-size: 0.85rem;
    }

    .form-element-content {
        margin-bottom: 15px;
    }

    .form-element-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 10px;
        border-top: 1px solid #eee;
    }

    .draggable-element, .draggable-template {
        cursor: grab;
        transition: all 0.2s ease;
        text-align: left;
    }

    .draggable-element:active, .draggable-template:active {
        cursor: grabbing;
    }

    .draggable-element:hover, .draggable-template:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    :root.dark-mode .draggable-element, :root.dark-mode .draggable-template {
        color: #e2e8f0 !important;
    }

    :root.dark-mode .draggable-element:hover, :root.dark-mode .draggable-template:hover {
        box-shadow: 0 4px 8px rgba(0,0,0,0.3) !important;
    }

    .fade-in {
        animation: fadeInUp 0.6s ease forwards;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in:nth-child(1) { animation-delay: 0.1s; }
    .fade-in:nth-child(2) { animation-delay: 0.2s; }
    .fade-in:nth-child(3) { animation-delay: 0.3s; }

    /* Dark mode fixes */
    :root.dark-mode .form-builder-area {
        background-color: #1e293b !important;
        color: #e2e8f0 !important;
        border-color: #475569 !important;
    }

    #formElementsContainer {
        padding: 10px;
    }

    :root.dark-mode .card {
        background-color: #1e293b !important;
        color: #e2e8f0 !important;
    }

    :root.dark-mode .card-header {
        background-color: #334155 !important;
        color: #e2e8f0 !important;
        border-color: #475569 !important;
    }

    :root.dark-mode .card-body {
        background-color: #1e293b !important;
        color: #e2e8f0 !important;
    }

    :root.dark-mode .form-element {
        background: #334155 !important;
        border-color: #475569 !important;
        color: #e2e8f0 !important;
    }

    :root.dark-mode .form-element-header {
        border-color: #475569 !important;
    }

    :root.dark-mode .form-element-footer {
        border-color: #475569 !important;
    }

    :root.dark-mode .btn-outline-primary {
        color: #60a5fa !important;
        border-color: #60a5fa !important;
    }

    :root.dark-mode .btn-outline-primary:hover {
        background-color: #60a5fa !important;
        color: #1e293b !important;
    }

    :root.dark-mode .btn-outline-info {
        color: #67e8f9 !important;
        border-color: #67e8f9 !important;
    }

    :root.dark-mode .btn-outline-info:hover {
        background-color: #67e8f9 !important;
        color: #1e293b !important;
    }

    :root.dark-mode .btn-outline-secondary {
        color: #94a3b8 !important;
        border-color: #94a3b8 !important;
    }

    :root.dark-mode .btn-outline-secondary:hover {
        background-color: #94a3b8 !important;
        color: #1e293b !important;
    }

    :root.dark-mode .btn-outline-danger {
        color: #f87171 !important;
        border-color: #f87171 !important;
    }

    :root.dark-mode .btn-outline-danger:hover {
        background-color: #f87171 !important;
        color: #1e293b !important;
    }

    :root.dark-mode .form-control, :root.dark-mode .form-select {
        background-color: #1e293b !important;
        color: #e2e8f0 !important;
        border-color: #475569 !important;
    }

    :root.dark-mode .form-control:focus, :root.dark-mode .form-select:focus {
        border-color: #60a5fa !important;
        box-shadow: 0 0 0 0.2rem rgba(96, 165, 250, 0.25) !important;
    }

    :root.dark-mode .form-element .form-control, :root.dark-mode .form-element .form-select {
        background-color: #1e293b !important;
        color: #e2e8f0 !important;
        border-color: #475569 !important;
    }

    :root.dark-mode .form-element .form-control:focus, :root.dark-mode .form-element .form-select:focus {
        border-color: #60a5fa !important;
        box-shadow: 0 0 0 0.2rem rgba(96, 165, 250, 0.25) !important;
    }

    :root.dark-mode .form-check-input {
        background-color: #1e293b !important;
        border-color: #475569 !important;
    }

    :root.dark-mode .form-check-input:checked {
        background-color: #3b82f6 !important;
        border-color: #3b82f6 !important;
    }

    :root.dark-mode .form-check-label {
        color: #e2e8f0 !important;
    }

    :root.dark-mode .form-label {
        color: #e2e8f0 !important;
    }

    :root.dark-mode .text-muted {
        color: #94a3b8 !important;
    }

    :root.dark-mode .form-element h6 {
        color: #e2e8f0 !important;
    }

    :root.dark-mode .form-element label {
        color: #e2e8f0 !important;
    }

    :root.dark-mode .form-element p {
        color: #e2e8f0 !important;
    }

    :root.dark-mode .accordion-button {
        background-color: #334155 !important;
        color: #e2e8f0 !important;
    }

    :root.dark-mode .accordion-button:not(.collapsed) {
        background-color: #1a365d !important;
        color: #63b3ed !important;
    }

    :root.dark-mode .accordion-body {
        background-color: #1e293b !important;
    }

    :root.dark-mode .accordion-item {
        background-color: #1e293b !important;
        border-color: #475569 !important;
    }

    :root.dark-mode .accordion-header {
        background-color: #334155 !important;
    }

    /* Custom Modern Cursor */
    #custom-cursor {
        position: fixed;
        width: 20px;
        height: 20px;
        pointer-events: none;
        z-index: 9999;
        transition: transform 0.1s ease, opacity 0.3s ease;
        mix-blend-mode: difference;
    }

    .cursor-dot {
        position: absolute;
        width: 6px;
        height: 6px;
        background-color: #ffffff;
        border-radius: 50%;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        transition: all 0.2s ease;
    }

    .cursor-ring {
        position: absolute;
        width: 20px;
        height: 20px;
        border: 2px solid rgba(255, 255, 255, 0.7);
        border-radius: 50%;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        transition: all 0.2s ease;
    }

    .cursor-dot.dark-mode {
        background-color: #000000;
    }

    .cursor-ring.dark-mode {
        border-color: rgba(0, 0, 0, 0.7);
    }

    .cursor-hover .cursor-dot {
        transform: translate(-50%, -50%) scale(0);
    }

    .cursor-hover .cursor-ring {
        transform: translate(-50%, -50%) scale(1.5);
        border-color: rgba(74, 144, 226, 0.8);
    }

    .cursor-grab .cursor-ring {
        transform: translate(-50%, -50%) scale(1.2);
        border-style: dashed;
    }

    .cursor-grabbing .cursor-ring {
        transform: translate(-50%, -50%) scale(1.2) rotate(90deg);
        border-style: dashed;
        border-color: rgba(255, 100, 100, 0.8);
    }

    /* Hide default cursor */
    * {
        cursor: none !important;
    }

    /* Dark mode fixes for modal */
    :root.dark-mode .modal-content {
        background-color: #1e293b !important;
        color: #e2e8f0 !important;
    }

    :root.dark-mode .modal-header {
        background-color: #334155 !important;
        color: #e2e8f0 !important;
        border-color: #475569 !important;
    }

    :root.dark-mode .modal-footer {
        background-color: #334155 !important;
        border-color: #475569 !important;
    }

    :root.dark-mode .modal-body {
        background-color: #1e293b !important;
        color: #e2e8f0 !important;
    }

    :root.dark-mode .modal-content .btn-close {
        filter: invert(1) grayscale(100%) brightness(200%) !important;
    }

    :root.dark-mode .modal-content .form-control {
        background-color: #1e293b !important;
        color: #e2e8f0 !important;
        border-color: #475569 !important;
    }

    :root.dark-mode .modal-content .form-control:focus {
        border-color: #60a5fa !important;
        box-shadow: 0 0 0 0.2rem rgba(96, 165, 250, 0.25) !important;
    }

    :root.dark-mode .modal-content .form-label {
        color: #e2e8f0 !important;
    }

    :root.dark-mode .modal-content .input-group-text {
        background-color: #334155 !important;
        color: #e2e8f0 !important;
        border-color: #475569 !important;
    }

    :root.dark-mode .modal-content .btn {
        --bs-btn-color: #e2e8f0 !important;
    }

    :root.dark-mode .modal-content .btn-outline-primary {
        color: #60a5fa !important;
        border-color: #60a5fa !important;
    }

    :root.dark-mode .modal-content .btn-outline-primary:hover {
        background-color: #60a5fa !important;
        color: #1e293b !important;
    }

    :root.dark-mode .modal-content .btn-outline-danger {
        color: #f87171 !important;
        border-color: #f87171 !important;
    }

    :root.dark-mode .modal-content .btn-outline-danger:hover {
        background-color: #f87171 !important;
        color: #1e293b !important;
    }

    :root.dark-mode .modal-content .btn-secondary {
        background-color: #334155 !important;
        border-color: #475569 !important;
        color: #e2e8f0 !important;
    }

    :root.dark-mode .modal-content .btn-primary {
        background-color: #3b82f6 !important;
        border-color: #3b82f6 !important;
        color: white !important;
    }

    :root.dark-mode .modal-content .form-check-input {
        background-color: #1e293b !important;
        border-color: #475569 !important;
    }

    :root.dark-mode .modal-content .form-check-input:checked {
        background-color: #3b82f6 !important;
        border-color: #3b82f6 !important;
    }

    :root.dark-mode .modal-content .form-check-label {
        color: #e2e8f0 !important;
    }

    :root.dark-mode .modal-content .input-group .form-control {
        background-color: #1e293b !important;
        color: #e2e8f0 !important;
        border-color: #475569 !important;
    }

    :root.dark-mode .modal-content .input-group .btn {
        background-color: #334155 !important;
        border-color: #475569 !important;
        color: #e2e8f0 !important;
    }

    :root.dark-mode .modal-content .input-group .btn:hover {
        background-color: #475569 !important;
    }

    :root.dark-mode .modal-content h5 {
        color: #e2e8f0 !important;
    }

    /* Dark mode fixes for scrollable panels */
    :root.dark-mode .scrollable-panel {
        background-color: #1e293b !important;
    }

    :root.dark-mode .scrollable-panel::-webkit-scrollbar-track, :root.dark-mode .form-builder-area::-webkit-scrollbar-track {
        background: rgba(30, 41, 59, 0.5) !important;
    }

    :root.dark-mode .scrollable-panel::-webkit-scrollbar-thumb, :root.dark-mode .form-builder-area::-webkit-scrollbar-thumb {
        background: #3b82f6 !important;
    }

    :root.dark-mode .scrollable-panel::-webkit-scrollbar-thumb:hover, :root.dark-mode .form-builder-area::-webkit-scrollbar-thumb:hover {
        background: #60a5fa !important;
    }

    /* Dark mode fixes for alerts */
    :root.dark-mode .alert {
        background-color: #334155 !important;
        color: #e2e8f0 !important;
        border-color: #475569 !important;
    }

    :root.dark-mode .alert-success {
        background-color: #166534 !important;
        color: #dcfce7 !important;
        border-color: #15803d !important;
    }

    :root.dark-mode .alert-danger {
        background-color: #7f1d1d !important;
        color: #fee2e2 !important;
        border-color: #991b1b !important;
    }

    :root.dark-mode .alert .btn-close {
        filter: invert(1) grayscale(100%) brightness(200%) !important;
    }

    /* Additional dark mode fixes for form builder sections */
    :root.dark-mode #formBuilderArea {
        background-color: #1e293b !important;
    }

    :root.dark-mode .bg-white {
        background-color: #1e293b !important;
    }

    :root.dark-mode .card-header.bg-white {
        background-color: #334155 !important;
    }

    :root.dark-mode #emptyFormMessage .text-muted {
        color: #94a3b8 !important;
    }

    :root.dark-mode #emptyFormMessage h5 {
        color: #e2e8f0 !important;
    }

    :root.dark-mode #emptyFormMessage p {
        color: #94a3b8 !important;
    }

    :root.dark-mode .d-grid .btn {
        background-color: transparent !important;
    }

    :root.dark-mode .d-grid .btn:hover {
        background-color: rgba(96, 165, 250, 0.1) !important;
    }

    :root.dark-mode .small, :root.dark-mode small {
        color: #94a3b8 !important;
    }

    :root.dark-mode h6 {
        color: #e2e8f0 !important;
    }

    :root.dark-mode .border-bottom {
        border-color: #475569 !important;
    }

    /* Accordion styles */
    .accordion-button:not(.collapsed) {
        background-color: #e7f3ff;
        color: #4a90e2;
    }

    :root.dark-mode .accordion-button:not(.collapsed) {
        background-color: #1a365d;
        color: #63b3ed;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Provide subjects list (active) to builder for special multi-select preview of desired_subject
    window.subjectsList = <?php echo json_encode(isset($subjects) ? $subjects->map(fn($s)=>['code'=>$s->code,'name'=>$s->name]) : []); ?>;
        let formElements = [];
        let selectedElementId = null;

        // Keyboard Shortcuts Plan / Mapping (will be wired below):
        // Ctrl+S (or Cmd+S) -> Save form
        // Ctrl+P (or Cmd+P) -> Preview form
        // Ctrl+Shift+T -> Apply admission template
        // Del / Backspace -> Delete selected element
        // Alt+ArrowUp -> Move selected element up
        // Alt+ArrowDown -> Move selected element down
        // Ctrl+D -> Duplicate selected element
        // Ctrl+R -> Toggle required on selected element
        // Enter (when element selected and not editing) -> Open edit modal
        // ? (Shift+/) -> Toggle shortcuts help overlay

        // Load existing form fields if any
        // Check if form fields exist and initialize them
        var formFieldsData = <?php echo isset($form->fields) ? json_encode($form->fields) : 'null'; ?>;
        if (formFieldsData) {
            try {
                if (typeof formFieldsData === 'object' && formFieldsData.elements) {
                    formElements = formFieldsData.elements || [];
                } else if (Array.isArray(formFieldsData)) {
                    formElements = formFieldsData;
                }
                renderFormElements();
            } catch(e) {
                console.error('Error loading form fields:', e);
                formElements = [];
            }
        }

        // Help button
        document.getElementById('showKbHelpBtn').addEventListener('click', function(){
            const evt = new KeyboardEvent('keydown', {key:'?'});
            document.dispatchEvent(evt);
        });

        // Make elements draggable
        document.querySelectorAll('.draggable-element').forEach(element => {
            element.addEventListener('click', function() {
                const type = this.getAttribute('data-type');
                addFormElement(type);
            });
        });

        // Make template elements draggable
        document.querySelectorAll('.draggable-template').forEach(element => {
            element.addEventListener('click', function() {
                const type = this.getAttribute('data-type');
                const fieldName = this.getAttribute('data-field-name');
                const label = this.getAttribute('data-label');
                const optionsAttr = this.getAttribute('data-options');
                const required = this.getAttribute('data-required') === '1';
                const multisubject = this.getAttribute('data-multisubject') === '1';

                // Properly parse options attribute
                let options = [];
                if (optionsAttr) {
                    try {
                        // Try to parse as JSON first
                        options = JSON.parse(optionsAttr);
                    } catch (e) {
                        // If JSON parsing fails, try to split by comma
                        if (optionsAttr.includes(',')) {
                            options = optionsAttr.split(',').map(opt => opt.trim());
                        } else {
                            // Single option
                            options = [optionsAttr];
                        }
                    }
                }

                addTemplateElement(type, fieldName, label, options, required, multisubject);
            });
        });

        // Save form button
        document.getElementById('saveFormBtn').addEventListener('click', saveForm);

        // Preview form button
        document.getElementById('previewFormBtn').addEventListener('click', previewForm);

        // Apply admission template button
        document.getElementById('applyAdmissionTemplateBtn').addEventListener('click', applyAdmissionTemplate);

        // Add all admission fields button
        document.getElementById('addAllAdmissionFieldsBtn').addEventListener('click', addAllAdmissionFields);

        // Clear fields button
        document.getElementById('clearFieldsBtn').addEventListener('click', clearFields);

        // Function to add form element
        function addFormElement(type) {
            const elementId = 'element_' + Date.now() + '_' + Math.floor(Math.random() * 1000);
            const element = {
                id: elementId,
                type: type,
                label: getDefaultLabel(type),
                fieldName: getDefaultFieldName(type),
                required: false,
                options: getDefaultOptions(type)
            };

            formElements.push(element);
            renderFormElements();
            selectElement(elementId);
        }

        // Function to add template element
        function addTemplateElement(type, fieldName, label, options, required = false, multisubject = false) {
            const elementId = 'element_' + Date.now() + '_' + Math.floor(Math.random() * 1000);

            const element = {
                id: elementId,
                type: type,
                label: label,
                fieldName: fieldName,
                required: required,
                multisubject: multisubject,
                options: Array.isArray(options) ? options : []
            };

            formElements.push(element);
            renderFormElements();
            selectElement(elementId);
        }

        // Function to get default label based on type
        function getDefaultLabel(type) {
            const labels = {
                'section': 'Section Title',
                'text': 'Short Answer',
                'textarea': 'Paragraph',
                'radio': 'Multiple Choice',
                'checkbox': 'Checkboxes',
                'select': 'Dropdown',
                'file': 'File Upload',
                'date': 'Date'
            };
            return labels[type] || 'New Question';
        }

        // Function to get default field name based on type
        function getDefaultFieldName(type) {
            const names = {
                'section': 'section_title_' + Date.now(),
                'text': 'short_answer_' + Date.now(),
                'textarea': 'paragraph_' + Date.now(),
                'radio': 'multiple_choice_' + Date.now(),
                'checkbox': 'checkboxes_' + Date.now(),
                'select': 'dropdown_' + Date.now(),
                'file': 'file_upload_' + Date.now(),
                'date': 'date_' + Date.now()
            };
            return names[type] || 'field_' + Date.now();
        }

        // Function to get default options based on type
        function getDefaultOptions(type) {
            const options = {
                'radio': ['Option 1', 'Option 2'],
                'checkbox': ['Option 1', 'Option 2'],
                'select': ['Option 1', 'Option 2']
            };
            return options[type] || [];
        }

        // Function to render form elements
        function renderFormElements() {
            const formContainer = document.getElementById('formContainer');
            formContainer.innerHTML = '';

            formElements.forEach(element => {
                const elementDiv = document.createElement('div');
                elementDiv.className = 'form-element';
                elementDiv.id = element.id;

                const label = document.createElement('label');
                label.textContent = element.label;
                elementDiv.appendChild(label);

                const input = document.createElement('input');
                input.type = element.type;
                input.name = element.fieldName;
                input.required = element.required;
                elementDiv.appendChild(input);

                if (element.options.length > 0) {
                    const select = document.createElement('select');
                    element.options.forEach(option => {
                        const optionElement = document.createElement('option');
                        optionElement.value = option;
                        optionElement.textContent = option;
                        select.appendChild(optionElement);
                    });
                    elementDiv.appendChild(select);
                }

                formContainer.appendChild(elementDiv);
            });
        }

        // Function to select an element
        function selectElement(elementId) {
            formElements.forEach(element => {
                const elementDiv = document.getElementById(element.id);
                if (element.id === elementId) {
                    elementDiv.classList.add('selected');
                } else {
                    elementDiv.classList.remove('selected');
                }
            });
        }

        // Function to save form
        function saveForm() {
            const formData = JSON.stringify(formElements);
            console.log('Form Data:', formData);
            // Here you can add code to send formData to the server
        }

        // Function to preview form
        function previewForm() {
            const previewContainer = document.getElementById('previewContainer');
            previewContainer.innerHTML = '';

            formElements.forEach(element => {
                const elementDiv = document.createElement('div');
                elementDiv.className = 'form-element';

                const label = document.createElement('label');
                label.textContent = element.label;
                elementDiv.appendChild(label);

                const input = document.createElement('input');
                input.type = element.type;
                input.name = element.fieldName;
                input.required = element.required;
                elementDiv.appendChild(input);

                if (element.options.length > 0) {
                    const select = document.createElement('select');
                    element.options.forEach(option => {
                        const optionElement = document.createElement('option');
                        optionElement.value = option;
                        optionElement.textContent = option;
                        select.appendChild(optionElement);
                    });
                    elementDiv.appendChild(select);
                }

                previewContainer.appendChild(elementDiv);
            });
        }

        // Function to apply admission template
        function applyAdmissionTemplate() {
            const admissionTemplate = [
                {
                    type: 'section',
                    label: 'Personal Information',
                    fieldName: 'personal_information',
                    required: true,
                    options: []
                },
                {
                    type: 'text',
                    label: 'Full Name',
                    fieldName: 'full_name',
                    required: true,
                    options: []
                },
                {
                    type: 'date',
                    label: 'Date of Birth',
                    fieldName: 'date_of_birth',
                    required: true,
                    options: []
                },
                {
                    type: 'select',
                    label: 'Gender',
                    fieldName: 'gender',
                    required: true,
                    options: ['Male', 'Female', 'Other']
                },
                {
                    type: 'text',
                    label: 'Email Address',
                    fieldName: 'email_address',
                    required: true,
                    options: []
                },
                {
                    type: 'text',
                    label: 'Phone Number',
                    fieldName: 'phone_number',
                    required: true,
                    options: []
                },
                {
                    type: 'section',
                    label: 'Academic Information',
                    fieldName: 'academic_information',
                    required: true,
                    options: []
                },
                {
                    type: 'text',
                    label: 'High School Name',
                    fieldName: 'high_school_name',
                    required: true,
                    options: []
                },
                {
                    type: 'text',
                    label: 'High School GPA',
                    fieldName: 'high_school_gpa',
                    required: true,
                    options: []
                },
                {
                    type: 'text',
                    label: 'College Name',
                    fieldName: 'college_name',
                    required: true,
                    options: []
                },
                {
                    type: 'text',
                    label: 'College GPA',
                    fieldName: 'college_gpa',
                    required: true,
                    options: []
                },
                {
                    type: 'section',
                    label: 'Additional Information',
                    fieldName: 'additional_information',
                    required: true,
                    options: []
                },
                {
                    type: 'textarea',
                    label: 'Why do you want to join?',
                    fieldName: 'why_join',
                    required: true,
                    options: []
                },
                {
                    type: 'textarea',
                    label: 'Any additional comments',
                    fieldName: 'additional_comments',
                    required: false,
                    options: []
                }
            ];

            formElements = admissionTemplate;
            renderFormElements();
        }

        // Function to add all admission fields
        function addAllAdmissionFields() {
            const admissionFields = [
                {
                    type: 'text',
                    label: 'Full Name',
                    fieldName: 'full_name',
                    required: true,
                    options: []
                },
                {
                    type: 'date',
                    label: 'Date of Birth',
                    fieldName: 'date_of_birth',
                    required: true,
                    options: []
                },
                {
                    type: 'select',
                    label: 'Gender',
                    fieldName: 'gender',
                    required: true,
                    options: ['Male', 'Female', 'Other']
                },
                {
                    type: 'text',
                    label: 'Email Address',
                    fieldName: 'email_address',
                    required: true,
                    options: []
                },
                {
                    type: 'text',
                    label: 'Phone Number',
                    fieldName: 'phone_number',
                    required: true,
                    options: []
                },
                {
                    type: 'text',
                    label: 'High School Name',
                    fieldName: 'high_school_name',
                    required: true,
                    options: []
                },
                {
                    type: 'text',
                    label: 'High School GPA',
                    fieldName: 'high_school_gpa',
                    required: true,
                    options: []
                },
                {
                    type: 'text',
                    label: 'College Name',
                    fieldName: 'college_name',
                    required: true,
                    options: []
                },
                {
                    type: 'text',
                    label: 'College GPA',
                    fieldName: 'college_gpa',
                    required: true,
                    options: []
                },
                {
                    type: 'textarea',
                    label: 'Why do you want to join?',
                    fieldName: 'why_join',
                    required: true,
                    options: []
                },
                {
                    type: 'textarea',
                    label: 'Any additional comments',
                    fieldName: 'additional_comments',
                    required: false,
                    options: []
                }
            ];

            admissionFields.forEach(field => {
                addTemplateElement(field.type, field.fieldName, field.label, field.options, field.required);
            });
        }

        // Function to clear fields
        function clearFields() {
            formElements = [];
            renderFormElements();
        }

        // Function to get default field name based on type
        function getDefaultFieldName(type) {
            const names = {
                'text': 'short_answer_' + Date.now(),
                'textarea': 'paragraph_' + Date.now(),
                'radio': 'multiple_choice_' + Date.now(),
                'checkbox': 'checkboxes_' + Date.now(),
                'select': 'dropdown_' + Date.now(),
                'file': 'file_upload_' + Date.now(),
                'date': 'date_' + Date.now()
            };
            return names[type] || 'field_' + Date.now();
        }

        // Function to get default options based on type
        function getDefaultOptions(type) {
            switch(type) {
                case 'radio':
                case 'checkbox':
                case 'select':
                    return ['Option 1', 'Option 2'];
                default:
                    return [];
            }
        }

        // Function to render form elements
        function renderFormElements() {
            const container = document.getElementById('formElementsContainer');
            const emptyMessage = document.getElementById('emptyFormMessage');

            if (formElements.length === 0) {
                emptyMessage.style.display = 'block';
                container.innerHTML = '';
                return;
            }

            emptyMessage.style.display = 'none';
            container.innerHTML = '';

            formElements.forEach((element, index) => {
                const elementDiv = document.createElement('div');
                elementDiv.className = 'form-element';
                elementDiv.setAttribute('data-id', element.id);
                if (element.id === selectedElementId) {
                    elementDiv.classList.add('selected');
                }

                elementDiv.innerHTML = `
                    <div class="form-element-header">
                        <div class="form-element-title">
                            <h6 class="mb-0">${element.label}</h6>
                        </div>
                        <div class="element-actions">
                            <button class="btn btn-sm btn-outline-secondary move-up" ${index === 0 ? 'disabled' : ''}>
                                <i class='bx bx-up-arrow-alt'></i>
                            </button>
                            <button class="btn btn-sm btn-outline-secondary move-down" ${index === formElements.length - 1 ? 'disabled' : ''}>
                                <i class='bx bx-down-arrow-alt'></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger delete-element">
                                <i class='bx bx-trash'></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-element-content">
                        ${renderElementPreview(element)}
                    </div>
                    <div class="form-element-footer">
                        <div class="form-check form-switch">
                            <input class="form-check-input required-toggle" type="checkbox" id="required_${element.id}" ${element.required ? 'checked' : ''}>
                            <label class="form-check-label" for="required_${element.id}">Required</label>
                        </div>
                        <button class="btn btn-sm btn-outline-primary edit-element">
                            <i class='bx bx-edit-alt me-1'></i>Edit
                        </button>
                    </div>
                `;

                container.appendChild(elementDiv);

                // Add event listeners
                elementDiv.querySelector('.delete-element').addEventListener('click', () => {
                    deleteElement(element.id);
                });

                elementDiv.querySelector('.move-up').addEventListener('click', () => {
                    moveElementUp(index);
                });

                elementDiv.querySelector('.move-down').addEventListener('click', () => {
                    moveElementDown(index);
                });

                elementDiv.querySelector('.edit-element').addEventListener('click', () => {
                    editElement(element);
                });

                elementDiv.querySelector('.required-toggle').addEventListener('change', (e) => {
                    element.required = e.target.checked;
                });

                // Add click to select
                elementDiv.addEventListener('click', (e) => {
                    if (!e.target.closest('.element-actions') &&
                        !e.target.closest('.form-element-footer') &&
                        !e.target.closest('.delete-element') &&
                        !e.target.closest('.move-up') &&
                        !e.target.closest('.move-down') &&
                        !e.target.closest('.edit-element') &&
                        !e.target.closest('.required-toggle')) {
                        selectElement(element.id);
                    }
                });
            });
        }

        // Function to render element preview
        function renderElementPreview(element) {
            switch(element.type) {
                case 'section':
                    return `<h4 class="border-bottom pb-2">${element.label}</h4>`;
                case 'text':
                    // Special case: desired_subject field renders as multi-select (subjects from DB) in public form
                    if(element.fieldName === 'desired_subject' && Array.isArray(window.subjectsList) && window.subjectsList.length){
                        const optionsHtml = window.subjectsList.map(s => `<option value="${s.code}">${s.name}</option>`).join('');
                        return `
                            <label class="form-label">${element.label} ${element.required ? '<span class="text-danger">*</span>' : ''}</label>
                            <select multiple class="form-select" disabled title="Public form এ মাল্টি-সিলেক্ট হিসেবে রেন্ডার হবে">
                                ${optionsHtml}
                            </select>
                            <div class="form-text">(Builder preview) পাবলিক ফর্মে ব্যবহারকারী একাধিক বিষয় নির্বাচন করতে পারবে</div>
                        `;
                    }
                    return `
                        <label class="form-label">${element.label} ${element.required ? '<span class="text-danger">*</span>' : ''}</label>
                        <input type="text" class="form-control" placeholder="Short answer text" readonly>
                    `;
                case 'textarea':
                    return `
                        <label class="form-label">${element.label} ${element.required ? '<span class="text-danger">*</span>' : ''}</label>
                        <textarea class="form-control" rows="3" placeholder="Long answer text" readonly></textarea>
                    `;
                case 'radio':
                    let radioHtml = `<label class="form-label">${element.label} ${element.required ? '<span class="text-danger">*</span>' : ''}</label>`;
                    element.options.forEach((option, i) => {
                        radioHtml += `
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="${element.fieldName}" id="${element.fieldName}_${i}" disabled>
                                <label class="form-check-label" for="${element.fieldName}_${i}">${option}</label>
                            </div>
                        `;
                    });
                    return radioHtml;
                case 'checkbox':
                    let checkboxHtml = `<label class="form-label">${element.label} ${element.required ? '<span class="text-danger">*</span>' : ''}</label>`;
                    element.options.forEach((option, i) => {
                        checkboxHtml += `
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="${element.fieldName}[]" id="${element.fieldName}_${i}" disabled>
                                <label class="form-check-label" for="${element.fieldName}_${i}">${option}</label>
                            </div>
                        `;
                    });
                    return checkboxHtml;
                case 'select':
                    let selectHtml = `<label class="form-label">${element.label} ${element.required ? '<span class="text-danger">*</span>' : ''}</label>`;

                    // Special handling for location dropdowns
                    if (element.fieldName === 'division' || element.fieldName === 'district' || element.fieldName === 'upazila' ||
                        element.fieldName === 'permanent_division' || element.fieldName === 'permanent_district' || element.fieldName === 'permanent_upazila') {
                        selectHtml += `<select class="form-select" disabled><option>লোড হচ্ছে...</option></select>`;

                        // Add JavaScript to populate the dropdown when the element is rendered
                        setTimeout(() => {
                            if (window.locationsData) {
                                const selectElement = document.querySelector(`[data-id="${element.id}"] select`);
                                if (selectElement) {
                                    selectElement.innerHTML = '<option value="">নির্বাচন করুন</option>';

                                    if (element.fieldName === 'division') {
                                        window.locationsData.divisions.forEach(division => {
                                            const option = document.createElement('option');
                                            option.value = division.name;
                                            option.textContent = division.name;
                                            selectElement.appendChild(option);
                                        });
                                    }
                                }
                            }
                        }, 100);
                    } else {
                        selectHtml += `<select class="form-select" disabled><option>Select an option</option>`;
                        element.options.forEach(option => {
                            selectHtml += `<option>${option}</option>`;
                        });
                        selectHtml += `</select>`;
                    }
                    return selectHtml;
                case 'file':
                    return `
                        <label class="form-label">${element.label} ${element.required ? '<span class="text-danger">*</span>' : ''}</label>
                        <input type="file" class="form-control" disabled>
                    `;
                case 'date':
                    return `
                        <label class="form-label">${element.label} ${element.required ? '<span class="text-danger">*</span>' : ''}</label>
                        <input type="date" class="form-control" disabled>
                    `;
                default:
                    return `<p>Preview not available</p>`;
            }
        }

        // Function to select element
        function selectElement(elementId, scrollIntoView = false) {
            if(!elementId) return;
            selectedElementId = elementId;
            // Re-render to apply highlight
            renderFormElements();
            if(scrollIntoView) {
                const el = document.querySelector('.form-element[data-id="'+elementId+'"]');
                if(el) {
                    el.scrollIntoView({behavior:'smooth', block:'center'});
                }
            }
        }

        // Function to delete element
        function deleteElement(elementId) {
            formElements = formElements.filter(element => element.id !== elementId);
            if (selectedElementId === elementId) {
                selectedElementId = null;
            }
            renderFormElements();
        }

        // Function to move element up
        function moveElementUp(index) {
            if (index > 0) {
                [formElements[index - 1], formElements[index]] = [formElements[index], formElements[index - 1]];
                renderFormElements();
            }
        }

        // Function to move element down
        function moveElementDown(index) {
            if (index < formElements.length - 1) {
                [formElements[index], formElements[index + 1]] = [formElements[index + 1], formElements[index]];
                renderFormElements();
            }
        }

        // Function to edit element
        function editElement(element) {
            // Ensure options is an array
            const options = Array.isArray(element.options) ? element.options : [];
            
            // Create modal for editing
            const modalHtml = `
                <div class="modal fade" id="editElementModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Question</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Question Title</label>
                                    <input type="text" class="form-control" id="editLabel" value="${element.label}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Field Name</label>
                                    <input type="text" class="form-control" id="editFieldName" value="${element.fieldName}">
                                </div>
                                ${(element.type === 'radio' || element.type === 'checkbox' || element.type === 'select') ? `
                                <div class="mb-3">
                                    <label class="form-label">Options</label>
                                    ${(
                                        element.fieldName === 'division' ||
                                        element.fieldName === 'district' ||
                                        element.fieldName === 'upazila' ||
                                        element.fieldName === 'permanent_division' ||
                                        element.fieldName === 'permanent_district' ||
                                        element.fieldName === 'permanent_upazila'
                                    ) ?
                                    `<p class="text-muted">This is a location dropdown that will be automatically populated with data from locations.json</p>` :
                                    `<div id="editOptionsContainer">
                                        ${options.map((option, i) => {
                                            // Handle both string options and object options
                                            const optionValue = typeof option === 'object' && option !== null ? 
                                                (option.label || option.value || JSON.stringify(option)) : 
                                                (typeof option === 'string' ? option : JSON.stringify(option));
                                            return `
                                            <div class="input-group mb-2">
                                                <input type="text" class="form-control" value="${optionValue.replace(/"/g, '&quot;')}" data-option-index="${i}">
                                                <button class="btn btn-outline-danger remove-option" type="button" data-option-index="${i}">Remove</button>
                                            </div>
                                        `}).join('')}
                                    </div>
                                    <button class="btn btn-outline-primary btn-sm mt-2" id="addOptionBtn">Add Option</button>`}
                                </div>
                                ` : ''}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary" id="saveElementChanges">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            // Add modal to body
            document.body.insertAdjacentHTML('beforeend', modalHtml);

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('editElementModal'));
            modal.show();

            // Add event listeners for modal
            document.getElementById('addOptionBtn')?.addEventListener('click', function() {
                const container = document.getElementById('editOptionsContainer');
                const optionCount = container.querySelectorAll('.input-group').length;
                const newOptionHtml = `
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" placeholder="Option ${optionCount + 1}">
                        <button class="btn btn-outline-danger remove-option" type="button">Remove</button>
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', newOptionHtml);

                // Add event listener to new remove button
                container.lastElementChild.querySelector('.remove-option').addEventListener('click', function() {
                    this.closest('.input-group').remove();
                });
            });

            // Add event listeners to remove buttons
            document.querySelectorAll('.remove-option').forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('.input-group').remove();
                });
            });

            // Save changes
            document.getElementById('saveElementChanges').addEventListener('click', function() {
                element.label = document.getElementById('editLabel').value;
                element.fieldName = document.getElementById('editFieldName').value;

                // Only update options for non-location dropdowns
                if ((element.type === 'radio' || element.type === 'checkbox' || element.type === 'select') &&
                    element.fieldName !== 'division' &&
                    element.fieldName !== 'district' &&
                    element.fieldName !== 'upazila' &&
                    element.fieldName !== 'permanent_division' &&
                    element.fieldName !== 'permanent_district' &&
                    element.fieldName !== 'permanent_upazila') {
                    const optionInputs = document.querySelectorAll('#editOptionsContainer input[type="text"]');
                    element.options = Array.from(optionInputs).map(input => input.value).filter(value => value.trim() !== '');
                }

                renderFormElements();
                modal.hide();
                document.getElementById('editElementModal').remove();
            });

            // Remove modal from DOM when hidden
            document.getElementById('editElementModal').addEventListener('hidden.bs.modal', function() {
                this.remove();
            });
        }

        // Function to apply admission form template
        function applyAdmissionTemplate() {
            if (confirm('Are you sure you want to apply the admission form template? This will replace all current form elements.')) {
                // Clear existing elements
                formElements = [];

                // Add all admission form template elements
                const templateElements = [
                    // Student Photo
                    {
                        id: 'element_' + Date.now() + '_1',
                        type: 'file',
                        label: 'ছবি সংযুক্ত করার বক্স',
                        fieldName: 'student_photo',
                        required: true,
                        options: []
                    },
                    // Personal Information Section
                    {
                        id: 'element_' + Date.now() + '_2',
                        type: 'section',
                        label: 'ব্যক্তিগত তথ্য',
                        fieldName: 'personal_information',
                        required: false,
                        options: []
                    },
                    {
                        id: 'element_' + Date.now() + '_3',
                        type: 'text',
                        label: 'শিক্ষার্থীর নাম (বাংলায়)',
                        fieldName: 'student_name_bengali',
                        required: true,
                        options: []
                    },
                    {
                        id: 'element_' + Date.now() + '_4',
                        type: 'text',
                        label: 'শিক্ষার্থীর নাম (ইংরেজিতে, বড় হাতের অক্ষরে)',
                        fieldName: 'student_name_english',
                        required: true,
                        options: []
                    },
                    {
                        id: 'element_' + Date.now() + '_5',
                        type: 'text',
                        label: 'পিতার নাম (বাংলায়)',
                        fieldName: 'father_name_bengali',
                        required: true,
                        options: []
                    },
                    {
                        id: 'element_' + Date.now() + '_6',
                        type: 'text',
                        label: 'পিতার নাম (ইংরেজিতে, বড় হাতের অক্ষরে)',
                        fieldName: 'father_name_english',
                        required: true,
                        options: []
                    },
                    // Address Section
                    {
                        id: 'element_' + Date.now() + '_7',
                        type: 'section',
                        label: 'ঠিকানা',
                        fieldName: 'address',
                        required: false,
                        options: []
                    },
                    {
                        id: 'element_' + Date.now() + '_8a',
                        type: 'select',
                        label: 'বর্তমান ঠিকানা - বিভাগ',
                        fieldName: 'division',
                        required: true,
                        options: []
                    },
                    {
                        id: 'element_' + Date.now() + '_8b',
                        type: 'select',
                        label: 'বর্তমান ঠিকানা - জেলা',
                        fieldName: 'district',
                        required: true,
                        options: []
                    },
                    {
                        id: 'element_' + Date.now() + '_8c',
                        type: 'select',
                        label: 'বর্তমান ঠিকানা - উপজেলা',
                        fieldName: 'upazila',
                        required: true,
                        options: []
                    },
                    {
                        id: 'element_' + Date.now() + '_8d',
                        type: 'text',
                        label: 'বর্তমান ঠিকানা - গ্রাম/মহল্লা, বাসা/হোল্ডিং নং, ডাকঘর',
                        fieldName: 'address_details',
                        required: true,
                        options: []
                    },
                    // Contact Information
                    {
                        id: 'element_' + Date.now() + '_9',
                        type: 'text',
                        label: 'মোবাইল নম্বর (শিক্ষার্থীর)',
                        fieldName: 'student_mobile_number',
                        required: true,
                        options: []
                    }
                ];

                formElements = templateElements;
                renderFormElements();
            }
        }

        // Function to add all admission fields
        function addAllAdmissionFields() {
            if (confirm('Add all admission form fields to the current form?')) {
                // Add all admission form template elements
                const templateElements = [
                    // Student Photo
                    {
                        id: 'element_' + Date.now() + '_1',
                        type: 'file',
                        label: 'ছবি সংযুক্ত করার বক্স',
                        fieldName: 'student_photo',
                        required: true,
                        options: []
                    },
                    // Personal Information Section
                    {
                        id: 'element_' + Date.now() + '_2',
                        type: 'section',
                        label: 'ব্যক্তিগত তথ্য',
                        fieldName: 'personal_information',
                        required: false,
                        options: []
                    },
                    {
                        id: 'element_' + Date.now() + '_3',
                        type: 'text',
                        label: 'শিক্ষার্থীর নাম (বাংলায়)',
                        fieldName: 'student_name_bengali',
                        required: true,
                        options: []
                    },
                    {
                        id: 'element_' + Date.now() + '_4',
                        type: 'text',
                        label: 'শিক্ষার্থীর নাম (ইংরেজিতে, বড় হাতের অক্ষরে)',
                        fieldName: 'student_name_english',
                        required: true,
                        options: []
                    },
                    {
                        id: 'element_' + Date.now() + '_5',
                        type: 'text',
                        label: 'পিতার নাম (বাংলায়)',
                        fieldName: 'father_name_bengali',
                        required: true,
                        options: []
                    },
                    {
                        id: 'element_' + Date.now() + '_6',
                        type: 'text',
                        label: 'পিতার নাম (ইংরেজিতে, বড় হাতের অক্ষরে)',
                        fieldName: 'father_name_english',
                        required: true,
                        options: []
                    },
                    {
                        id: 'element_' + Date.now() + '_7',
                        type: 'text',
                        label: 'পিতার পেশা',
                        fieldName: 'father_occupation',
                        required: true,
                        options: []
                    },
                    {
                        id: 'element_' + Date.now() + '_8',
                        type: 'text',
                        label: 'পিতার মোবাইল নম্বর',
                        fieldName: 'father_mobile_number',
                        required: true,
                        options: []
                    },
                    {
                        id: 'element_' + Date.now() + '_9',
                        type: 'text',
                        label: 'মাতার নাম (বাংলায়)',
                        fieldName: 'mother_name_bengali',
                        required: true,
                        options: []
                    },
                    {
                        id: 'element_' + Date.now() + '_10',
                        type: 'text',
                        label: 'মাতার নাম (ইংরেজিতে, বড় হাতের অক্ষরে)',
                        fieldName: 'mother_name_english',
                        required: true,
                        options: []
                    },
                    {
                        id: 'element_' + Date.now() + '_11',
                        type: 'text',
                        label: 'মাতার পেশা',
                        fieldName: 'mother_occupation',
                        required: true,
                        options: []
                    },
                    {
                        id: 'element_' + Date.now() + '_12',
                        type: 'text',
                        label: 'মাতার মোবাইল নম্বর',
                        fieldName: 'mother_mobile_number',
                        required: true,
                        options: []
                    },
                    {
                        id: 'element_' + Date.now() + '_13',
                        type: 'text',
                        label: 'জাতীয় পরিচয়পত্র / জন্ম নিবন্ধন নম্বর',
                        fieldName: 'nid_or_birth_certificate_no',
                        required: true,
                        options: []
                    },
                    {
                        id: 'element_' + Date.now() + '_14',
                        type: 'date',
                        label: 'জন্ম তারিখ (দিন/মাস/বছর)',
                        fieldName: 'date_of_birth',
                        required: true,
                        options: []
                    },
                    {
                        id: 'element_' + Date.now() + '_15',
                        type: 'select',
                        label: 'ধর্ম',
                        fieldName: 'religion',
                        required: true,
                        options: ['ইসলাম', 'হিন্দু', 'খ্রিস্টান', 'বৌদ্ধ', 'অন্যান্য']
                    },
                    {
                        id: 'element_' + Date.now() + '_16',
                        type: 'select',
                        label: 'লিঙ্গ',
                        fieldName: 'gender',
                        required: true,
                        options: ['পুরুষ', 'মহিলা', 'অন্যান্য']
                    },
                    {
                        id: 'element_' + Date.now() + '_17',
                        type: 'text',
                        label: 'জাতীয়তা',
                        fieldName: 'nationality',
                        required: true,
                        options: []
                    },
                    {
                        id: 'element_' + Date.now() + '_18',
                        type: 'select',
                        label: 'রক্তের গ্রুপ',
                        fieldName: 'blood_group',
                        required: true,
                        options: ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']
                    },
                    // Address Section
                    {
                        id: 'element_' + Date.now() + '_19',
                        type: 'section',
                        label: 'ঠিকানা',
                        fieldName: 'address',
                        required: false,
                        options: []
                    },
                    {
                        id: 'element_' + Date.now() + '_20a',
                        type: 'select',
                        label: 'বর্তমান ঠিকানা - বিভাগ',
                        fieldName: 'division',
                        required: true,
                        options: []
                    },
                    {
                        id: 'element_' + Date.now() + '_20b',
                        type: 'select',
                        label: 'বর্তমান ঠিকানা - জেলা',
                        fieldName: 'district',
                        required: true,
                        options: []
                    },
                    {
                        id: 'element_' + Date.now() + '_20c',
                        type: 'select',
                        label: 'বর্তমান ঠিকানা - উপজেলা',
                        fieldName: 'upazila',
                        required: true,
                        options: []
                    },
                    {
                        id: 'element_' + Date.now() + '_20d',
                        type: 'text',
                        label: 'বর্তমান ঠিকানা - গ্রাম/মহল্লা, বাসা/হোল্ডিং নং, ডাকঘর',
                        fieldName: 'address_details',
                        required: true,
                        options: []
                    },
                    {
                        id: 'element_' + Date.now() + '_21',
                        type: 'checkbox',
                        label: 'বর্তমান ও স্থায়ী ঠিকানা একই হলে টিক দিন',
                        fieldName: 'is_permanent_address_same_as_present',
                        required: false,
                        options: ['ঠিকানা একই']
                    },
                    {
                        id: 'element_' + Date.now() + '_22a',
                        type: 'select',
                        label: 'স্থায়ী ঠিকানা - বিভাগ',
                        fieldName: 'permanent_division',
                        required: false,
                        options: []
                    },
                    {
                        id: 'element_' + Date.now() + '_22b',
                        type: 'select',
                        label: 'স্থায়ী ঠিকানা - জেলা',
                        fieldName: 'permanent_district',
                        required: false,
                        options: []
                    },
                    {
                        id: 'element_' + Date.now() + '_22c',
                        type: 'select',
                        label: 'স্থায়ী ঠিকানা - উপজেলা',
                        fieldName: 'permanent_upazila',
                        required: false,
                        options: []
                    },
                    {
                        id: 'element_' + Date.now() + '_22d',
                        type: 'text',
                        label: 'স্থায়ী ঠিকানা - গ্রাম/মহল্লা, বাসা/হোল্ডিং নং, ডাকঘর',
                        fieldName: 'permanent_address_details',
                        required: false,
                        options: []
                    },
                    // Workshop & Admission Information
                    {
                        id: 'element_' + Date.now() + '_23',
                        type: 'section',
                        label: 'কর্মশালা ও ভর্তি সংক্রান্ত তথ্য',
                        fieldName: 'workshop_admission_info',
                        required: false,
                        options: []
                    },
                    {
                        id: 'element_' + Date.now() + '_24',
                        type: 'date',
                        label: 'কর্মশালায় উত্তীর্ণের তারিখ',
                        fieldName: 'workshop_passing_date',
                        required: true,
                        options: []
                    },
                    {
                        id: 'element_' + Date.now() + '_25',
                        type: 'text',
                        label: 'কর্মশালায় উত্তীর্ণের বিষয়',
                        fieldName: 'workshop_passing_subject',
                        required: true,
                        options: []
                    },
                    {
                        id: 'element_' + Date.now() + '_26',
                        type: 'text',
                        label: 'কর্মশালার রেজিস্ট্রেশন নম্বর',
                        fieldName: 'workshop_registration_no',
                        required: true,
                        options: []
                    },
                    {
                        id: 'element_' + Date.now() + '_27',
                        type: 'text',
                        label: 'ভর্তিচ্ছু বিষয়',
                        fieldName: 'desired_subject',
                        required: true,
                        options: []
                    },
                    // Last Educational Qualification
                    {
                        id: 'element_' + Date.now() + '_28',
                        type: 'section',
                        label: 'সর্বশেষ শিক্ষাগত যোগ্যতা',
                        fieldName: 'last_educational_qualification',
                        required: false,
                        options: []
                    },
                    {
                        id: 'element_' + Date.now() + '_29',
                        type: 'text',
                        label: 'শিক্ষা প্রতিষ্ঠানের নাম',
                        fieldName: 'last_educational_institute',
                        required: true,
                        options: []
                    },
                    {
                        id: 'element_' + Date.now() + '_30',
                        type: 'text',
                        label: 'শ্রেণি/বর্ষ',
                        fieldName: 'last_class_or_year',
                        required: true,
                        options: []
                    },
                    {
                        id: 'element_' + Date.now() + '_31',
                        type: 'text',
                        label: 'বোর্ড রোল / আইডি নং',
                        fieldName: 'last_board_roll_or_id',
                        required: true,
                        options: []
                    },
                    {
                        id: 'element_' + Date.now() + '_32',
                        type: 'text',
                        label: 'বিভাগ/বিষয়',
                        fieldName: 'last_department_or_subject',
                        required: true,
                        options: []
                    },
                    // Contact Information
                    {
                        id: 'element_' + Date.now() + '_33',
                        type: 'section',
                        label: 'যোগাযোগের তথ্য',
                        fieldName: 'contact_information',
                        required: false,
                        options: []
                    },
                    {
                        id: 'element_' + Date.now() + '_34',
                        type: 'text',
                        label: 'মোবাইল নম্বর (শিক্ষার্থীর)',
                        fieldName: 'student_mobile_number',
                        required: true,
                        options: []
                    },
                    {
                        id: 'element_' + Date.now() + '_35',
                        type: 'text',
                        label: 'মোবাইল নম্বর (অভিভাবকের)',
                        fieldName: 'guardian_mobile_number',
                        required: true,
                        options: []
                    },
                    {
                        id: 'element_' + Date.now() + '_36',
                        type: 'text',
                        label: 'ই-মেইল ঠিকানা',
                        fieldName: 'email_address',
                        required: false,
                        options: []
                    },
                    {
                        id: 'element_' + Date.now() + '_37',
                        type: 'text',
                        label: 'ফেসবুক আইডি (যদি থাকে)',
                        fieldName: 'facebook_id',
                        required: false,
                        options: []
                    }
                ];

                // Add to existing elements
                formElements = formElements.concat(templateElements);
                renderFormElements();
            }
        }

        // Function to clear all fields
        function clearFields() {
            // Create modal for confirmation
            const modalHtml = `
                <div class="modal fade" id="clearFieldsModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Confirm Clear Fields</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to clear all form fields? This action cannot be undone.</p>
                                <div class="alert alert-warning">
                                    <i class='bx bx-error-circle me-2'></i>This will remove all fields from the form builder.
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-danger" id="confirmClearBtn">Clear All Fields</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            // Add modal to body
            document.body.insertAdjacentHTML('beforeend', modalHtml);

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('clearFieldsModal'));
            modal.show();

            // Add event listener to confirm button
            document.getElementById('confirmClearBtn').addEventListener('click', function() {
                formElements = [];
                renderFormElements();
                showAlert('success', 'All form fields have been cleared successfully.');
                modal.hide();
                document.getElementById('clearFieldsModal').remove();
            });

            // Remove modal from DOM when hidden
            document.getElementById('clearFieldsModal').addEventListener('hidden.bs.modal', function() {
                this.remove();
            });
        }

        // Function to preview form
        function previewForm() {
            // Create modal for preview
            let previewHtml = `
                <div class="modal fade" id="previewFormModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">${document.getElementById('formName').value || 'Form Preview'}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p class="text-muted">${document.getElementById('formDescription').value || ''}</p>
                                <form>
            `;

            // Add form elements to preview
            formElements.forEach(element => {
                previewHtml += renderElementPreview(element);
            });

            previewHtml += `
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            // Add modal to body
            document.body.insertAdjacentHTML('beforeend', previewHtml);

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('previewFormModal'));
            modal.show();

            // Remove modal from DOM when hidden
            document.getElementById('previewFormModal').addEventListener('hidden.bs.modal', function() {
                this.remove();
            });
        }

        // Function to save form
        function saveForm() {
            const saveBtn = document.getElementById('saveFormBtn');
            const originalHtml = saveBtn.innerHTML;
            saveBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin me-1"></i>সংরক্ষণ হচ্ছে...';
            saveBtn.disabled = true;

            // Update form name and description
            const formName = document.getElementById('formName').value;
            const formDescription = document.getElementById('formDescription').value;

            // Get advanced settings
            const appIdPrefix = document.getElementById('appIdPrefix').value;
            const idStart = document.getElementById('idStart').value;
            const idEnd = document.getElementById('idEnd').value;
            const paymentOption = document.getElementById('paymentOption').checked;
            const paymentTypeLabel = document.getElementById('paymentTypeLabel').value;
            const paymentAmount = document.getElementById('paymentAmount').value;
            const formActiveDate = document.getElementById('formActiveDate').value;

            // Add advanced settings to form elements
            const formWithSettings = {
                elements: formElements,
                settings: {
                    appIdPrefix: appIdPrefix,
                    idRange: {
                        start: idStart,
                        end: idEnd
                    },
                    paymentRequired: paymentOption,
                    paymentTypeLabel: paymentTypeLabel,
                    paymentAmount: paymentAmount,
                    activeDate: formActiveDate
                }
            };

            // Send data to server
            fetch("{{ route('admin.forms.update-fields', $form) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    fields: formWithSettings,
                    name: formName,
                    description: formDescription
                })
            })
            .then(async response => {
                let data = null;
                try { data = await response.json(); } catch(e) {}
                if (!response.ok) {
                    throw new Error(data?.message || 'Server error');
                }
                if (data && data.success) {
                    showAlert('success', data.message || 'ফর্ম সংরক্ষণ সম্পন্ন');
                } else {
                    showAlert('danger', data?.message || 'ফর্ম সংরক্ষণ করতে সমস্যা হয়েছে।');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('danger', 'ফর্ম সংরক্ষণ করতে সমস্যা হয়েছে।');
            })
            .finally(() => {
                saveBtn.innerHTML = originalHtml;
                saveBtn.disabled = false;
            });
        }

        // Function to show alert
        function showAlert(type, message) {
            // Remove existing alerts
            document.querySelectorAll('.alert').forEach(alert => alert.remove());

            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-' + type + ' alert-dismissible fade show position-fixed';
            alertDiv.style = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            alertDiv.innerHTML = message + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';

            document.body.appendChild(alertDiv);

            // Auto dismiss after 3 seconds
            setTimeout(() => {
                alertDiv.remove();
            }, 3000);
        }

        // Load locations data and populate dropdowns
        function loadLocationsAndPopulateDropdowns() {
            fetch('/locations.json')
                .then(response => response.json())
                .then(data => {
                    window.locationsData = data;
                })
                .catch(error => {
                    console.error('Error loading locations data:', error);
                });
        }

        // Populate district dropdown based on selected division
        function populateDistricts(divisionName, districtSelect) {
            if (!window.locationsData) return;

            // Clear existing options
            districtSelect.innerHTML = '<option value="">জেলা নির্বাচন করুন</option>';

            const division = window.locationsData.divisions.find(div => div.name === divisionName);
            if (division) {
                division.districts.forEach(district => {
                    const option = document.createElement('option');
                    option.value = district.name;
                    option.textContent = district.name;
                    districtSelect.appendChild(option);
                });
            }
        }

        // Populate upazila dropdown based on selected district
        function populateUpazilas(divisionName, districtName, upazilaSelect) {
            if (!window.locationsData) return;

            // Clear existing options
            upazilaSelect.innerHTML = '<option value="">উপজেলা নির্বাচন করুন</option>';

            const division = window.locationsData.divisions.find(div => div.name === divisionName);
            if (division) {
                const district = division.districts.find(dist => dist.name === districtName);
                if (district) {
                    district.upazilas.forEach(upazila => {
                        const option = document.createElement('option');
                        option.value = upazila;
                        option.textContent = upazila;
                        upazilaSelect.appendChild(option);
                    });
                }
            }
        }

        // Initialize locations data when the page loads
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', loadLocationsAndPopulateDropdowns);
        } else {
            loadLocationsAndPopulateDropdowns();
        }

        // Create custom cursor for form builder
        function createCustomCursor() {
            // Check if cursor already exists
            if (document.getElementById('custom-cursor')) {
                return;
            }

            // Create cursor elements
            const cursor = document.createElement('div');
            cursor.id = 'custom-cursor';

            const cursorDot = document.createElement('div');
            cursorDot.className = 'cursor-dot';

            const cursorRing = document.createElement('div');
            cursorRing.className = 'cursor-ring';

            cursor.appendChild(cursorDot);
            cursor.appendChild(cursorRing);
            document.body.appendChild(cursor);

            // Update cursor position
            document.addEventListener('mousemove', (e) => {
                if (cursor) {
                    cursor.style.left = e.clientX + 'px';
                    cursor.style.top = e.clientY + 'px';
                }
            });

            // Add hover effects
            const interactiveElements = document.querySelectorAll('a, button, .btn, .sidebar-toggle, .theme-toggle, .slide-item, input, textarea, select, .draggable-element, .draggable-template');
            interactiveElements.forEach(el => {
                el.addEventListener('mouseenter', () => {
                    if (cursor) {
                        cursor.classList.add('cursor-hover');
                    }
                });

                el.addEventListener('mouseleave', () => {
                    if (cursor) {
                        cursor.classList.remove('cursor-hover');
                    }
                });
            });

            // Add grab effects
            const draggableElements = document.querySelectorAll('.draggable-element, .draggable-template');
            draggableElements.forEach(el => {
                el.addEventListener('mousedown', () => {
                    if (cursor) {
                        cursor.classList.add('cursor-grabbing');
                    }
                });

                el.addEventListener('mouseup', () => {
                    if (cursor) {
                        cursor.classList.remove('cursor-grabbing');
                    }
                });
            });

            // Update cursor for dark mode
            function updateCursorForTheme() {
                const isDarkMode = document.documentElement.classList.contains('dark-mode');
                if (cursorDot && cursorRing) {
                    if (isDarkMode) {
                        cursorDot.classList.add('dark-mode');
                        cursorRing.classList.add('dark-mode');
                    } else {
                        cursorDot.classList.remove('dark-mode');
                        cursorRing.classList.remove('dark-mode');
                    }
                }
            }

            // Check for theme changes
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                        updateCursorForTheme();
                    }
                });
            });

            observer.observe(document.documentElement, {
                attributes: true // configure it to listen to attribute changes
            });

            // Initialize cursor theme
            updateCursorForTheme();

            // Make cursor visible initially
            cursor.style.opacity = '1';
        }

        // Create cursor when DOM is loaded
        document.addEventListener('DOMContentLoaded', createCustomCursor);

        // Recreate cursor if it gets removed for any reason
        document.addEventListener('mousemove', function() {
            if (!document.getElementById('custom-cursor')) {
                setTimeout(createCustomCursor, 100);
            }
        });

        // ================= Keyboard Shortcuts =================
        function getSelectedIndex() {
            if(!selectedElementId) return -1;
            return formElements.findIndex(e => e.id === selectedElementId);
        }

        function duplicateSelected() {
            const idx = getSelectedIndex();
            if(idx < 0) return;
            const original = formElements[idx];
            const clone = JSON.parse(JSON.stringify(original));
            clone.id = 'element_' + Date.now() + '_' + Math.floor(Math.random()*1000);
            clone.label = original.label + ' (Copy)';
            formElements.splice(idx+1, 0, clone);
            selectElement(clone.id, true);
        }

        function toggleRequiredSelected() {
            const idx = getSelectedIndex();
            if(idx < 0) return;
            formElements[idx].required = !formElements[idx].required;
            renderFormElements();
        }

        function openEditSelected() {
            const idx = getSelectedIndex();
            if(idx < 0) return;
            editElement(formElements[idx]);
        }

        function moveSelected(delta) {
            const idx = getSelectedIndex();
            if(idx < 0) return;
            const newIndex = idx + delta;
            if(newIndex < 0 || newIndex >= formElements.length) return;
            const tmp = formElements[idx];
            formElements.splice(idx,1);
            formElements.splice(newIndex,0,tmp);
            renderFormElements();
            selectElement(tmp.id, true);
        }

        function deleteSelected() {
            const idx = getSelectedIndex();
            if(idx < 0) return;
            const delId = formElements[idx].id;
            formElements.splice(idx,1);
            selectedElementId = null;
            renderFormElements();
            showAlert('success','Element deleted');
        }

        // Help overlay
        let helpVisible = false;
        function toggleHelpOverlay() {
            const existing = document.getElementById('kbShortcutsOverlay');
            if(existing) { existing.remove(); helpVisible = false; return; }
            const div = document.createElement('div');
            div.id = 'kbShortcutsOverlay';
            div.style = 'position:fixed;top:60px;right:20px;z-index:2000;max-width:360px;background:#0f172a;color:#f1f5f9;padding:16px;border-radius:8px;box-shadow:0 4px 24px rgba(0,0,0,.3);font-size:13px;line-height:1.4;';
            div.innerHTML = `
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <strong style="font-size:14px;">Keyboard Shortcuts</strong>
                    <button type="button" class="btn-close btn-close-white" style="filter:invert(1);" aria-label="Close"></button>
                </div>
                <ul class="list-unstyled mb-2">
                    <li><code>Ctrl+S</code> Save form</li>
                    <li><code>Ctrl+P</code> Preview form</li>
                    <li><code>Ctrl+Shift+T</code> Apply admission template</li>
                    <li><code>Alt+↑ / Alt+↓</code> Move selected field</li>
                    <li><code>Ctrl+D</code> Duplicate selected field</li>
                    <li><code>Ctrl+R</code> Toggle required</li>
                    <li><code>Del / Backspace</code> Delete selected</li>
                    <li><code>Enter</code> Edit selected</li>
                    <li><code>?</code> Toggle this help</li>
                </ul>
                <p class="mb-0 text-secondary" style="font-size:11px;opacity:.8;">Select a field first by clicking it. Close with ESC or ?</p>
            `;
            div.querySelector('.btn-close').addEventListener('click', ()=>div.remove());
            document.body.appendChild(div);
            helpVisible = true;
        }

        document.addEventListener('keydown', function(e){
            const isCtrl = e.ctrlKey || e.metaKey;
            // Ignore when in input/textarea unless we explicitly allow
            const tag = (e.target && e.target.tagName) ? e.target.tagName.toLowerCase() : '';
            const editingText = ['input','textarea'].includes(tag) && e.target.getAttribute('type') !== 'checkbox';

            // Global help toggle with Shift+/? or plain '?'
            if(e.key === '?' || (e.shiftKey && e.key === '/')) {
                e.preventDefault();
                toggleHelpOverlay();
                return;
            }
            if(e.key === 'Escape' && helpVisible) {
                toggleHelpOverlay();
                return;
            }

            // Save (Ctrl+S)
            if(isCtrl && e.key.toLowerCase() === 's') {
                e.preventDefault();
                saveForm();
                return;
            }
            // Preview (Ctrl+P)
            if(isCtrl && e.key.toLowerCase() === 'p') {
                e.preventDefault();
                previewForm();
                return;
            }
            // Apply template (Ctrl+Shift+T)
            if(isCtrl && e.shiftKey && e.key.toLowerCase() === 't') {
                e.preventDefault();
                applyAdmissionTemplate();
                return;
            }

            // Actions requiring a selected element
            if(selectedElementId) {
                // Duplicate (Ctrl+D)
                if(isCtrl && e.key.toLowerCase() === 'd') {
                    e.preventDefault();
                    duplicateSelected();
                    return;
                }
                // Toggle required (Ctrl+R)
                if(isCtrl && e.key.toLowerCase() === 'r') {
                    e.preventDefault();
                    toggleRequiredSelected();
                    return;
                }
                // Edit (Enter) when not typing inside an input used for renaming
                if(e.key === 'Enter' && !editingText) {
                    e.preventDefault();
                    openEditSelected();
                    return;
                }
                // Delete (Delete / Backspace)
                if((e.key === 'Delete' || e.key === 'Backspace') && !editingText) {
                    e.preventDefault();
                    deleteSelected();
                    return;
                }
                // Move Up (Alt+ArrowUp)
                if(e.altKey && e.key === 'ArrowUp') {
                    e.preventDefault();
                    moveSelected(-1);
                    return;
                }
                // Move Down (Alt+ArrowDown)
                if(e.altKey && e.key === 'ArrowDown') {
                    e.preventDefault();
                    moveSelected(1);
                    return;
                }
            }
        });
        // ======================================================
    });

</script>
@endsection
