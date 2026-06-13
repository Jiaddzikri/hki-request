<?php
$proposal = \App\Models\HKIProposal::first();
$originalTitle = $proposal->title;
\DB::table('hki_proposals')->where('id', $proposal->id)->update(['title' => 'TAMPERED TITLE']);

$logs = \App\Models\HKIAuditLog::where('model_id', $proposal->id)->orderBy('id', 'asc')->get();
$latestStates = [];
foreach ($logs as $log) {
    $latestStates[$log->model_type][$log->model_id] = [
        'payload' => $log->payload,
        'log_id' => $log->id,
        'action' => $log->action,
    ];
}

foreach ($latestStates as $modelClass => $models) {
    echo "Class: $modelClass\n";
    foreach ($models as $id => $stateData) {
        echo "ID: $id\n";
        $model = $modelClass::find($id);
        if ($model) {
            $payload = $stateData['payload'] ?? [];
            foreach ($payload as $key => $value) {
                $hasAttr = array_key_exists($key, $model->getAttributes());
                $modelVal = (string) $model->{$key};
                $payloadVal = (string) $value;
                echo "Key: $key | HasAttr: " . ($hasAttr ? '1' : '0') . " | Model: $modelVal | Payload: $payloadVal\n";
                if ($hasAttr && $modelVal !== $payloadVal) {
                    echo "=> MISMATCH DETECTED!\n";
                }
            }
        }
    }
}
\DB::table('hki_proposals')->where('id', $proposal->id)->update(['title' => $originalTitle]);
