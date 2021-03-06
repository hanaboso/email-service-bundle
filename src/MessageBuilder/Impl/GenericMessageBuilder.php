<?php declare(strict_types=1);

namespace EmailServiceBundle\MessageBuilder\Impl;

use EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder\GenericTransportMessage;
use EmailServiceBundle\MessageBuilder\MessageBuilderAbstract;
use EmailServiceBundle\MessageBuilder\MessageBuilderException;
use EmailServiceBundle\Transport\TransportMessageInterface;
use Hanaboso\Utils\String\Json;

/**
 * Class GenericMessageBuilder
 *
 * @package EmailServiceBundle\MessageBuilder\Impl
 */
class GenericMessageBuilder extends MessageBuilderAbstract
{

    /**
     * @param mixed[] $data
     *
     * @return TransportMessageInterface
     * @throws MessageBuilderException
     */
    public function buildTransportMessage(array $data): TransportMessageInterface
    {
        if (!self::isValid($data)) {
            throw new MessageBuilderException(
                sprintf('Invalid data. || %s', Json::encode($data)),
                MessageBuilderException::INVALID_DATA,
            );
        }

        $content = $data['dataContent'] ?? $data['content'];

        if (is_array($content) && array_key_exists('link', $content)) {
            $content = $content['link'];
        }

        return new GenericTransportMessage(
            $data['from'],
            $data['to'],
            $data['subject'],
            is_array($content) ? Json::encode($content) : $content,
            $data['template'] ?? NULL,
        );
    }

    /**
     * @param mixed[] $data
     *
     * @return bool
     */
    public static function isValid(array $data): bool
    {
        if (!isset($data['from']) || !filter_var($data['from'], FILTER_VALIDATE_EMAIL)) {
            return FALSE;
        }

        if (!isset($data['to']) || !filter_var($data['to'], FILTER_VALIDATE_EMAIL)) {
            return FALSE;
        }

        if (!isset($data['subject'])) {
            return FALSE;
        }

        if (!isset($data['dataContent'])) {
            if (!isset($data['content'])) {
                return FALSE;
            }
        }

        return TRUE;
    }

}
