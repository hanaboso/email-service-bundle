<?php declare(strict_types=1);

namespace EmailServiceBundle\Loader;

use EmailServiceBundle\Exception\MailerException;
use EmailServiceBundle\MessageBuilder\MessageBuilderInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class MailBuildersLoader
 *
 * @package App\Loader
 */
class MailBuildersLoader
{

    private const BUILDER_PREFIX = 'mail_builder';

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * MailBuildersLoader constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $builder
     *
     * @return MessageBuilderInterface
     * @throws MailerException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getBuilder(string $builder): MessageBuilderInterface
    {

        $name = sprintf('%s.%s', self::BUILDER_PREFIX, $builder);

        if ($this->container->has($name)) {
            /** @var MessageBuilderInterface $authorization */
            $authorization = $this->container->get($name);
        } else {
            throw new MailerException(
                sprintf('MailerBuilder for [%s] was not found.', $builder),
                MailerException::BUILDER_SERVICE_NOT_FOUND
            );
        }

        return $authorization;

    }

}