<?php declare(strict_types=1);

namespace EmailServiceBundleTests\Unit\MessageBuilder\Impl\GenericMessageBuilder;

use EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder\GenericContentAttachment;
use EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder\GenericFsAttachment;
use EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder\GenericTransportMessage;
use Hanaboso\PhpCheckUtils\PhpUnit\Traits\CustomAssertTrait;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * Class GenericTransportMessageTest
 *
 * @package EmailServiceBundleTests\Unit\MessageBuilder\Impl\GenericMessageBuilder
 */
#[CoversClass(GenericTransportMessage::class)]
final class GenericTransportMessageTest extends TestCase
{

    use CustomAssertTrait;

    /**
     * @return void
     */
    public function testTransport(): void
    {
        $message = new GenericTransportMessage('sender@example.com', 'recipient@example.com', 'test', 'dataContent');
        $message->setContent('content');

        self::assertEquals('sender@example.com', $message->getFrom());
        self::assertEquals('recipient@example.com', $message->getTo());
        self::assertEquals('test', $message->getSubject());
        self::assertEquals('dataContent', $message->getDataContent());
        self::assertEquals('content', $message->getContent());
        self::assertEquals(NULL, $message->getTemplate());
        self::assertEquals('text/plain', $message->getContentType());

        $message->addFileStorageAttachment(new GenericFsAttachment('id', 'type', 'filename'));
        self::assertCount(1, $message->getFileStorageAttachments());

        $message->addContentAttachment(new GenericContentAttachment('content', 'type', 'filename'));
        self::assertCount(1, $message->getContentAttachments());
    }

}
