<?php declare(strict_types=1);

namespace EmailServiceBundle\Enum;

use Hanaboso\Utils\Enum\EnumAbstract;

/**
 * Class ContentTypeEnum
 *
 * @package EmailServiceBundle\Enum
 */
final class ContentTypeEnum extends EnumAbstract
{

    public const PLAIN = 'text/plain';
    public const HTML  = 'text/html';

    /**
     * @var string[]
     */
    protected static array $choices = [
        self::PLAIN => self::PLAIN,
        self::HTML  => self::HTML,
    ];

}
