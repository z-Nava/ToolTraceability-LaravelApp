<?php

namespace App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use App\Models\StationSession;
use App\Models\ComponentScan;
use App\Models\Component;
use App\Models\DummyTag;
use App\Services\Trace\ScanValidatorService;
use Illuminate\Http\Request;

class DummyTagController extends Controller
{
    protected ScanValidatorService $validator;

    public function __construct(ScanValidatorService $validator)
    {
        $this->validator = $validator;
    }

    public function scan(StationSession $stationSession)
    {
        $dummy = DummyTag::where('production_run_id', $stationSession->production_run_id)
            ->latest()
            ->first();

        $recentScans = ComponentScan::where('production_run_id', $stationSession->production_run_id)
            ->where('station_id', $stationSession->station_id)
            ->orderByDesc('id')
            ->take(10)
            ->get();

        return view('production.stations.scan', compact('stationSession', 'dummy', 'recentScans'));
    }

    public function process(Request $request, StationSession $stationSession)
    {
        $qr = $request->validate(['qr_input' => 'required|string'])['qr_input'];
        $fgModelId = $stationSession->productionRun->fg_model_id;
        $stationId = $stationSession->station_id;
        $userId = auth()->id();

        // 1️⃣ Detección de Dummy QR
        if (str_starts_with($qr, '^DM^')) {
            DummyTag::create([
                'production_run_id' => $stationSession->production_run_id,
                'dummy_code' => $qr,
                'current_station_id' => $stationId,
                'opened_at' => now(),
            ]);

            return back()->with('success', '✅ Dummy QR registrado correctamente.');
        }

        // 2️⃣ Detección de Componente
        $component = Component::where('part_number', 'like', '%' . preg_replace('/[^0-9]/', '', $qr) . '%')->first();
        $validation = $this->validator->validateComponent($fgModelId, $stationId, $component, $qr);

        ComponentScan::create([
            'production_run_id' => $stationSession->production_run_id,
            'station_id' => $stationId,
            'dummy_tag_id' => null,
            'scanned_raw' => $qr,
            'part_number_detected' => $component?->part_number ?? 'DESCONOCIDO',
            'component_id' => $component?->id,
            'component_type_id' => $component?->component_type_id,
            'is_valid' => $validation['is_valid'],
            'validation_error' => $validation['error'],
            'scanned_by' => $userId,
            'scanned_at' => now(),
        ]);

        if ($validation['is_valid']) {
            return back()->with('success', '✅ Escaneo válido: componente aceptado.');
        }

        return back()->with('error', '❌ ' . $validation['error']);
    }
}
