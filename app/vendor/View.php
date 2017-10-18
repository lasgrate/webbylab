<?php

namespace App\Vendor;

class View
{
    /**
     * Path to template.
     *
     * @var string
     */
    private $template;

    /**
     * Exported data to template.
     *
     * @var array
     */
    private $data;

    public function __construct($template, $data = [])
    {
        $this->template = WWW_DIR . 'views/' . $template;
        $this->data = $data;
    }

    /**
     * Render view.
     *
     * @return string
     */
    public function render() {

        if (is_file($this->template)) {

            extract($this->data);

            ob_start();

            include_once $this->template;

            return ob_get_clean();
        }

        trigger_error('Error: Could not load template ' . $this->template . '!');
        exit();
    }
}
