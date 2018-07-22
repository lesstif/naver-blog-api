<?php

namespace Lesstif\NaverBlogApi;

use Monolog\Logger;

/**
 * Class DotEnvConfiguration.
 */
class DotEnvConfiguration
{
    public $host = 'https://openapi.naver.com/blog/';
    public $accessToken;

    public $curlOptSslVerifyHost = false;
    public $curlOptSslVerifyPeer = false;
    public $curlOptVerbose = false;

    public $logFile = 'blogapi-logfile.txt';
    public $logLevel = Logger::DEBUG;

    /**
     * @param string $path
     *
     * @throws NaverBlogException
     */
    public function __construct($path = '.')
    {
        // support for dotenv 1.x and 2.x. see also https://github.com/lesstif/php-jira-rest-client/issues/102
        if (class_exists('\Dotenv\Dotenv')) {
            $dotenv = new \Dotenv\Dotenv($path);

            $dotenv->load();
            $dotenv->required(['ACCESS_TOKEN', ]);
        } elseif (class_exists('\Dotenv')) {
            \Dotenv::load($path);
            \Dotenv::required(['ACCESS_TOKEN']);
        } else {
            throw new NaverBlogException('can not load PHP dotenv class.!');
        }

        $this->curlOptSslVerifyHost = $this->env('CURLOPT_SSL_VERIFYHOST', false);
        $this->curlOptSslVerifyPeer = $this->env('CURLOPT_SSL_VERIFYPEER', false);
        $this->curlOptVerbose = $this->env('CURLOPT_VERBOSE', false);
    }

    /**
     * Gets the value of an environment variable. Supports boolean, empty and null.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    private function env($key, $default = null)
    {
        $value = getenv($key);

        if ($value === false) {
            return $default;
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;

            case 'false':
            case '(false)':
                return false;

            case 'empty':
            case '(empty)':
                return '';

            case 'null':
            case '(null)':
                return;
        }

        if ($this->startsWith($value, '"') && $this->endsWith($value, '"')) {
            return substr($value, 1, -1);
        }

        return $value;
    }

    /**
     * Determine if a given string starts with a given substring.
     *
     * @param string       $haystack
     * @param string|array $needles
     *
     * @return bool
     */
    public function startsWith($haystack, $needles)
    {
        foreach ((array) $needles as $needle) {
            if ($needle != '' && strpos($haystack, $needle) === 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine if a given string ends with a given substring.
     *
     * @param string       $haystack
     * @param string|array $needles
     *
     * @return bool
     */
    public function endsWith($haystack, $needles)
    {
        foreach ((array) $needles as $needle) {
            if ((string) $needle === substr($haystack, -strlen($needle))) {
                return true;
            }
        }

        return false;
    }
}
