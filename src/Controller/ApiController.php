<?php declare(strict_types=1);

namespace EmailServiceBundle\Controller;

use EmailServiceBundle\Exception\MailerException;
use EmailServiceBundle\Handler\MailHandler;
use EmailServiceBundle\Traits\ControllerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

/**
 * Class ApiController
 *
 * @package EmailServiceBundle\Controller
 */
class ApiController extends AbstractController
{

    use ControllerTrait;

    /**
     * @var MailHandler
     */
    private $mailHandler;

    /**
     * ApiController constructor.
     *
     * @param MailHandler $mailHandler
     */
    public function __construct(MailHandler $mailHandler)
    {
        $this->mailHandler = $mailHandler;
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
            $this->mailHandler->send($handlerId, json_decode((string) $request->getContent(), TRUE));

            return $this->getResponse(['status' => 'OK']);
        } catch (ServiceNotFoundException | MailerException | Throwable $e) {
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
            $this->mailHandler->testSend($handlerId, json_decode((string) $request->getContent(), TRUE));

            return $this->getResponse(['status' => 'OK']);
        } catch (ServiceNotFoundException | MailerException| Throwable $e) {
            return $this->getErrorResponse($e);
        }
    }

}
