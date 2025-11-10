<?php
require_once plugin_dir_path(__DIR__) . 'vendor/autoload.php';

function sync_product_get_options()
{
    return wp_parse_args(get_option('sync_options', []), [
        'sheet_id' => '12g2uTeb3Kd5MohejwvhvHHeCRenOJ0pS0ljzmG-g8kQ',
        'range' => 'Trang tính1!A1:G1000',
        'auto_sync' => 1
    ]);
}

function sync_read_sheet($sheet_id = '12g2uTeb3Kd5MohejwvhvHHeCRenOJ0pS0ljzmG-g8kQ', $range = 'Trang tính1!A1:G')
{
    $credentials = plugin_dir_path(__DIR__) . 'config/credentials.json';
    if (!file_exists($credentials)) {
        error_log(' Không tìm thấy file credentials.json tại: ' . $credentials);
        return [];
    }

    $client = new Google\Client();
    $client->setApplicationName('Google Sheets Sync');
    $client->setScopes([Google\Service\Sheets::SPREADSHEETS_READONLY]);
    $client->setAuthConfig($credentials);
    $client->setAccessType('offline');

    $service = new Google\Service\Sheets($client);

    try {
        $response = $service->spreadsheets_values->get($sheet_id, $range);
    } catch (Exception $e) {
        error_log(' Lỗi khi đọc Google Sheet: ' . $e->getMessage());
        return [];
    }

    $values = $response->getValues();
    if (!$values || count($values) < 2) return [];

    $headers = array_map(fn($v) => strtolower(trim($v)), $values[0]);
    $out = [];

    foreach (array_slice($values, 1) as $row) {
        $assoc = [];
        foreach ($headers as $i => $key) {
            $assoc[$key] = isset($row[$i]) ? trim($row[$i]) : null;
        }
        $out[] = $assoc;
    }

    return $out;
}


function sync_validate_row($row)
{
    $row = array_change_key_case($row, CASE_LOWER);

    $errors = [];
    error_log(' $row: ' . print_r($row, true));

    if (empty($row['external_id'])) $errors[] = 'external_id rỗng';
    if (empty($row['name'])) $errors[] = 'name rỗng';
    if (!isset($row['price']) || !is_numeric($row['price'])) {
        $errors[] = 'price không hợp lệ';
    }


    return $errors;
}


function sync_row_hash($row)
{
    $fields = ['external_id', 'name', 'description', 'content', 'category', 'price', 'updated_at'];
    $concat = '';
    foreach ($fields as $f) $concat .= '|' . (string)($row[$f] ?? '');
    return hash('sha256', $concat);
}

function sync_products()
{
    global $wpdb;
    $opts = sync_product_get_options();
    if (empty($opts['sheet_id'])) return ['error' => 'Chưa cấu hình Sheet ID'];
    $rows = sync_read_sheet();
    $table = $wpdb->prefix . 'syn_products';

    $inserted = 0;
    $updated = 0;
    $skipped = 0;
    $failed = 0;
    $errs = [];

    foreach ($rows as $idx => $row) {
        $errors = sync_validate_row($row);
        if ($errors) {
            $failed++;
            $errs[$idx + 2] = $errors;
            continue;
        }
        $hash = sync_row_hash($row);

        $exists = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE external_id=%s", $row['external_id']), ARRAY_A);

        $row_db = [
            'external_id' => $row['external_id'],
            'name'        => $row['name'],
            'description' => $row['description'] ?? '',
            'content'     => $row['content'] ?? '',
            'category'    => $row['category'] ?? '',
            'price'       => (float)$row['price'],
            'updated_at'  => date('Y-m-d H:i:s', strtotime($row['updated_at'])),
            'data_hash'   => $hash
        ];

        if (!$exists) {
            $ok = $wpdb->insert($table, $row_db);
            $ok ? $inserted++ : $failed++;
        } else {
            if (($exists['data_hash'] ?? '') === $hash) {
                $skipped++;
            } else {
                $ok = $wpdb->update($table, $row_db, ['external_id' => $row['external_id']]);
                $ok ? $updated++ : $failed++;
            }
        }
    }
    return compact('inserted', 'updated', 'skipped', 'failed', 'errs');
}
