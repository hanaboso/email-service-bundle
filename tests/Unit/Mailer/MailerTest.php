<?php declare(strict_types=1);

namespace EmailServiceBundleTests\Unit\Mailer;

use EmailServiceBundle\Mailer\Mailer;
use EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder;
use EmailServiceBundle\Transport\TransportInterface;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class MailerTest
 *
 * @package EmailServiceBundleTests\Unit\Mailer
 */
final class MailerTest extends TestCase
{

    /**
     * @covers Mailer::renderAndSend()
     * @throws Exception
     */
    public function testSend(): void
    {
        /** @var TransportInterface|MockObject $transport */
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
        $mailer  = new Mailer($transport, NULL);
        $mailer->renderAndSend($handler->buildTransportMessage($data));
        self::assertTrue(TRUE);
    }

    /**
     * @covers Mailer::renderAndSendTest()
     * @throws Exception
     */
    public function testSendTest(): void
    {
        /** @var TransportInterface|MockObject $transport */
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
        $mailer  = new Mailer($transport, NULL);
        $mailer->renderAndSendTest($handler->buildTransportMessage($data));
        self::assertTrue(TRUE);
    }

}
