<?php

namespace App\Services\VkApi;

use Exception;

class VkApi extends VkApiRequest
{
    /**
     * VKAPI constructor.
     */
    public function __construct()
    {
        $this->initConfig();
    }

    /**
     * Set up required configuration
     */
    protected function initConfig()
    {
        $this->setAccessToken(config('vk.token'));
        $this->setVersion(config('vk.version'));
        $this->setUrl(config('vk.url'));
    }

    /**
     * users.get method for getting user information
     *
     * @param $fields
     * @param string $method
     * @param string $HTTPMethod
     *
     * @return array|mixed
     */
    public function sendQuery($fields, $method)
    {
        $fields['access_token']          = $this->getAccessToken();
        $fields['v'] = $this->getVersion();

        $url = $this->getUrl($method) . '?' . http_build_query($fields);
        return $this->get($url);
    }
}
