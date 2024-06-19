<?php declare(strict_types=1);

namespace EmailServiceBundleTests\Unit\MessageBuilder\Impl\GenericMessageBuilder;

use EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder\GenericFsAttachment;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * Class GenericFsAttachmentTest
 *
 * @package EmailServiceBundleTests\Unit\MessageBuilder\Impl\GenericMessageBuilder
 */
#[CoversClass(GenericFsAttachment::class)]
final class GenericFsAttachmentTest extends TestCase
{

    /**
     * @return void
     */
    public function testAttachment(): void
    {
        $attachment = new GenericFsAttachment('id', 'type', 'filename');

        self::assertEquals('id', $attachment->getId());
    }

}
