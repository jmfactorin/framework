<?php

/**
 * Class Controller
 */
abstract class Controller
{
    const VIEW_CLASS = 'View';

    /** @var View $view */
    private $view;

    /**
     * class constructor
     */
    final public function __construct()
    {
        $view_class = static::VIEW_CLASS;
        $this->view = new $view_class;
        unset($view_class);
    }

    /**
     * Validate call function
     * @param $name
     * @param $args
     * @return mixed
     * @throws Exception
     */
    final public function __call($name, $args)
    {
        if (!method_exists($this, $name)) {
            throw new Exception('Call to undefined method ' . get_class($this) . '::' . $name);
        }

        $action = new ReflectionMethod($this, $name);
        if (!$action->isPublic()) {
            throw new Exception('Access denied to call ' . get_class($this) . '::' . $name);
        }
    }

    /**
     * Set all variable and values to view
     * @param $var
     * @param $value
     */
    final public function __set($var, $value)
    {
        $this->view->set($var, $value);
    }

    /**
     * Modify view template file
     * @param $template
     */
    final public function setTemplate($template)
    {
        $this->view->setTemplate($template);
    }

    /**
     * Do controller's action name
     * @param $action
     */
    final public function execute($action)
    {
        $this->initialize();
        $display = $this->{$action}();
        $this->finalize();
        if ($display !== View::NONE) {
            $this->view->render();
        }
    }

    /**
     * Function before execute action
     */
    protected function initialize()
    {

    }

    /**
     * Function after execute action
     */
    protected function finalize()
    {

    }

    /**
     * Redirect to new page
     * @param $url
     */
    public function redirect($url)
    {
        header('Location: ' . $url);
    }
}