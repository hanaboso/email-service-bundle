<?php declare(strict_types=1);

namespace EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder;

/**
 * Class GenericAttachmentAbstract
 *
 * @package EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder
 */
abstract class GenericAttachmentAbstract
{

    /**
     * GenericAttachmentAbstract constructor.
     *
     * @param string      $contentType
     * @param string|null $filename
     */
    public function __construct(private string $contentType, private ?string $filename = NULL)
    {
    }

    /**
     * @return string
     */
    public function getContentType(): string
    {
        return $this->contentType;
    }

    /**
     * @return string|null
     */
    public function getFilename(): ?string
    {
        return $this->filename;
    }

}
