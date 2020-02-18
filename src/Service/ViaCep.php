<?php

namespace App\Service;
use App\Basics\ViaBuscaCEP;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

class ViaCep
{
    /**
     * HTTP client.
     * @var Client
     */
    protected $http;
    /**
     * Address.
     * @var ViaBuscaCEP
     */
    protected $address;
    /**
     * @param ClientInterface $http
     */
    public function __construct(ClientInterface $http = null)
    {
        $this->http = $http ?: new Client;
        $this->address = new ViaBuscaCEP;
    }

    public function find($zipCode)
    {
        $response = $this->http->request('GET', 'https://viacep.com.br/ws/'.$zipCode.'/json');
        $attributes = json_decode($response->getBody(), true);
        if (array_key_exists('erro', $attributes) && $attributes['erro'] === true) {
            return $this->address;
        }
        return $this->address->fill($attributes);
    }
}