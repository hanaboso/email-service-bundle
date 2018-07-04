<?php declare(strict_types=1);

namespace EmailServiceBundle\Loader;

use EmailServiceBundle\Exception\MailerException;
use EmailServiceBundle\MessageBuilder\MessageBuilderInterface;
use Symfony\Component\DependencyInjection\ServiceLocator;

/**
 * Class MailBuildersLoader
 *
 * @package App\Loader
 */
class MailBuildersLoader
{

    private const BUILDER_PREFIX = 'mail_builder';

    /**
     * @var ServiceLocator
     */
    private $locator;

    /**
     * MailBuildersLoader constructor.
     *
     * @param ServiceLocator $locator
     */
    public function __construct(ServiceLocator $locator)
    {
        $this->locator = $locator;
    }

    /**
     * @param string $builder
     *
     * @return MessageBuilderInterface
     * @throws MailerException
     */
    public function getBuilder(string $builder): MessageBuilderInterface
    {
        $name = sprintf('%s.%s', self::BUILDER_PREFIX, $builder);

        if ($this->locator->has($name)) {
            /** @var MessageBuilderInterface $authorization */
            $authorization = $this->locator->get($name);
        } else {
            throw new MailerException(
                sprintf('MailerBuilder for [%s] was not found.', $builder),
                MailerException::BUILDER_SERVICE_NOT_FOUND
            );
        }

        return $authorization;
    }

}