<?php

namespace App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use App\Models\StationSession;
use App\Models\ComponentScan;
use App\Models\DummyTag;
use App\Models\Component;
use Illuminate\Http\Request;

class DummyTagController extends Controller
{
    public function scan(StationSession $stationSession)
    {
        $dummy = DummyTag::where('production_run_id', $stationSession->production_run_id)
            ->where('status', 'IN_PROGRESS')
            ->latest()
            ->first();

        return view('production.stations.scan', compact('stationSession', 'dummy'));
    }

    public function process(Request $request, StationSession $stationSession)
    {
        $data = $request->validate([
            'qr_input' => 'required|string',
        ]);

        $qr = $data['qr_input'];

        // Si es un DUMMY
        if (str_starts_with($qr, '^DM^')) {
            $dummy = DummyTag::create([
                'production_run_id' => $stationSession->production_run_id,
                'dummy_code' => $qr,
                'current_station_id' => $stationSession->station_id,
                'opened_at' => now(),
            ]);

            return back()->with('success', 'Dummy QR registrado correctamente.');
        }

        // Si es un componente
        $component = Component::where('part_number', 'like', '%' . substr($qr, -9) . '%')->first();

        ComponentScan::create([
            'production_run_id' => $stationSession->production_run_id,
            'station_id' => $stationSession->station_id,
            'dummy_tag_id' => $stationSession->dummy_tag_id ?? null,
            'scanned_raw' => $qr,
            'part_number_detected' => $component?->part_number ?? 'DESCONOCIDO',
            'component_id' => $component?->id,
            'component_type_id' => $component?->component_type_id,
            'is_valid' => $component ? true : false,
            'validation_error' => $component ? null : 'Componente no encontrado',
            'scanned_by' => auth()->id(),
            'scanned_at' => now(),
        ]);

        return back()->with('success', 'Escaneo registrado.');
    }
}
