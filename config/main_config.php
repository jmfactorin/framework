<?php

/**
 * Config class for main bundle
 */
class MainConfig extends Config
{
    /**
     * Setup function for config
     */
    public function setup()
    {
        $this->setErrorFile(ROOT_DIR . 'web/404.php');
    }
}