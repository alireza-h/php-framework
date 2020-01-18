<?php

namespace Framework\Services;

use Framework\Lib\Service;

class PathService extends Service
{
    public const APPLICATION_BASE_PATH = 'application_base_path';

    private $basePath;

    public function __construct()
    {
        $this->basePath = $this->service(self::APPLICATION_BASE_PATH);
    }

    public function getBasePath(): string
    {
        return $this->basePath;
    }
}