<?php

namespace App\Http\Controllers;

use App\Events\PackageSent;
use Illuminate\Http\Request;

class NurseController extends Controller
{
    public function infus($ruang, $bed)
    {
        event(new PackageSent('infus', $ruang, $bed)); // Tanpa Queue, langsung jalankan
        // PackageSent::dispatch('infus', $ruang, $bed);
    }

    public function perawat($ruang, $bed)
    {
        event(new PackageSent('perawat', $ruang, $bed)); // Tanpa Queue, langsung jalankan
        // PackageSent::dispatch('perawat', $ruang, $bed);
    }

    public function emergency($ruang)
    {
        event(new PackageSent('emergency', $ruang, 0)); // Tanpa Queue, langsung jalankan
        // PackageSent::dispatch('emergency', $ruang, 0);
    }

    public function cancel($ruang)
    {
        event(new PackageSent('cancel', $ruang, 0)); // Tanpa Queue, langsung jalankan
        // PackageSent::dispatch('cancel', $ruang, 0);
    }


}
