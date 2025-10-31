<?php

namespace App\Services\Execution;

use App\Models\ComponentScan;
use App\Models\Component;
use App\Services\Trace\QrParserService;

class ScanService
{
    protected QrParserService $parser;

    public function __construct(QrParserService $parser)
    {
        $this->parser = $parser;
    }

    public function recordScan(array $data): ComponentScan
    {
        $partNumber = $this->parser->extractPartNumber($data['scanned_raw']);
        $component = $partNumber ? Component::where('part_number', $partNumber)->first() : null;

        $data['part_number_detected'] = $partNumber ?? 'UNKNOWN';
        $data['component_id'] = $component?->id;
        $data['is_valid'] = !is_null($component);

        return ComponentScan::create($data);
    }
}
