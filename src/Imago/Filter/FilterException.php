<?php
/**
 * Created by PhpStorm.
 * User: mtomczak
 * Date: 20/03/2017
 * Time: 10:47
 */

namespace Imago\Filter;


class FilterException extends \Exception
{

    /**
     * FilterException constructor.
     * @param string $message
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}