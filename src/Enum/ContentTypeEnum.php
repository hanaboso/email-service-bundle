<?php declare(strict_types=1);

namespace EmailServiceBundle\Enum;

/**
 * Class ContentTypeEnum
 *
 * @package EmailServiceBundle\Enum
 */
enum ContentTypeEnum: string
{

    case PLAIN = 'text/plain';
    case HTML  = 'text/html';

}
