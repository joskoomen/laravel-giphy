<?php namespace HiddeCo\Giphy\Factories;

/**
 * This file is a part of Laravel Giphy,
 * a Giphy API wrapper for Laravel and Lumen.
 *
 * @package HiddeCo\Giphy
 * @license MIT
 * @author  Hidde Beydals <hello@hidde.co>
 * @version 0.1
 */

use GuzzleHttp\Client as HttpClient;
use HiddeCo\Giphy\Contracts\ClientInterface;

class Client implements ClientInterface
{

    /**
     * @var HttpClient
     */
    protected $client;


    /**
     * @param $baseUrl
     * @param $apiKey
     */
    public function __construct($baseUrl, $apiKey)
    {
        $this->client = new HttpClient([
            'base_uri' => $baseUrl,
            'query' => ['api_key' => $apiKey]
        ]);
    }


    /**
     * @param       $endPoint
     * @param array $params
     *
     * @return mixed
     * @throws \Exception
     */
    public function get($endPoint, array $params = [])
    {
        $query = array_merge($this->client->getConfig('query'), $params);

        $response = $this->client->get($endPoint, ['query' => $query]);

        if ($params['fmt'] == 'json') {
            return response()->json(json_decode($response->getBody()->getContents(), true)['data']);
        }

        return $response->getBody()->getContents();
    }
}
