<?php

namespace Armyan\Response;

interface WrapperInterface
{
    /**
     * @param string $header
     */
    public function setHeader(string $header) : void;

    /**
     * @param array $data
     */
    public function appendBody(array $data) : void;

    /**
     * @param int $code
     */
    public function response(int $code = 200) : void;

    /**
     * @param string $log
     */
    public function appendLog(string $log = '') : void;
}