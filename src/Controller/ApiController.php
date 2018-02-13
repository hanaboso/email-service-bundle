<?php declare(strict_types=1);

namespace EmailServiceBundle\Controller;

use EmailServiceBundle\Exception\MailerException;
use EmailServiceBundle\Handler\MailHandler;
use EmailServiceBundle\MessageBuilder\MessageBuilderException;
use EmailServiceBundle\Traits\ControllerTrait;
use EmailServiceBundle\Transport\TransportException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ApiController
 *
 * @package App\Controller
 */
class ApiController extends Controller
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
     * @Route("/mailer/{handlerId}/send", defaults={}, requirements={"_format"="json|xml"})
     * @Method({"POST", "OPTIONS"})
     *
     * @param Request $request
     * @param string  $handlerId
     *
     * @return Response
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function sendAction(Request $request, string $handlerId): Response
    {
        try {
            $this->mailHandler->send($handlerId, $request->request->all());

            return $this->getResponse(['status' => 'OK']);
        } catch (ServiceNotFoundException | MessageBuilderException | TransportException | MailerException $e) {
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
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function sendTestAction(Request $request, string $handlerId): Response
    {
        try {
            $this->mailHandler->testSend($handlerId, json_decode($request->getContent(), TRUE));

            return $this->getResponse(['status' => 'OK']);
        } catch (ServiceNotFoundException | MessageBuilderException | TransportException | MailerException $e) {
            return $this->getErrorResponse($e);
        }
    }

}
