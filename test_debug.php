<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Test 1: Check route resolution
echo "=== ROUTE TEST ===\n";
$routes = [
    'jenis-pelanggaran.edit.web' => 1,
    'jenis-pelanggaran.destroy.web' => 1,
    'departemen.edit.web' => 1,
    'departemen.destroy.web' => 1,
    'api.jenis-pelanggaran.destroy' => 1,
    'api.departemen.destroy' => 1,
];

foreach ($routes as $name => $id) {
    try {
        $url = route($name, $id);
        echo "✓ $name: $url\n";
    } catch (Exception $e) {
        echo "✗ $name: ERROR - " . $e->getMessage() . "\n";
    }
}

// Test 2: Check views
echo "\n=== VIEW TEST ===\n";
$views = [
    'jenis-pelanggaran.index',
    'departemen.index',
    'sanksi.index',
];

foreach ($views as $view) {
    $path = 'resources/views/' . str_replace('.', '/', $view) . '.blade.php';
    if (file_exists($path)) {
        echo "✓ $view exists\n";
    } else {
        echo "✗ $view NOT FOUND\n";
    }
}

// Test 3: Check model binding
echo "\n=== MODEL BINDING TEST ===\n";
$models = [
    'departemen' => App\Models\Departemen::class,
    'jenis_pelanggaran' => App\Models\Jenispelanggaran::class,
    'sanksi' => App\Models\Sanksi::class,
];

foreach ($models as $name => $class) {
    $count = $class::count();
    echo "✓ $name: $count records\n";
}

echo "\n=== Tests Complete ===\n";
