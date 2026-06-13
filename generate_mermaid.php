<?php
$tables = json_decode(file_get_contents('tables.json'), true);
$mermaid = "erDiagram\n";
foreach ($tables as $t) {
    if (in_array($t['table'], ['migrations', 'failed_jobs', 'cache', 'cache_locks', 'jobs', 'job_batches', 'sessions', 'password_reset_tokens', 'personal_access_tokens'])) {
        continue;
    }
    $mermaid .= "    " . $t['table'] . " {\n";
    foreach ($t['columns'] as $c) {
        $type = preg_replace('/[^a-zA-Z0-9_]/', '', $c['type']); // remove spaces etc for mermaid
        $mermaid .= "        " . $type . " " . $c['name'] . "\n";
    }
    $mermaid .= "    }\n";
}
foreach ($tables as $t) {
    if (in_array($t['table'], ['migrations', 'failed_jobs', 'cache', 'cache_locks', 'jobs', 'job_batches', 'sessions', 'password_reset_tokens', 'personal_access_tokens'])) {
        continue;
    }
    foreach ($t['foreign_keys'] as $fk) {
        $mermaid .= "    " . $fk['foreign_table'] . " ||--o{ " . $t['table'] . " : \"" . implode(',', $fk['columns']) . "\"\n";
    }
}
file_put_contents('erd.mermaid', $mermaid);
