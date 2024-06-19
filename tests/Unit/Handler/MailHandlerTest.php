<?php declare(strict_types=1);

namespace EmailServiceBundleTests\Unit\Handler;

use EmailServiceBundle\Handler\MailHandler;
use EmailServiceBundle\Loader\MailBuildersLoader;
use EmailServiceBundle\Mailer\Mailer;
use EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder;
use EmailServiceBundle\Transport\Impl\SymfonyMailerTransport;
use Exception;
use Hanaboso\PhpCheckUtils\PhpUnit\Traits\CustomAssertTrait;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * Class MailHandlerTest
 *
 * @package EmailServiceBundleTests\Unit\Handler
 */
#[CoversClass(MailHandler::class)]
final class MailHandlerTest extends TestCase
{

    use CustomAssertTrait;

    /**
     * @throws Exception
     */
    public function testSend(): void
    {
        $transport = self::createPartialMock(SymfonyMailerTransport::class, ['send']);
        $transport->method('send');
        $mailer        = new Mailer($transport);
        $builderLoader = self::createPartialMock(MailBuildersLoader::class, ['getBuilder']);
        $builderLoader->expects(self::any())->method('getBuilder')->willReturn(new GenericMessageBuilder());
        $handler = new MailHandler($mailer, $builderLoader);

        $handler->send(
            '1',
            [
                'dataContent' => ['content'],
                'from'        => 'sender@gmail.com',
                'subject' => 'example',
                'to' => 'recipient@gmail.com',
            ],
        );

        self::assertFake();
    }

    /**
     * @throws Exception
     */
    public function testTestSend(): void
    {
        $transport = self::createPartialMock(SymfonyMailerTransport::class, ['send']);
        $transport->method('send');
        $mailer        = new Mailer($transport);
        $builderLoader = self::createPartialMock(MailBuildersLoader::class, ['getBuilder']);
        $builderLoader->expects(self::any())->method('getBuilder')->willReturn(new GenericMessageBuilder());
        $handler = new MailHandler($mailer, $builderLoader);

        $handler->testSend(
            '1',
            [
                'dataContent' => ['content'],
                'from'        => 'sender@gmail.com',
                'subject' => 'example',
                'to' => 'recipient@gmail.com',
            ],
        );

        self::assertFake();
    }

}
