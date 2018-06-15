<?php declare(strict_types=1);

namespace Tests\Unit\Transport\Impl;

use EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder\GenericContentAttachment;
use EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder\GenericFsAttachment;
use EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder\GenericTransportMessage;
use EmailServiceBundle\Transport\Impl\SwiftMailerTransport;
use Exception;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use Swift_Mailer;

/**
 * Class SwiftMailerTransportTest
 *
 * @package Tests\Unit\Transport\Impl
 */
final class SwiftMailerTransportTest extends TestCase
{

    /**
     * @throws Exception
     */
    public function testSend(): void
    {
        /** @var PHPUnit_Framework_MockObject_MockObject|Swift_Mailer $fakeMailer */
        $fakeMailer = $this->createPartialMock(Swift_Mailer::class, ['send']);
        $fakeMailer->method('send')->willReturn(1);

        /** @var PHPUnit_Framework_MockObject_MockObject|Logger $logger */
        $logger = $this->createPartialMock(Logger::class, ['info']);
        $logger->method('info')->willReturn(1);

        $attach1 = new GenericContentAttachment('hello', 'text/plain', 'hello.txt');
        $attach2 = new GenericFsAttachment('123abc', 'text/plain', 'hello.txt');

        $message = new GenericTransportMessage('no-reply@test.com', 'no-reply@test.com', 'Subject', 'Content');
        $message->addContentAttachment($attach1);
        $message->addFileStorageAttachment($attach2);

        $mailer = new SwiftMailerTransport($fakeMailer);
        $mailer->setLogger($logger);
        $mailer->send($message);
    }

}
