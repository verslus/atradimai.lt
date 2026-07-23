<?php
declare(strict_types=1);

function atradimai_load_server_config(): void {
    $path = getenv('ATRADIMAI_CONFIG_PATH') ?: '/etc/atradimai/atradimai.env';
    if (!is_readable($path)) {
        throw new RuntimeException('Missing private server configuration.');
    }
    $settings = parse_ini_file($path, false, INI_SCANNER_RAW);
    if (!is_array($settings)) {
        throw new RuntimeException('Invalid private server configuration.');
    }
    foreach ($settings as $key => $value) {
        if (is_string($key) && is_scalar($value) && getenv($key) === false) {
            putenv($key . '=' . (string) $value);
        }
    }
}

function atradimai_env_required(string $name): string {
    $value = getenv($name);
    if ($value === false || trim($value) === '') {
        throw new RuntimeException("Missing server setting: {$name}");
    }
    return trim($value);
}
