<?php

namespace App\Services\VkApi;

class VkApiRequest
{
    // VK access token (service token)
    protected $accessToken;

    /**
     * @param  string  $accessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = trim($accessToken);
    }

    /**
     * @return string $accessToken
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    // VK version API
    protected $version;

    /**
     * @param  string  $version
     */
    public function setVersion($version)
    {
        $this->version = trim($version);
    }

    /**
     * @return string $version
     */
    public function getVersion()
    {
        return $this->version;
    }

    // VK url API
    protected $url;

    /**
     * @param string $url
     *
     * @return string $url
     */
    public function getUrl($url)
    {
        return $this->url . $url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

     /**
     * GEt Method
     * @param string $url
     * @return array|mixed
     */
    public function get($url)
    {
        try {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL            => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING       => "",
                CURLOPT_MAXREDIRS      => 10,
                CURLOPT_TIMEOUT        => 30,
                CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST  => "GET",
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if (!empty($err)) {
                return json_decode($err, true);
            }

            return json_decode($response, true);
        } catch (\Exception $exception) {
            return [
                'code'    => $exception->getCode(),
                'message' => $exception->getMessage(),
            ];
        }
    }
}
