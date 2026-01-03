<?php
/**
 * Check PHP cache status and clear if needed
 */

echo "=== PHP CACHE STATUS ===\n\n";

// Check OPcache
if (function_exists('opcache_get_status')) {
    $status = opcache_get_status();
    if ($status && isset($status['opcache_enabled'])) {
        echo "OPcache Status: " . ($status['opcache_enabled'] ? "ENABLED" : "DISABLED") . "\n";
        
        if ($status['opcache_enabled']) {
            echo "Cache hits: " . $status['opcache_statistics']['hits'] . "\n";
            echo "Cache misses: " . $status['opcache_statistics']['misses'] . "\n";
            echo "Cached scripts: " . $status['opcache_statistics']['num_cached_scripts'] . "\n\n";
            
            // Clear OPcache
            if (opcache_reset()) {
                echo "✅ OPcache cleared successfully!\n\n";
            } else {
                echo "❌ Failed to clear OPcache\n\n";
            }
        }
    }
} else {
    echo "OPcache: NOT INSTALLED\n\n";
}

// Check APC
if (function_exists('apc_clear_cache')) {
    if (apc_clear_cache()) {
        echo "✅ APC cache cleared!\n";
    }
} else {
    echo "APC: NOT INSTALLED\n";
}

echo "\n=== DONE ===\n";
echo "PHP cache has been cleared. Try accessing the application again.\n";
