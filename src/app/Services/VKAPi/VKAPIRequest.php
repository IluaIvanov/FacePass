<?php

namespace App\Services\VKAPI;

class VKAPIRequest
{
     // /**
    //  * return headers
    //  * @return array
    //  */
    // protected function getHeaders()
    // {
    //     return array(
    //         'Content-Type: application/json; charset=utf-8',
    //         'X-Requested-With:XMLHttpRequest',
    //         'Authorization: Basic '.$this->getAuthorization(),
    //     );
    // }

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
                // CURLOPT_HTTPHEADER     => $this->getHeaders(),
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
