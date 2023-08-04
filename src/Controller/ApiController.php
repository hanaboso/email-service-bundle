<?php declare(strict_types=1);

namespace EmailServiceBundle\Controller;

use EmailServiceBundle\Handler\MailHandler;
use Hanaboso\Utils\String\Json;
use Hanaboso\Utils\Traits\ControllerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

/**
 * Class ApiController
 *
 * @package EmailServiceBundle\Controller
 */
final class ApiController extends AbstractController
{

    use ControllerTrait;

    /**
     * ApiController constructor.
     *
     * @param MailHandler $mailHandler
     */
    public function __construct(private MailHandler $mailHandler)
    {
    }

    /**
     * @Route("/mailer/{handlerId}/send", defaults={}, requirements={"_format"="json|xml"}, methods={"POST", "OPTIONS"})
     *
     * @param Request $request
     * @param string  $handlerId
     *
     * @return Response
     */
    public function sendAction(Request $request, string $handlerId): Response
    {
        try {
            $this->mailHandler->send($handlerId, Json::decode($request->getContent()));

            return $this->getResponse(['status' => 'OK']);
        } catch (Throwable $e) {
            return $this->getErrorResponse($e);
        }
    }

    /**
     * @Route("/mailer/{handlerId}/send/test", defaults={}, requirements={"_format"="json|xml"})
     *
     * @param Request $request
     * @param string  $handlerId
     *
     * @return Response
     */
    public function sendTestAction(Request $request, string $handlerId): Response
    {
        try {
            $this->mailHandler->testSend($handlerId, Json::decode($request->getContent()));

            return $this->getResponse(['status' => 'OK']);
        } catch (Throwable $e) {
            return $this->getErrorResponse($e);
        }
    }

}
