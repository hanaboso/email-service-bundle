<?php declare(strict_types=1);

namespace Tests\Unit\Mailer;

use EmailServiceBundle\Mailer\Mailer;
use EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder;
use EmailServiceBundle\Transport\TransportInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;

/**
 * Class MailerTest
 *
 * @package Tests\Mailer
 */
class MailerTest extends TestCase
{

    /**
     * @covers Mailer::renderAndSend()
     */
    public function testSend(): void
    {
        /** @var TransportInterface|PHPUnit_Framework_MockObject_MockObject $transport */
        $transport = $this->createPartialMock(TransportInterface::class, ['send', 'setLogger']);
        $transport->method('send')->willReturn(1);
        $transport->method('setLogger')->willReturn(1);

        $data = [
            'from'    => 'valid@mail.com',
            'to'      => 'no-reply@test.com',
            'subject' => 'Subject',
            'content' => 'Content',
        ];

        $handler = new GenericMessageBuilder();

        $mailer = new Mailer($transport, NULL);
        $mailer->renderAndSend($handler->buildTransportMessage($data));
    }

    /**
     * @covers Mailer::renderAndSendTest()
     */
    public function testSendTest(): void
    {
        /** @var TransportInterface|PHPUnit_Framework_MockObject_MockObject $transport */
        $transport = $this->createPartialMock(TransportInterface::class, ['send', 'setLogger']);
        $transport->method('send')->willReturn(1);
        $transport->method('setLogger')->willReturn(1);

        $data = [
            'from'    => 'valid@mail.com',
            'to'      => 'no-reply@test.com',
            'subject' => 'Subject',
            'content' => 'Content',
        ];

        $handler = new GenericMessageBuilder();

        $mailer = new Mailer($transport, NULL);
        $mailer->renderAndSendTest($handler->buildTransportMessage($data));
    }

}