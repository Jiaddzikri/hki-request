<?php

return [
    'features' => [
        // Toggle ini dapat dimatikan untuk keperluan testing performa di local/staging.
        // PERINGATAN: Di production, toggle ini akan diabaikan dan selalu dipaksa aktif oleh sistem.
        'immutable_logging' => env('HKI_ENABLE_IMMUTABLE_LOG', true),
    ]
];
