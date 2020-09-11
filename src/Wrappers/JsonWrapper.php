<?php

namespace Armyan\Response\Wrappers;

use Armyan\Response\WrapperInterface;

class JsonWrapper implements WrapperInterface
{
    /**
     * Server Protocol
     * @var string
     */
    protected $protocol;

    /**
     * Container for headers
     * @var array|string[]
     */
    protected $headers = [];

    /**
     * Container for collected data
     * @var array
     */
    protected $body = [];

    /**
     * Container for logs
     * @var array
     */
    protected $logs = [];

    /**
     * @var bool
     */
    protected $error = false;

    /**
     * @var string
     */
    protected $message = '';

    /**
     * JsonWrapper constructor.
     */
    public function __construct()
    {
        $this->protocol = $_SERVER["SERVER_PROTOCOL"];
        $this->headers = ['Content-Type: application/json'];
    }

    /**
     * Prepare and return the response with
     * corresponding data and status code
     * @param int $code
     */
    public function response(int $code = 200) : void
    {
        $this->setHeader($this->protocol." ".$code);
        $wrappedData = $this->prepareData();
        ob_start();
        $this->createHeaders();
        echo json_encode($wrappedData);
        ob_end_flush();
        exit;
    }

    /**
     * Add given header to Headers container
     * @param string $header
     */
    public function setHeader(string $header) : void
    {
        $this->headers[] = $header;
    }

    /**
     * Prepare the data for response
     * @return array
     */
    protected function prepareData() : array
    {
        $data["error"] = $this->error;
        $data["message"] = $this->message;
        $data["body"] = $this->body;
        $data["logs"] = $this->logs;

        return $data;
    }

    /**
     * Create already defined headers for response
     */
    protected function createHeaders() : void
    {
        foreach($this->headers as $header) {
            header($header);
        }
    }

    /**
     * Append values in Body container
     * @param array $data
     */
    public function appendBody(array $data) : void
    {
        foreach ($data as $key=>$value) {
            $this->body[$key] = $value;
        }
    }

    /**
     * Append log in Logs container
     * @param string $log
     */
    public function appendLog(string $log = '') : void
    {
        $this->logs[] = $log;
    }

    /**
     * @param bool $error
     */
    public function setError(bool $error) : void
    {
        $this->error = $error;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message) : void
    {
        $this->message = $message;
    }
}