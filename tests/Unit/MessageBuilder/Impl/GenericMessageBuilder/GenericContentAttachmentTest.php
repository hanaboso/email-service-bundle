<?php declare(strict_types=1);

namespace EmailServiceBundleTests\Unit\MessageBuilder\Impl\GenericMessageBuilder;

use EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder\GenericContentAttachment;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * Class GenericContentAttachmentTest
 *
 * @package EmailServiceBundleTests\Unit\MessageBuilder\Impl\GenericMessageBuilder
 */
#[CoversClass(GenericContentAttachment::class)]
final class GenericContentAttachmentTest extends TestCase
{

    /**
     * @return void
     */
    public function testAttachment(): void
    {
        $attachment = new GenericContentAttachment('content', 'type', 'filename');

        self::assertSame('content', $attachment->getContent());
        self::assertSame('type', $attachment->getContentType());
        self::assertSame('filename', $attachment->getFilename());
    }

}
