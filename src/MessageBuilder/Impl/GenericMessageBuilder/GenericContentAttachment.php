<?php declare(strict_types=1);

namespace EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder;

/**
 * Class GenericContentAttachment
 *
 * @package EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder
 */
final class GenericContentAttachment extends GenericAttachmentAbstract
{

    /**
     * GenericContentAttachment constructor.
     *
     * @param string $content
     * @param string $contentType
     * @param string $filename
     */
    public function __construct(private string $content, string $contentType, string $filename)
    {
        parent::__construct($contentType, $filename);
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

}
