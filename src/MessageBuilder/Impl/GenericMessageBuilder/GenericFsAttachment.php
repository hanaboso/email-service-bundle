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
     * @var string
     */
    private string $id;

    /**
     * GenericFsAttachment constructor.
     *
     * @param string      $id
     * @param string      $contentType
     * @param string|null $filename
     */
    public function __construct(string $id, string $contentType, ?string $filename = NULL)
    {
        parent::__construct($contentType, $filename);

        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

}
