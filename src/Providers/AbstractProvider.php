<?php

namespace Yong\Translate\Providers;

use Yong\Translate\Contracts\ProviderInterface;
use Yong\Translate\Supports\Config;
use Yong\Translate\Traits\HasHttpRequest;

/**
 * Class AbstractProvider.
 */
abstract class AbstractProvider implements ProviderInterface
{
    use HasHttpRequest;

    /**
     * Provider name.
     *
     * @var string
     */
    protected $name;

    /**
     * @var Config
     */
    protected $config;

    /**
     * The app id.
     *
     * @var string
     */
    protected $appId;

    /**
     * The app key.
     *
     * @var string
     */
    protected $appKey;

    /**
     * AbstractProvider constructor.
     *
     * @param string $app_id
     * @param string $app_key
     * @param array  $config
     */
    public function __construct($app_id, $app_key, array $config)
    {
        $this->appId = $app_id;
        $this->appKey = $app_key;

        $this->config = new Config($config);
    }

    /**
     * Get the translate URL for the provider.
     *
     * @return string
     */
    protected function getTranslateUrl()
    {
        return $this->config->get('ssl', false) ? static::HTTPS_URL : static::HTTP_URL;
    }

    /**
     * {@inheritdoc}
     */
    abstract public function translate($string, $from = 'zh', $to = 'en');

    /**
     * @param array $translateResult
     *
     * @return array
     */
    abstract protected function mapTranslateResult(array $translateResult);

    /**
     * @return string
     *
     * @throws \ReflectionException
     */
    public function getName()
    {
        if (empty($this->name)) {
            $this->name = strstr((new \ReflectionClass(get_class($this)))->getShortName(), 'Provider', true);
        }

        return $this->name;
    }

    /**
     * @param array  $array
     * @param string $key
     * @param null   $default
     *
     * @return array|mixed|null
     */
    protected function arrayItem(array $array, $key, $default = null)
    {
        if (is_null($key)) {
            return $array;
        }

        if (isset($array[$key])) {
            return $array[$key];
        }

        foreach (explode('.', $key) as $segment) {
            if (!is_array($array) || !array_key_exists($segment, $array)) {
                return $default;
            }

            $array = $array[$segment];
        }

        return $array;
    }
}
