<?php

namespace App\Helpers;

class HttpHelper
{
    /**
     * Make single request and return decoded result
     * @param string $url
     * @return mixed
     */
    public static function doSingleRequest(string $url)
    {
        try {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_USERPWD, env('GITHUB_API_KEY'));
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'User-Agent: request',
            ));
            $html = curl_exec($ch);
            curl_close($ch);
            return json_decode($html, true);
        } catch (\Exception $e) {
            var_dump($e->getMessage());
            exit;
        }
    }

    /**
     * Make multiple requests and return decoded result as array
     * @param array $urls
     * @return array
     */
    public static function doMultipleRequests(array $urls): array
    {
        try {
            $ch = array();
            $mh = curl_multi_init();
            foreach ($urls as $i => $url) {
                $ch[$i] = curl_init();
                curl_setopt($ch[$i], CURLOPT_URL, $url);
                curl_setopt($ch[$i], CURLOPT_HEADER, 0);
                curl_setopt($ch[$i], CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch[$i], CURLOPT_USERPWD, env('GITHUB_API_KEY'));
                curl_setopt($ch[$i], CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                curl_setopt($ch[$i], CURLOPT_CONNECTTIMEOUT, 60);
                curl_setopt($ch[$i], CURLOPT_TIMEOUT, 60);
                curl_setopt($ch[$i], CURLOPT_HTTPHEADER, array(
                    'User-Agent: request',
                ));

                curl_multi_add_handle($mh, $ch[$i]);
            }

            $active = null;
            do {
                curl_multi_exec($mh, $active);
            } while ($active);

            $responses = [];
            foreach ($ch as $i => $c) {
                $r = curl_multi_getcontent($c);
                $responses[] = json_decode($r, true);
                curl_multi_remove_handle($mh, $c);
            }
            return $responses;
        } catch (\Exception $e) {
            var_dump($e->getMessage());
            exit;
        }
    }
}


?>
