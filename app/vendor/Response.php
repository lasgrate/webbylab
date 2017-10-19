<?php

namespace App\Vendor;

/**
 * Class Response manipulate response data.
 * @package App\System
 */
class Response
{
    private $headers = array();

    /**
     * Output content.
     *
     * @var mixed
     */
    private $output;

    /**
     * Add http headers to output.
     *
     * @param $header
     */
    public function addHeader($header)
    {
        $this->headers[] = $header;
    }

    /**
     * Redirect
     *
     * @param $link
     * @param int $status
     */
    public function redirect($link, $status = 302)
    {
        header('Location: ' . str_replace(array('&amp;', "\n", "\r"), array('&', '', ''), $link), true, $status);
        exit();
    }

    public function getOutput()
    {
        return $this->output;
    }

    public function setOutput($output)
    {
        $this->output = $output;
    }

    /**
     * Send content to the client.
     */
    public function output()
    {
        if ($this->output) {

            if (!headers_sent()) {
                foreach ($this->headers as $header) {
                    header($header, true);
                }
            }

            echo $this->output;
        }
    }
}
