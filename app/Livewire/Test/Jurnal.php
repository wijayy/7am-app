<?php

namespace App\Livewire\Test;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Message;
use Livewire\Component;

class Jurnal extends Component
{

    public $title = "";
    /**
     * Generate authentication headers based on method and path
     */
    function generate_headers($method, $pathWithQueryParam)
    {
        $datetime = Carbon::now()->toRfc7231String();
        $request_line = "{$method} {$pathWithQueryParam} HTTP/1.1";
        $payload = implode("\n", ["date: {$datetime}", $request_line]);
        $digest = hash_hmac('sha256', $payload, config('mekari.client_secret'), true);
        $signature = base64_encode($digest);

        return [
            'Content-Type' => 'application/json',
            'Date' => $datetime,
            'Authorization' => "hmac username=\"" . config('mekari.client_id') . "\", algorithm=\"hmac-sha256\", headers=\"date request-line\", signature=\"{$signature}\""
        ];
    }
    public function mount()
    {


        // Set http client
        $client = new Client([
            'base_uri' => config('mekari.base_url'),
        ]);

        // Set method and path for the request
        $method = 'GET';
        $path = '/jurnal/public/api/v1/products';
        $queryParam = '';
        $headers = [
            'X-Idempotency-Key' => '1234'
        ];
        $body = [/* request body */];

        // Initiate request
        try {
            $response = $client->request($method, $path, [
                'headers' => array_merge($this->generate_headers($method, $path . $queryParam), $headers),
                'body' => json_encode($body)
            ]);

            echo $response->getBody();
        } catch (ClientException $e) {
            echo Message::toString($e->getRequest());
            echo Message::toString($e->getResponse());
            echo PHP_EOL;
        }
    }

    public function render()
    {
        return view('livewire.test.jurnal')->layout('components.layouts.app', ['title' => $this->title]);
    }
}
