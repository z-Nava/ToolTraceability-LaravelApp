<?php

namespace App\Services\Trace;

use App\Models\ParsingRule;

class QrParserService
{
    /**
     * Extrae el número de parte a partir del QR usando las reglas activas.
     */
    public function extractPartNumber(string $raw): ?string
    {
        $rules = ParsingRule::where('is_active', true)->get();

        foreach ($rules as $rule) {
            if (preg_match($rule->regex_pattern, $raw, $matches)) {
                return $matches[$rule->part_number_group] ?? null;
            }
        }

        return null;
    }

    /**
     * Valida si un QR es un Dummy.
     */
    public function isDummyCode(string $raw): bool
    {
        return str_starts_with($raw, '^DM^');
    }
}
