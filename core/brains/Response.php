<?php

namespace Apptive\Core\Brains;

use Apptive\Core\Brains\XML;
use Error;

class Response
{
    private $code;
    private $headers = [];

    public static function make(int $code = 200)
    {
        return new Response($code);
    }

    private function __construct(int $code)
    {
        $this->code = $code;
    }

    private function insertResponseHeader()
    {
        http_response_code($this->code);
        foreach ($this->headers as $key => $value) {
            header($key . ':' . $value);
        }
    }

    public function addHeader($key, $value)
    {
        $this->headers[$key] = $value;

        return $this;
    }

    public function sendPage($path, $context = [], $layout = 'default')
    {
        $this->addHeader('Content-Type', 'text/html');
        $this->insertResponseHeader();

        extract($context);
        define('PAGE_FILE', Resource::page($path));
        define('LAYOUT_FILE', Resource::layout($layout));
        include LAYOUT_FILE;
    }

    public function sendError($errorPage, $context = [])
    {
        $this->addHeader('Content-Type', 'text/html');
        $this->insertResponseHeader();
        extract($context);
        include Resource::error($errorPage);
    }

    public function sendJSON($data)
    {
        $this->addHeader('Content-Type', 'application/json');
        $this->insertResponseHeader();

        echo json_encode($data);
    }

    public function sendXML(array $data, $rootElement = null, string $version = '1.0', string $encoding = 'UTF-8')
    {
        $this->addHeader('Content-Type', 'application/xml');
        $this->insertResponseHeader();

        echo XML::convert($data, $rootElement, true, $encoding, $version);
    }

    public function sendHTML(?string $htmlString)
    {
        $this->addHeader('Content-Type', 'text/html');
        $this->insertResponseHeader();

        echo $htmlString;
    }

    public function sendPlain(?string $plain)
    {
        $this->addHeader('Content-Type', 'text/plain');
        $this->insertResponseHeader();

        echo $plain;
    }

    public function send()
    {
        $this->insertResponseHeader();
    }
}
