<?php declare(strict_types=1);

namespace EmailServiceBundleTests\Controller;

use EmailServiceBundle\Controller\ApiController;
use EmailServiceBundle\Handler\MailHandler;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApiControllerTest
 *
 * @package EmailServiceBundleTests\Controller
 */
final class ApiControllerTest extends TestCase
{

    /**
     * @throws Exception
     */
    public function testSend(): void
    {
        /** @var MailHandler|MockObject $mailHandler */
        $mailHandler = $this->createMock(MailHandler::class);
        $controller  = new ApiController($mailHandler);
        $request     = new Request([], [], [], [], [], [], '{"abc": "def"}');

        $response = $controller->sendAction($request, 'generic');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('{"status":"OK"}', $response->getContent());
    }

    /**
     * @throws Exception
     */
    public function testSendTest(): void
    {
        /** @var MailHandler|MockObject $mailHandler */
        $mailHandler = $this->createMock(MailHandler::class);
        $controller  = new ApiController($mailHandler);
        $request     = new Request([], [], [], [], [], [], '{"abc": "def"}');

        $response = $controller->sendTestAction($request, 'generic');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('{"status":"OK"}', $response->getContent());
    }

}
