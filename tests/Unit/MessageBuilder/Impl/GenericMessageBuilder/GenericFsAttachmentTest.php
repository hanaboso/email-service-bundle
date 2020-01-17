<?php declare(strict_types=1);

namespace EmailServiceBundleTests\Unit\MessageBuilder\Impl\GenericMessageBuilder;

use EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder\GenericFsAttachment;
use PHPUnit\Framework\TestCase;

/**
 * Class GenericFsAttachmentTest
 *
 * @package EmailServiceBundleTests\Unit\MessageBuilder\Impl\GenericMessageBuilder
 */
class GenericFsAttachmentTest extends TestCase
{

    /**
     * @covers \EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder\GenericFsAttachment
     * @covers \EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder\GenericFsAttachment::getId
     */
    public function testAttachment(): void
    {
        $attachment = new GenericFsAttachment('id', 'type', 'filename');

        self::assertEquals('id', $attachment->getId());
    }

}
