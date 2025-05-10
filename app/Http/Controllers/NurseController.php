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
            "ruang" => $ruang,
            "bed" => $bed,
            "pesan" => "infus"
        ]);

        PackageSent::dispatch('infus', $ruang, $bed);

    }

    public function perawat($ruang, $bed)
    {
        // event(new PackageSent('infus', $ruang, $bed)); // Tanpa Queue, langsung jalankan
        tx_rx::create([
            "ruang" => $ruang,
            "bed" => $bed,
            "pesan" => "perawat"
        ]);
        PackageSent::dispatch('perawat', $ruang, $bed);
    }

    public function emergency($ruang)
    {
        tx_rx::create([
            "ruang" => $ruang,
            "bed" => 0,
            "pesan" => "emergency"
        ]);
        PackageSent::dispatch('emergency', $ruang, 0);
    }

    public function cancel($ruang)
    {
        tx_rx::create([
            "ruang" => $ruang,
            "bed" => 0,
            "pesan" => "cancel"
        ]);
        PackageSent::dispatch('cancel', $ruang, 0);
    }


}
