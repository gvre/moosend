<?php
/**
 * Moosend simple api wrapper
 * 
 * @version 1.0
 * @author Giannis Vrentzos <gvre@gvre.gr>
 * @licence http://opensource.org/licenses/MIT MIT
 *
 */
class Moosend
{
    private $apikey;
    private $format;
    private $supportedFormats = [ 'json', 'xml' ];
    private $endpoint = 'https://api.moosend.com/v2';
    private $headers = [ 
        'json' => 'application/json', 
        'xml'  => 'application/xhtml+xml,application/xml', 
    ];

    private function buildUrl($path)
    {
        return $this->endpoint . '/' . trim($path, '/') . '.' . $this->format . '?apikey=' . $this->apikey; 
    }

    public function __construct($apikey, $format = 'json')
    {
        if (!in_array($format, $this->supportedFormats))
            throw new \InvalidArgumentException('API supports only json and xml formats');

        $this->apikey = $apikey;
        $this->format = $format;
    }

    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
    }

    public function get($path, array $params = [])
    {
        $url = $this->buildUrl($path);
        if ($params)
            $url .= '&' . http_build_query($params);

        $opts = [
            'http'=> [
                'method' => "GET",
                'header' => "Accept: {$this->headers[$this->format]}\r\n"
            ]    
        ];

        $context = stream_context_create($opts);
        $response = @file_get_contents($url, false, $context);

        return $response !== false ? json_decode($response, true) : [];
    }

    public function post($path, array $params = [])
    {
        $url = $this->buildUrl($path);
        $opts = [
            'http'=> [
                'method' => "POST",
                'header' => "Accept: {$this->headers[$this->format]}\r\n"
            ]    
        ];

        if ($params)
            $opts['http']['content'] = http_build_query($params);

        $context = stream_context_create($opts);
        $response = @file_get_contents($url, false, $context);

        return $response !== false ? json_decode($response, true) : [];
    }

    public function delete($path)
    {
        $url = $this->buildUrl($path);
        $opts = [
            'http'=> [
                'method' => "DELETE",
                'header' => "Accept: {$this->headers[$this->format]}\r\n"
            ]    
        ];

        $context = stream_context_create($opts);
        $response = @file_get_contents($url, false, $context);

        return $response !== false ? json_decode($response, true) : [];
    }
}

