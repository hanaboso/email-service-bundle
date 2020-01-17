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
     * @var string
     */
    private $contentType;

    /**
     * @var string|null
     */
    private $filename;

    /**
     * GenericAttachmentAbstract constructor.
     *
     * @param string      $contentType
     * @param string|null $filename
     */
    public function __construct(string $contentType, ?string $filename = NULL)
    {
        $this->contentType = $contentType;
        $this->filename    = $filename;
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
