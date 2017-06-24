<?php

namespace Three9Dice\Bots\Service\Configurate;

use Illuminate\Support\Arr;
use Symfony\Component\Yaml\Yaml;

/**
 * Class AbstractConfigParser
 * @package Three9Dice\Bots\Service\Configurate
 */
abstract class AbstractConfigParser
{
    /** @var string $configPath */
    private $configPath;

    /** @var array $config */
    private $config;

    /**
     * AbstractConfigParser constructor.
     *
     * @param string $configPath
     *
     * @throws ConfigurateException
     */
    public function __construct(string $configPath)
    {
        if (!is_file($configPath)) {
            throw new ConfigurateException("Configuration file {$configPath} not found");
        }

        $this->configPath = $configPath;
        $this->config = $this->extractConfigurateContent();
    }

    /**
     * @return array
     * @throws ConfigurateException
     */
    private function extractConfigurateContent(): array
    {
        $configContent = file_get_contents($this->configPath);
        if (empty($configContent)) {
            throw new ConfigurateException('Config file empty');
        }

        return Yaml::parse($configContent);
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->get('cred.apiKey');
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->get('cred.username');
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->get('cred.password');
    }

    /**
     * @param string $key
     * @param null   $default
     *
     * @return string
     */
    public function get(string $key, $default = null)
    {
        return Arr::get($this->getConfig(), $key, $default);
    }
}
