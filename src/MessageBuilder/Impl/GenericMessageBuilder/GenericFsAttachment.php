<?php declare(strict_types=1);

namespace EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder;

/**
 * Class GenericFsAttachment
 *
 * @package EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder
 */
final class GenericFsAttachment extends GenericAttachmentAbstract
{

    /**
     * GenericFsAttachment constructor.
     *
     * @param string      $id
     * @param string      $contentType
     * @param string|null $filename
     */
    public function __construct(private string $id, string $contentType, ?string $filename = NULL)
    {
        parent::__construct($contentType, $filename);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

}
