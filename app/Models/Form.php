<?php

// File: app/Models/Form.php



namespace App\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;



class Form extends Model

{

    use HasFactory;



    protected $fillable = [

        'name',

        'description',

        'fields', // 'fields' fillable ache kina nishchit korun

        'template',

        'status',

        'created_by'

    ];



    protected $casts = [

        'fields' => 'array' // 'fields' array hishebe cast kora ache kina nishchit korun

    ];



    // --- Nishchit korun ei function gulo thikmoto ache ---



    /**

     * Ei form-er jonno payment proyojon kina check kore

     */

    public function isPaymentRequired(): bool

    {

        // Apnar file-e jodi 'fields' er structure onno hoy (jemon direct 'settings' na theke onno kichu), tahole path ta thik kore nin

        return isset($this->fields['settings']['paymentRequired']) &&

               $this->fields['settings']['paymentRequired'] === true;

    }



    /**

     * Ei form-er jonno nirdharito payment amount koto ta ber kore

     */

    public function getPaymentAmount(): ?float

    {

        if ($this->isPaymentRequired() && isset($this->fields['settings']['paymentAmount'])) {

            // Nishchit korun jeno shongkha hishebe return kore

            $amount = $this->fields['settings']['paymentAmount'];

            return is_numeric($amount) ? (float) $amount : null;

        }

        return null;

    }



    /**

     * Ei form-er jonno nirdharito payment label (Fee Name) ber kore

     * @return string

     */

    public function getPaymentLabel(): string

    {

        // Jodi settings e paymentTypeLabel save kora thake, sheta return korbe, nahole default 'Application Fee' dekhabe

        // Nishchit korun Form Builder theke paymentTypeLabel name ei save hocche

        return $this->fields['settings']['paymentTypeLabel'] ?? 'Application Fee';

    }



    // --- Baki model code ---

    public function admin()

    {

        return $this->belongsTo(Admin::class, 'created_by');

    }



    public function applications()

    {

        return $this->hasMany(Application::class);

    }

}