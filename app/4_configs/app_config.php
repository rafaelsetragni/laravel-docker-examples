<?php

abstract class AppConfig {


    /**
     * Get a string configuration value from environment variables.
     *
     * @param string? $key
     * @param string|null $default
     * @return string
     */
    protected function getStringConfig(string $key, ?string $default = null): string
    {
        if (empty($key)) {
            throw new InvalidArgumentException("Configuration key cannot be empty.");
        }
        $value = env($key);

        if ($value === null) {
            if ($default === null) {
                throw new InvalidArgumentException("Missing required configuration value for '$key'. Expected a string value.");
            }
            return $default;
        }
        return (string) $value;
    }

    /**
     * Get a boolean configuration value from environment variables.
     *
     * @param string $key
     * @param bool|null $default
     * @return bool
     */
    protected function getBooleanConfig(string $key, ?bool $default = null): bool
    {
        $value = env($key);

        if ($value === null) {
            if ($default === null) {
                throw new InvalidArgumentException("Missing required configuration value for '$key'. Expected 'true', 'false', '1', or '0'.");
            }
            return $default;
        }

        $boolValue = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

        if ($boolValue === null) {
            throw new InvalidArgumentException("Invalid boolean value for '$key'. Expected 'true', 'false', '1', or '0'.");
        }

        return $boolValue;
    }

    /**
     * Get an integer configuration value from environment variables.
     *
     * @param string $key
     * @param int|null $default
     * @return int
     */
    protected function getIntegerConfig(string $key, ?int $default = null): int
    {
        $value = env($key);

        if ($value === null) {
            if ($default === null) {
                throw new InvalidArgumentException("Missing required configuration value for '$key'. Expected a numeric value.");
            }
            return $default;
        }

        if (!is_numeric($value)) {
            throw new InvalidArgumentException("Invalid integer value for '$key'. Expected a numeric value.");
        }

        return (int)$value;
    }

    /**
     * Get an array configuration value from environment variables.
     *
     * @param string $key
     * @param array|null $default
     * @return array
     */
    protected function getArrayConfig(string $key, ?array $default = null): array
    {
        $value = env($key);

        if ($value === null) {
            if ($default === null) {
                throw new InvalidArgumentException("Missing required configuration value for '$key'. Expected a JSON array string.");
            }
            return $default;
        }

        $decoded = json_decode($value, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            // Fallback for comma-separated values
            return array_map('trim', explode(',', $value));
        }

        if (!is_array($decoded)) {
            throw new InvalidArgumentException("Invalid array value for '$key'. Expected a JSON array string.");
        }

        return $decoded;
    }
}
