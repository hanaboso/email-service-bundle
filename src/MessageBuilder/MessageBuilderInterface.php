<?php declare(strict_types=1);

namespace EmailServiceBundle\MessageBuilder;

use EmailServiceBundle\Transport\TransportMessageInterface;

/**
 * Interface MessageBuilderInterface
 *
 * @package App\MessageBuilder
 */
interface MessageBuilderInterface
{

    /**
     * @param array $data
     *
     * @return TransportMessageInterface
     */
    public function buildTransportMessage(array $data): TransportMessageInterface;

}
