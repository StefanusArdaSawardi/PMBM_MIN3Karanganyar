<?php
 
// Rebuild database schema and seed data
try {
    $dbFile = __DIR__ . '/../database/database.sqlite';
    
    if (file_exists($dbFile)) {
        unlink($dbFile);
    }
    
    // Create new blank SQLite database
    file_put_contents($dbFile, '');
    
    // Bootstrap Laravel
    require __DIR__ . '/../vendor/autoload.php';
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
 
    echo "<h3>1. Running Migrations...</h3>";
    $statusMigrate = \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    echo "Status: " . ($statusMigrate === 0 ? "Success" : "Failed (" . $statusMigrate . ")") . "<br>";
    echo "<pre>" . \Illuminate\Support\Facades\Artisan::output() . "</pre>";
 
    echo "<h3>2. Seeding Database...</h3>";
    $statusSeed = \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
    echo "Status: " . ($statusSeed === 0 ? "Success" : "Failed (" . $statusSeed . ")") . "<br>";
    echo "<pre>" . \Illuminate\Support\Facades\Artisan::output() . "</pre>";
 
    echo "<h2>✓ Database Overhaul completed successfully!</h2>";
} catch (\Exception $e) {
    echo "<h2>❌ Error occurred:</h2>";
    echo "<pre>" . $e->getMessage() . "\n" . $e->getTraceAsString() . "</pre>";
}
