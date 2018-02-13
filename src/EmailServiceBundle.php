<?php declare(strict_types=1);

namespace EmailServiceBundle;

use EmailServiceBundle\DependencyInjection\Compiler\EmailServiceCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class EmailServiceBundle
 *
 * @package EmailServiceBundle
 */
class EmailServiceBundle extends Bundle
{

    public const KEY = 'email_service';

    /**
     * @param ContainerBuilder $containerBuilder
     */
    public function build(ContainerBuilder $containerBuilder): void
    {
        parent::build($containerBuilder);

        $containerBuilder->addCompilerPass(new EmailServiceCompilerPass());
    }

}