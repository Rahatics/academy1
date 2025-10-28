@extends('layouts.app')

@section('title', 'আবেদনের পেমেন্ট')

@section('content')

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            
            {{-- আবেদনকারীর তথ্য (Request 1) --}}
            
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">আবেদনকারীর তথ্য</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">আবেদনকারীর নাম:</span>
                            <strong class="text-end">
                                @if(!empty($application->name))
                                    {{ $application->name }}
                                @else
                                    নাম পাওয়া যায়নি
                                @endif
                            </strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">ইনভয়েস নম্বর:</span>
                            <strong class="text-end">
                                @if($application->internal_invoice)
                                    {{ $application->internal_invoice }}
                                @else
                                    {{-- Generate default invoice number based on project specification --}}
                                    @php
                                        $year = date('Y');
                                        $appId = $application->id ?? '000';
                                        echo "INV-{$year}-{$appId}";
                                    @endphp
                                @endif
                            </strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">আবেদন আইডি:</span>
                            <strong class="text-end text-muted small">
                                @if($application->application_id)
                                    {{ $application->application_id }}
                                @else
                                    #{{ $application->id }}
                                @endif
                            </strong>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- পেমেন্ট কার্ড --}}
            
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">পেমেন্ট বিবরণ</h5>
                </div>
                <div class="card-body">
                    
                    {{-- ফি-এর বিবরণ (Request 2) --}}
                    
                    <h5 class="mb-3">ফি-এর বিবরণ</h5>
                    @php $total = $application->total_fee; @endphp
                    
                    @if(isset($breakdown) && count($breakdown) > 0)
                        <ul class="list-group mb-4">
                            {{-- Show the form's base fee first if it exists and is greater than 0 --}}
                            @if($application->form && method_exists($application->form, 'getPaymentAmount'))
                                @php
                                    $baseFee = $application->form->getPaymentAmount();
                                    $baseFeeLabel = $application->form->getPaymentLabel();
                                @endphp
                                @if($baseFee && $baseFee > 0)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span><strong>{{ $baseFeeLabel ?? 'আবেদন ফি' }}</strong></span>
                                        <span>{{ number_format($baseFee, 2) }} ৳</span>
                                    </li>
                                @endif
                            @endif
                            
                            {{-- Show subject fees --}}
                            @foreach($breakdown as $code => $item)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><strong>{{ $item['name'] }}</strong> <span class="text-muted">({{ $code }})</span></span>
                                    <span>{{ number_format($item['fee'],2) }} ৳</span>
                                </li>
                            @endforeach
                            <li class="list-group-item d-flex justify-content-between align-items-center bg-light-subtle">
                                <strong>মোট</strong>
                                <strong class="text-primary h5 mb-0">
                                    @php
                                        $totalAmount = 0;
                                        // Add base fee if it exists
                                        if($application->form && method_exists($application->form, 'getPaymentAmount')) {
                                            $baseFee = $application->form->getPaymentAmount();
                                            if($baseFee && $baseFee > 0) {
                                                $totalAmount += $baseFee;
                                            }
                                        }
                                        // Add breakdown fees
                                        foreach($breakdown as $item) {
                                            $totalAmount += $item['fee'];
                                        }
                                        echo number_format($totalAmount, 2);
                                    @endphp
                                     ৳
                                </strong>
                            </li>
                        </ul>
                    @else
                        <ul class="list-group mb-4">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><strong>
                                    @if(isset($application) && $application->form)
                                        @if(method_exists($application->form, 'getPaymentLabel'))
                                            {{ $application->form->getPaymentLabel() }}
                                        @else
                                            আবেদন ফি
                                        @endif
                                    @else
                                        আবেদন ফি
                                    @endif
                                </strong></span>
                                <strong class="text-primary h5 mb-0">{{ number_format($total,2) }} ৳</strong>
                            </li>
                        </ul>
                    @endif

                    {{-- পেমেন্ট মাধ্যম (Request 3) এবং Easypay Bug Fix --}}
                    
                    <h5 class="mb-3">পেমেন্ট মাধ্যম নির্বাচন করুন</h5>
                    @php $gateways = app(\App\Services\PaymentGatewayRegistry::class)->enabled(); @endphp
                    
                    @php
                        // Easypay Bug Fix: ডিফল্ট অ্যাকশন সেট করা
                        $defaultAction = '';
                        if (count($gateways)) {
                            if ($gateways[0] == 'easypay') {
                                $defaultAction = route('easypay.initiate');
                            } else {
                                $defaultAction = route('forms.payment.pay_now', $application);
                            }
                        }
                    @endphp

                    <form method="POST" action="{{ $defaultAction }}" id="payNowForm">
                        @csrf
                        <div class="mb-3">
                            @if(count($gateways))
                                <div class="row g-2">
                                    @foreach($gateways as $gw)
                                        @php
                                            // Easypay Bug Fix: প্রতিটি গেটওয়ের জন্য সঠিক রুট সেট করা
                                            $actionUrl = ($gw == 'easypay')
                                                        ? route('easypay.initiate')
                                                        : route('forms.payment.pay_now', $application);
                                        @endphp
                                        <div class="col-6 col-md-4">
                                            <div class="gateway-option border rounded p-2 h-100 position-relative">
                                                <label class="w-100 m-0" style="cursor:pointer;">
                                                    <input class="form-check-input me-2 gateway-radio" 
                                                           type="radio" 
                                                           name="gateway" 
                                                           value="{{ $gw }}" 
                                                           data-action="{{ $actionUrl }}" 
                                                           @checked($loop->first)>
                                                    <span class="align-middle">
                                                        @switch($gw)
                                                            @case('easypay')<strong>Easypay</strong>@break
                                                            @case('dummy')<strong>ডেমো</strong>@break
                                                            @default <strong>{{ ucfirst($gw) }}</strong>
                                                        @endswitch
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-warning py-2 mb-0">কোনো সক্রিয় পেমেন্ট গেটওয়ে পাওয়া যায়নি।</div>
                            @endif
                        </div>
                        
                        {{-- বাটন সেকশন (Nested Form Fix) --}}
                        <div class="d-flex flex-column flex-md-row gap-2 mt-4">
                            {{-- "Pay Now" বাটন এই ফর্মের অংশ --}}
                            <button class="btn btn-success flex-fill" type="submit" @disabled(!count($gateways))>
                                <i class='bx bx-credit-card-alt me-1'></i> এখনই পরিশোধ করুন
                            </button>
                        </div>
                    </form> {{-- Pay Now Form এখানে শেষ --}}
                </div>
            </div>
            
            <div class="text-center mt-3">
                <a href="{{ route('application') }}" class="small text-decoration-none">ফিরে যান</a>
            </div>
        </div>
    </div>
</div>

<style>
    .gateway-option { transition: background-color .15s, border-color .15s; }
    .gateway-option:hover { background: rgba(0,0,0,0.03); }
    :root.dark-mode .gateway-option { background:#1e293b; border-color:#334155; }
    :root.dark-mode .gateway-option:hover { background:#243552; }
</style>

<script>
    // পেমেন্ট গেটওয়ে সিলেকশন
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('payNowForm');
        const radios = document.querySelectorAll('.gateway-radio');
        
        radios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.checked) {
                    form.action = this.getAttribute('data-action');
                }
            });
        });
    });
</script>
@endsection