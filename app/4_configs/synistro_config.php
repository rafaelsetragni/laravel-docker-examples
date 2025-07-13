<?php

use Psr\Log\LogLevel;

class PostgreConfig {

    public string $DbHostName;
    public string $DbUserName;
    public string $DbPassword;
    public string $DbDatabaseName;
    public string $DbPort;
    public bool $DbUseSSL;
    public bool $DbUseSSLVerify;
    public string $databaseClientKeyPath;
    public string $databaseClientCertPath;
}

class SslConfig {

    public string $sslCertPath;
    public string $sslKeyPath;
}

class LogConfig {

    public string $logLevel;
}

class JwtConfig {

    public string $jwtSecret;
    public int $jwtExpiration;
}

class PasswordConfig {

    public string $passwordSecret;
    public String $passwordSalt;
}

class VersionConfig {
    public string $version;
    public string $minimumVersionAccepted;
}

class HttpConfig {

    public string $httpHost;
    public int $httpPort;
    public bool $useHttps;
}

class RedisConfig {

    public string $redisHost;
    public int $redisPort;
    public string $redisPassword;
    public int $redisDatabaseIndex;
}

class LanguageConfig {

    public string $defaultLanguage;
    public array $supportedLanguages;
}

class SupabaseConfig {

    public string $supabaseUrl;
    public string $supabaseKey;
}

class SynistroConfig extends AppConfig {

    public PostgreConfig $postgreConfig;
    public SslConfig $sslConfig;
    public LogConfig $logConfig;
    public JwtConfig $jwtConfig;
    public PasswordConfig $passwordConfig;
    public VersionConfig $versionConfig;
    public HttpConfig $httpConfig;
    public RedisConfig $redisConfig;
    public LanguageConfig $languageConfig;
    public SupabaseConfig $supabaseConfig;

    public function __construct() {
        $this->postgreConfig = new PostgreConfig();
        $this->sslConfig = new SslConfig();
        $this->logConfig = new LogConfig();
        $this->jwtConfig = new JwtConfig();
        $this->passwordConfig = new PasswordConfig();
        $this->versionConfig = new VersionConfig();
        $this->httpConfig = new HttpConfig();
        $this->redisConfig = new RedisConfig();
        $this->languageConfig = new LanguageConfig();
        $this->supabaseConfig = new SupabaseConfig();
        $this->loadConfigs();
    }

    private function loadConfigs() {

        $this->versionConfig->version = $this->getStringConfig('VERSION');
        $this->versionConfig->minimumVersionAccepted = '0.0.1';

        $this->postgreConfig->DbHostName = $this->getStringConfig('DB_HOST');
        $this->postgreConfig->DbUserName = $this->getStringConfig('DB_USERNAME');
        $this->postgreConfig->DbPassword = $this->getStringConfig('DB_PASSWORD');
        $this->postgreConfig->DbDatabaseName = $this->getStringConfig('DB_DATABASE');
        $this->postgreConfig->DbPort = $this->getStringConfig('DB_PORT');
        $this->postgreConfig->DbUseSSL = $this->getBooleanConfig('DB_USE_SSL', false);
        $this->postgreConfig->DbUseSSLVerify = $this->getBooleanConfig('DB_USE_SSL_VERIFY', false);
        $this->postgreConfig->databaseClientKeyPath = $this->getStringConfig('DATABASE_CLIENT_KEY_PATH', '/var/certificates/database/client-cert.pem');
        $this->postgreConfig->databaseClientCertPath = $this->getStringConfig('DATABASE_CLIENT_CERT_PATH', '/var/certificates/database/client-key.pem');
        $this->sslConfig->sslCertPath = $this->getStringConfig('SSL_CERT_PATH');
        $this->sslConfig->sslKeyPath = $this->getStringConfig('SSL_KEY_PATH');
        $this->logConfig->logLevel = $this->getStringConfig('LOG_LEVEL', LogLevel::INFO);
        $this->jwtConfig->jwtSecret = $this->getStringConfig('JWT_SECRET');
        $this->jwtConfig->jwtExpiration = $this->getIntegerConfig('JWT_EXPIRATION', 300);
        $this->passwordConfig->passwordSecret = $this->getStringConfig('PASSWORD_SECRET');
        $this->passwordConfig->passwordSalt = $this->getStringConfig('PASSWORD_SALT');
        $this->httpConfig->httpHost = $this->getStringConfig('HTTP_HOST', 'localhost');
        $this->httpConfig->httpPort = $this->getIntegerConfig('HTTP_PORT', 8000);
        $this->httpConfig->useHttps = $this->getBooleanConfig('USE_HTTPS', false);
        $this->redisConfig->redisHost = $this->getStringConfig('REDIS_HOST', 'localhost');
        $this->redisConfig->redisPort = $this->getIntegerConfig('REDIS_PORT', 6379);
        $this->redisConfig->redisPassword = $this->getStringConfig('REDIS_PASSWORD', '');
        $this->redisConfig->redisDatabaseIndex = $this->getIntegerConfig('REDIS_DATABASE_INDEX', 0);
        $this->languageConfig->defaultLanguage = $this->getStringConfig('DEFAULT_LANGUAGE', 'en');
        $this->languageConfig->supportedLanguages = $this->getArrayConfig('SUPPORTED_LANGUAGES', ['en', 'es', 'pt-br']);
        $this->supabaseConfig->supabaseUrl = $this->getStringConfig('SUPABASE_URL');
        $this->supabaseConfig->supabaseKey = $this->getStringConfig('SUPABASE_KEY');
    }
}
