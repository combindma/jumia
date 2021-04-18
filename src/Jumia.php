<?php

namespace Combindma\Jumia;

use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Traits\Macroable;
use Spatie\ArrayToXml\ArrayToXml;

class Jumia
{
    use Macroable;

    protected $user_id;
    protected $api_url;
    protected $api_key;
    protected $enabled;
    protected $version = '1.0';

    public function __construct()
    {
        $this->enabled = config('jumia.enabled');
        $this->setUserId(config('jumia.user_id'));
        $this->setApiUrl(config('jumia.api_url'));
        $this->setApiKey(config('jumia.api_key'));
    }

    private function setUserId($userId)
    {
        $this->user_id = $userId;
    }

    private function setApiUrl($apiUrl)
    {
        $this->api_url = $apiUrl;
    }

    private function setApiKey($apiKey)
    {
        $this->api_key = $apiKey;
    }

    private function userId()
    {
        return $this->user_id;
    }

    private function apiUrl()
    {
        return $this->api_url;
    }

    private function apiKey()
    {
        return $this->api_key;
    }

    public function isEnabled()
    {
        return $this->enabled;
    }

    public function getJumiaProducts()
    {
        return $this->call('GetProducts');
    }

    public function productCreate($products)
    {
        return $this->send('ProductCreate', $this->convertToXml($products));
    }

    public function productUpdate($products)
    {
        return $this->send('ProductUpdate', $this->convertToXml($products));
    }

    public function productImage($products)
    {
        return $this->send('Image', $this->convertToXml($products));
    }

    protected function convertToXml($array)
    {
        return ArrayToXml::convert($array, ['rootElementName' => 'Request'], true, 'UTF-8', '1.0', );
    }

    protected function call($action, array $attributes = [])
    {
        if (! $this->isEnabled()) {
            return 'Sync with Jumia Seller Center is disabled';
        }

        $request = $this->buildRequest($action, 'JSON', $attributes);

        return Http::get($request)->json();
    }

    protected function send($action, $feed = '')
    {
        if (! $this->isEnabled()) {
            return 'Sync with Jumia Seller Center is disabled';
        }
        $request = $this->buildRequest($action, 'XML');

        return Http::withHeaders([
            "Content-Type" => "text/xml;charset=utf-8",
        ])->send("POST", $request, [
            "body" => $feed,
        ])->json();
    }

    protected function buildRequest($action, $format = 'JSON', array $attributes = [])
    {
        // The current time. Needed to create the Timestamp parameter below.
        $now = new DateTime();
        // The parameters for our request. These will get signed.
        $parameters = array_merge([
            // The user ID for which we are making the call.
            'UserID' => $this->userId(),

            // The API version. Currently must be 1.0
            'Version' => $this->version,

            // The API method to call.
            'Action' => $action,

            // The format of the result.
            'Format' => $format,

            // The current time formatted as ISO8601
            'Timestamp' => Carbon::parse($now)->format('Y-m-d\TH:i:sP'),
        ], $attributes);
        // Sort parameters by name.
        ksort($parameters);

        // URL encode the parameters.
        $encoded = [];
        foreach ($parameters as $name => $value) {
            $encoded[] = rawurlencode($name) . '=' . rawurlencode($value);
        }

        // Concatenate the sorted and URL encoded parameters into a string.
        $concatenated = implode('&', $encoded);

        // Compute signature and add it to the parameters.
        $parameters['Signature'] =
            rawurlencode(hash_hmac('sha256', $concatenated, $this->apiKey(), false));

        // Build Query String
        $queryString = http_build_query($parameters, '', '&', PHP_QUERY_RFC3986);

        return $this->api_url.'?'.$queryString;
    }
}
