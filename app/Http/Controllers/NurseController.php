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

        return response()->json(['status' => 'ok']);

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

        return response()->json(['status' => 'ok']);
    }

    public function emergency($ruang)
    {
        tx_rx::create([
            "ruang" => $ruang,
            "bed" => 0,
            "pesan" => "emergency"
        ]);
        PackageSent::dispatch('emergency', $ruang, 0);

        return response()->json(['status' => 'ok']);
    }

    public function cancel($ruang)
    {
        tx_rx::create([
            "ruang" => $ruang,
            "bed" => 0,
            "pesan" => "cancel"
        ]);
        PackageSent::dispatch('cancel', $ruang, 0);

        return response()->json(['status' => 'ok']);
    }

    public function counting()
    {

        $count = tx_rx::select('id')->count();

        $infusD = tx_rx::select('pesan')->where('pesan', 'infus')->whereDate('created_at', now()->toDateString())->count();

        $perawatD = tx_rx::select('pesan')->where('pesan', 'perawat')->whereDate('created_at', now()->toDateString())->count();

        $cancelD = tx_rx::select('pesan')->where('pesan', 'cancel')->whereDate('created_at', now()->toDateString())->count();

        $emergencyD = tx_rx::select('pesan')->where('pesan', 'emergency')->whereDate('created_at', now()->toDateString())->count();

        return response()->json([
            "countAll" => $count,
            "infusD" => $infusD,
            "perawatD" => $perawatD,
            "cancel" => $cancelD,
            "emergencyD" => $emergencyD,
        ]);

    }

}
