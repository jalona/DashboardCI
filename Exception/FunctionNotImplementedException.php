<?php

namespace MB\DashboardBundle\Exception;

class FunctionNotImplementedException extends \Exception
{
    public function __construct($function)
    {
        parent::__construct('You must implement the function "' . $function . '()');
    }
}
