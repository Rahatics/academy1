<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use Illuminate\Support\Facades\Session;

abstract class BasePaymentController extends Controller
{
    protected function validatePaymentSession(Application $application)
    {
        if (Session::get('recent_application_id') !== $application->id) {
            abort(403);
        }
        
        if ($this->paymentExpired($application)) {
            $this->markExpired($application);
            return false;
        }
        
        return true;
    }
    
    protected function paymentExpired(Application $application): bool
    {
        return $application->payment_status !== 'paid'
            && $application->payment_due_at
            && $application->payment_due_at->isPast();
    }
    
    protected function markExpired(Application $application): void
    {
        if($this->paymentExpired($application) && $application->payment_status !== 'expired_unpaid') {
            $application->payment_status = 'expired_unpaid';
            $application->save();
        }
    }
}
