<?php declare(strict_types=1);

namespace EmailServiceBundleTests\Unit\MessageBuilder\Impl\GenericMessageBuilder;

use EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder\GenericContentAttachment;
use PHPUnit\Framework\TestCase;

/**
 * Class GenericContentAttachmentTest
 *
 * @package EmailServiceBundleTests\Unit\MessageBuilder\Impl\GenericMessageBuilder
 */
final class GenericContentAttachmentTest extends TestCase
{

    /**
     * @covers \EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder\GenericContentAttachment
     * @covers \EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder\GenericAttachmentAbstract
     * @covers \EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder\GenericAttachmentAbstract::getContentType
     * @covers \EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder\GenericAttachmentAbstract::getFilename
     * @covers \EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder\GenericContentAttachment::getContent
     */
    public function testAttachment(): void
    {
        $attachment = new GenericContentAttachment('content', 'type', 'filename');

        self::assertEquals('content', $attachment->getContent());
        self::assertEquals('type', $attachment->getContentType());
        self::assertEquals('filename', $attachment->getFilename());
    }

}
