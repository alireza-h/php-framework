<?php

namespace Framework\Lib;

class Config
{
    private $configFilesDirectoryPath;
    private $configs = [];

    public function __construct(string $configFilesDirectoryPath)
    {
        $this->configFilesDirectoryPath = $configFilesDirectoryPath;

        return $this->configs();
    }

    private function configs()
    {
        $configFiles = glob($this->configFilesDirectoryPath . '/*.php');

        foreach ($configFiles as $configFile) {
            $config = require_once $configFile;
            if(is_array($config)) {
                $configKey = str_replace('.php', '', basename($configFile));
                $this->configs[$configKey] = $config;
            }
        }

        return $this->configs;
    }

    /**
     * get specified config array or key
     *    access to configs array value with dot notation : key.nested_key
     *
     * @param string|null $key
     * @param null $default
     * @return array|mixed|null
     */
    public function get(string $key = null, $default = null)
    {
        if(!is_string($key)) {
            return $this->configs;
        }

        $keys = explode('.', $key);
        $configs = $this->configs;

        foreach ($keys as $key) {
            if (!is_array($configs) || !isset($configs[$key])) {
                return $default;
            }

            $configs = &$configs[$key];
        }

        return $configs;
    }
}