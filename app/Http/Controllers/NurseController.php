<?php

namespace App\Http\Controllers;

use App\Events\PackageSent;
use App\Models\tx_rx;
use Illuminate\Http\Request;

class NurseController extends Controller
{
    public function infus($ruang, $bed)
    {
        // event(new PackageSent('infus', $ruang, $bed)); // Tanpa Queue, langsung jalankan
        tx_rx::create([
            "kamar" => 1,
            "bed" => 1,
            "pesan" => "infus"
        ]);

        PackageSent::dispatch('infus', $ruang, $bed);

    }

    public function perawat($ruang, $bed)
    {
        // event(new PackageSent('infus', $ruang, $bed)); // Tanpa Queue, langsung jalankan
        PackageSent::dispatch('perawat', $ruang, $bed);
    }

    public function emergency($ruang)
    {
        PackageSent::dispatch('emergency', $ruang, 0);
    }

    public function cancel($ruang)
    {
        PackageSent::dispatch('cancel', $ruang, 0);
    }


}
