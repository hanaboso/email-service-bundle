<?php declare(strict_types=1);

namespace EmailServiceBundle\Transport;

use EmailServiceBundle\Exception\PipesFrameworkException;

/**
 * Class TransportException
 *
 * @package EmailServiceBundle\Transport
 */
class TransportException extends PipesFrameworkException
{

    protected const OFFSET = 600;

    public const SEND_FAILED = self::OFFSET + 1;

}
