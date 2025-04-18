<?php declare(strict_types=1);

namespace EmailServiceBundleTests\Controller;

use EmailServiceBundle\Controller\ApiController;
use EmailServiceBundle\Exception\MailerException;
use EmailServiceBundle\Handler\MailHandler;
use Exception;
use Monolog\Logger;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApiControllerTest
 *
 * @package EmailServiceBundleTests\Controller
 */
#[CoversClass(ApiController::class)]
final class ApiControllerTest extends TestCase
{

    /**
     * @throws Exception
     */
    public function testSend(): void
    {
        $mailHandler = $this->createMock(MailHandler::class);
        $controller  = new ApiController($mailHandler);
        $request     = new Request([], [], [], [], [], [], '{"abc": "def"}');

        $response = $controller->sendAction($request, 'generic');

        self::assertSame(200, $response->getStatusCode());
        self::assertEquals('{"status":"OK"}', $response->getContent());
    }

    /**
     * @throws Exception
     */
    public function testSendErr(): void
    {
        $mailHandler = $this->createPartialMock(MailHandler::class, ['send']);
        $mailHandler->expects(self::any())->method('send')->willThrowException(new MailerException());
        $controller = new ApiController($mailHandler);
        $controller->setLogger(new Logger('logger'));
        $request = new Request([], [], [], [], [], [], '{"abc": "def"}');

        $response = $controller->sendAction($request, 'generic');
        self::assertSame(500, $response->getStatusCode());
    }

    /**
     * @throws Exception
     */
    public function testSendTest(): void
    {
        $mailHandler = $this->createMock(MailHandler::class);
        $controller  = new ApiController($mailHandler);
        $request     = new Request([], [], [], [], [], [], '{"abc": "def"}');

        $response = $controller->sendTestAction($request, 'generic');

        self::assertSame(200, $response->getStatusCode());
        self::assertEquals('{"status":"OK"}', $response->getContent());
    }

    /**
     * @throws Exception
     */
    public function testSendTestErr(): void
    {
        $mailHandler = $this->createPartialMock(MailHandler::class, ['testSend']);
        $mailHandler->expects(self::any())->method('testSend')->willThrowException(new MailerException());
        $controller = new ApiController($mailHandler);
        $controller->setLogger(new Logger('logger'));
        $request = new Request([], [], [], [], [], [], '{"abc": "def"}');

        $response = $controller->sendTestAction($request, 'generic');
        self::assertSame(500, $response->getStatusCode());
    }

}
