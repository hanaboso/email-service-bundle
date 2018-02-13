<?php declare(strict_types=1);

namespace EmailServiceBundle\Exception;

use Exception;

/**
 * Class PipesFrameworkException
 *
 * @package App\PipesFrameworkException
 */
class PipesFrameworkException extends Exception
{

    public const UNKNOWN_ERROR                = 1;
    public const REQUIRED_PARAMETER_NOT_FOUND = 2;

}
