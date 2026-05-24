<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$warning = App\Models\DeliveryTimeWarning::first();
echo "Before update: " . json_encode($warning) . "\n";
$warning->update(['is_active' => false]);
echo "After update: " . json_encode(App\Models\DeliveryTimeWarning::first()) . "\n";
