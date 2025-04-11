<?php declare(strict_types=1);

namespace EmailServiceBundle\Loader;

use EmailServiceBundle\Exception\MailerException;
use EmailServiceBundle\MessageBuilder\MessageBuilderInterface;
use Symfony\Component\DependencyInjection\ServiceLocator;

/**
 * Class MailBuildersLoader
 *
 * @package EmailServiceBundle\Loader
 */
final class MailBuildersLoader
{

    private const string BUILDER_PREFIX = 'mail_builder';

    /**
     * MailBuildersLoader constructor.
     *
     * @param ServiceLocator $locator
     */
    public function __construct(private ServiceLocator $locator)
    {
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
                MailerException::BUILDER_SERVICE_NOT_FOUND,
            );
        }

        return $authorization;
    }

}
