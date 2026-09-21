<?php
declare(strict_types=1);

// Database Test
$dbStatus = false;
$dbMessage = '';
try {
    $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
        getenv('DB_HOST') ?: 'mysql',
        getenv('DB_PORT') ?: '3306',
        getenv('DB_DATABASE') ?: 'laravel_db'
    );
    $pdo = new PDO($dsn, getenv('DB_USERNAME') ?: 'laravel_user', getenv('DB_PASSWORD') ?: 'laravel_password', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 3,
    ]);
    $dbStatus = true;
    $stmt = $pdo->query('SELECT VERSION() as version');
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $dbMessage = 'Connected successfully! MySQL Version: ' . ($row['version'] ?? 'Unknown');
} catch (Throwable $e) {
    $dbStatus = false;
    $dbMessage = 'Connection failed: ' . $e->getMessage();
}

// Redis Test
$redisStatus = false;
$redisMessage = '';
try {
    if (class_exists('Redis')) {
        $redis = new Redis();
        $connected = $redis->connect(getenv('REDIS_HOST') ?: 'redis', (int)(getenv('REDIS_PORT') ?: 6379), 2.5);
        if ($connected) {
            $redis->set('test_key', 'Docker is awesome at ' . date('Y-m-d H:i:s'));
            $val = $redis->get('test_key');
            $redisStatus = true;
            $redisMessage = 'Connected successfully! Ping test passed: ' . $val;
        } else {
            $redisMessage = 'Could not establish connection to Redis server.';
        }
    } else {
        $redisMessage = 'PHP Redis extension is not loaded.';
    }
} catch (Throwable $e) {
    $redisStatus = false;
    $redisMessage = 'Connection failed: ' . $e->getMessage();
}

$loadedExtensions = get_loaded_extensions();
sort($loadedExtensions);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dockerized Laravel Stack Status</title>
    <style>
        :root {
            --bg: #0f172a;
            --card-bg: #1e293b;
            --border: #334155;
            --text: #f8fafc;
            --muted: #94a3b8;
            --primary: #38bdf8;
            --success: #4ade80;
            --error: #f87171;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--bg);
            color: var(--text);
            line-height: 1.6;
            padding: 2rem;
            min-height: 100vh;
        }
        .container { max-width: 900px; margin: 0 auto; }
        header { text-align: center; margin-bottom: 2.5rem; }
        h1 { font-size: 2.2rem; color: var(--primary); margin-bottom: 0.5rem; }
        p.subtitle { color: var(--muted); font-size: 1.1rem; }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; }
        .card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3);
        }
        .card-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem; }
        .card-title { font-size: 1.25rem; font-weight: 600; }
        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        .badge-success { background: rgba(74, 222, 128, 0.15); color: var(--success); border: 1px solid var(--success); }
        .badge-error { background: rgba(248, 113, 113, 0.15); color: var(--error); border: 1px solid var(--error); }
        .badge-info { background: rgba(56, 189, 248, 0.15); color: var(--primary); border: 1px solid var(--primary); }
        .card-body p { color: var(--muted); font-size: 0.95rem; margin-bottom: 0.5rem; }
        .card-body strong { color: var(--text); }
        .extensions-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 1rem;
        }
        .ext-tag {
            background: #0f172a;
            border: 1px solid var(--border);
            padding: 0.2rem 0.6rem;
            border-radius: 6px;
            font-size: 0.8rem;
            color: var(--muted);
        }
        footer { text-align: center; color: var(--muted); font-size: 0.9rem; margin-top: 2rem; border-top: 1px solid var(--border); padding-top: 1.5rem; }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>🐳 Dockerized Laravel Stack</h1>
            <p class="subtitle">Multi-Container Environment (Nginx, PHP 8.3 FPM, MySQL 8, Redis & Mailpit)</p>
        </header>

        <div class="grid">
            <!-- PHP Card -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title">🐘 PHP & Engine</div>
                    <span class="badge badge-success">Active</span>
                </div>
                <div class="card-body">
                    <p><strong>PHP Version:</strong> <?= PHP_VERSION ?></p>
                    <p><strong>Server Software:</strong> <?= $_SERVER['SERVER_SOFTWARE'] ?? 'Nginx Reverse Proxy' ?></p>
                    <p><strong>SAPI:</strong> <?= php_sapi_name() ?></p>
                    <p><strong>Memory Limit:</strong> <?= ini_get('memory_limit') ?></p>
                </div>
            </div>

            <!-- MySQL Card -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title">🐬 MySQL Database</div>
                    <span class="badge <?= $dbStatus ? 'badge-success' : 'badge-error' ?>">
                        <?= $dbStatus ? 'Connected' : 'Error' ?>
                    </span>
                </div>
                <div class="card-body">
                    <p><strong>Host:</strong> <?= htmlspecialchars((string)getenv('DB_HOST')) ?></p>
                    <p><strong>Database:</strong> <?= htmlspecialchars((string)getenv('DB_DATABASE')) ?></p>
                    <p><strong>Status:</strong> <?= htmlspecialchars($dbMessage) ?></p>
                </div>
            </div>

            <!-- Redis Card -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title">⚡ Redis Cache</div>
                    <span class="badge <?= $redisStatus ? 'badge-success' : 'badge-error' ?>">
                        <?= $redisStatus ? 'Connected' : 'Error' ?>
                    </span>
                </div>
                <div class="card-body">
                    <p><strong>Host:</strong> <?= htmlspecialchars((string)getenv('REDIS_HOST')) ?></p>
                    <p><strong>Port:</strong> <?= htmlspecialchars((string)getenv('REDIS_PORT')) ?></p>
                    <p><strong>Status:</strong> <?= htmlspecialchars($redisMessage) ?></p>
                </div>
            </div>
        </div>

        <!-- Extensions Card -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">📦 Loaded PHP Extensions (<?= count($loadedExtensions) ?>)</div>
                <span class="badge badge-info">Production Ready</span>
            </div>
            <div class="card-body">
                <p>The following extensions are compiled and loaded in this PHP-FPM container:</p>
                <div class="extensions-list">
                    <?php foreach ($loadedExtensions as $ext): ?>
                        <span class="ext-tag"><?= htmlspecialchars($ext) ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <footer>
            <p>Docker Course by Antigravity IDE • All Multi-Container Services Operational</p>
        </footer>
    </div>
</body>
</html>
