<?php
require_once plugin_dir_path(__DIR__) . 'vendor/autoload.php';

function sync_product_get_options()
{
    return wp_parse_args(get_option('sync_options', []), [
        'sheet_id' => '12g2uTeb3Kd5MohejwvhvHHeCRenOJ0pS0ljzmG-g8kQ',
        'range' => 'Trang tính1!A1:G1000',
        'auto_sync' => 1,
        'auto_sync_db_to_sheet' => 0
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

function get_tabs_sheet($spreadsheet_id = '12g2uTeb3Kd5MohejwvhvHHeCRenOJ0pS0ljzmG-g8kQ')
{
    if (!$spreadsheet_id) {
        $opts = sync_product_get_options();
        $spreadsheet_id = $opts['sheet_id'];
    }

    $credentials = plugin_dir_path(__DIR__) . 'config/credentials.json';
    if (!file_exists($credentials)) {
        error_log(' Không tìm thấy credentials.json');
        return [];
    }

    $client = new Google\Client();
    $client->setApplicationName('Google Sheets Sync');
    $client->setScopes([Google\Service\Sheets::SPREADSHEETS_READONLY]);
    $client->setAuthConfig($credentials);
    $client->setAccessType('offline');

    $service = new Google\Service\Sheets($client);

    try {
        $spreadsheet = $service->spreadsheets->get($spreadsheet_id);
    } catch (Exception $e) {
        error_log(' Lỗi khi đọc spreadsheet: ' . $e->getMessage());
        return [];
    }

    $tabs = [];
    foreach ($spreadsheet->getSheets() as $sheet) {
        $tabs[] = $sheet->getProperties()->getTitle();
    }

    return $tabs;
}

function sync_extract_tab_from_range($range)
{
    if (empty($range)) {
        return '';
    }

    if (false === strpos($range, '!')) {
        return trim($range);
    }

    [$tab] = explode('!', $range, 2);

    return trim($tab);
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
    foreach ($fields as $f) {
        $val = isset($row[$f]) ? strtolower(trim((string)$row[$f])) : '';
        $concat .= '|' . $val;
    }
    return hash('sha256', $concat);
}

function sync_products()
{
    global $wpdb;
    $opts = sync_product_get_options();
    if (empty($opts['sheet_id']))
        return ['error' => 'Chưa cấu hình Sheet ID'];

    $selected_tab = isset($_POST['tabs-sheet']) ? sanitize_text_field($_POST['tabs-sheet']) : '';

    $range = $selected_tab
        ? ($selected_tab . '!A1:G1000')
        : $opts['range'];

    $rows = sync_read_sheet($opts['sheet_id'], $range);

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

        $exists = $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM $table WHERE external_id=%s", $row['external_id']),
            ARRAY_A
        );

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


function sync_to_sheets($target_tab = '')
{
    global $wpdb;
    $table = $wpdb->prefix . 'syn_products';

    $opts = sync_product_get_options();
    if ($opts['auto_sync_to_sheet'] === 0) return;


    $sheet_id = $opts['sheet_id'] ?? '';
    if (!$sheet_id) return ['error' => 'Chưa cấu hình sheet ID'];

    $credentials = plugin_dir_path(__DIR__) . 'config/credentials.json';
    if (!file_exists($credentials)) {
        return ['error' => 'Không tìm thấy credentials.json'];
    }

    $client = new Google\Client();
    $client->setApplicationName('Google Sheets Sync');
    $client->setScopes([Google\Service\Sheets::SPREADSHEETS]);
    $client->setAuthConfig($credentials);
    $client->setAccessType('offline');

    $service = new Google\Service\Sheets($client);

    $tab_name = sanitize_text_field($target_tab);
    if ('' === $tab_name) {
        $tab_name = sync_extract_tab_from_range($opts['range'] ?? '');
    }
    if ('' === $tab_name) {
        $tab_name = 'Trang tính1';
    }

    $rows = $wpdb->get_results("SELECT * FROM $table ORDER BY id ASC", ARRAY_A);
    if (!$rows) return ['error' => 'Không có dữ liệu để đồng bộ'];

    $headers = ['external_id', 'name', 'description', 'content', 'category', 'price', 'updated_at'];
    $data = [$headers];

    foreach ($rows as $r) {
        $data[] = [
            $r['external_id'],
            $r['name'],
            $r['description'],
            $r['content'],
            $r['category'],
            $r['price'],
            $r['updated_at']
        ];
    }

    $range_prefix = $tab_name . '!A1:G';
    $service->spreadsheets_values->clear($sheet_id, $range_prefix, new Google\Service\Sheets\ClearValuesRequest());

    $range = $tab_name . '!A1:G' . count($data);
    $body = new Google\Service\Sheets\ValueRange(['values' => $data]);
    $service->spreadsheets_values->update($sheet_id, $range, $body, ['valueInputOption' => 'RAW']);

    error_log('sync_to_sheets: Đã đẩy ' . (count($rows)) . ' dòng lên Google Sheet.');

    return ['status' => 'success', 'count' => count($rows)];
}
