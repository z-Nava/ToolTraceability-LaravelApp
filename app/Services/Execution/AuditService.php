<?php

namespace App\Services\Execution;

use App\Models\AuditLog;

class AuditService
{
    public function log(?int $userId, string $action, string $entityType, int $entityId, array $data = []): AuditLog
    {
        return AuditLog::create([
            'user_id' => $userId,
            'action' => $action,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'data' => $data,
        ]);
    }
}
