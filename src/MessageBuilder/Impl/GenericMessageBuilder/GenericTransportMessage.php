<?php declare(strict_types=1);

namespace EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder;

use EmailServiceBundle\Enum\ContentTypeEnum;
use EmailServiceBundle\Transport\TransportMessageInterface;

/**
 * Class GenericTransportMessage
 *
 * @package EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder
 */
class GenericTransportMessage implements TransportMessageInterface
{

    /**
     * @var string
     */
    private string $content = '';

    /**
     * @var GenericContentAttachment[]
     */
    private array $contentAttachments = [];

    /**
     * @var GenericFsAttachment[]
     */
    private array $fileStorageAttachments = [];

    /**
     * GenericTransportMessage constructor.
     *
     * @param string      $from
     * @param string      $to
     * @param string      $subject
     * @param string      $dataContent
     * @param string|null $template
     */
    public function __construct(
        private string $from,
        private string $to,
        private string $subject,
        private string $dataContent,
        private ?string $template = NULL,
    )
    {
        if (!$template) {
            $this->content = $dataContent;
        }
    }

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @return string
     */
    public function getTo(): string
    {
        return $this->to;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @return string|mixed[]
     */
    public function getDataContent(): string|array
    {
        return $this->template ? ['content' => $this->dataContent] : $this->dataContent;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return string|null
     */
    public function getTemplate(): ?string
    {
        return $this->template;
    }

    /**
     * @return string
     */
    public function getContentType(): string
    {
        return $this->template ? ContentTypeEnum::HTML->value : ContentTypeEnum::PLAIN->value;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return GenericContentAttachment[]
     */
    public function getContentAttachments(): array
    {
        return $this->contentAttachments;
    }

    /**
     * @param GenericContentAttachment $contentAttachment
     */
    public function addContentAttachment(GenericContentAttachment $contentAttachment): void
    {
        $this->contentAttachments[] = $contentAttachment;
    }

    /**
     * @return GenericFsAttachment[]
     */
    public function getFileStorageAttachments(): array
    {
        return $this->fileStorageAttachments;
    }

    /**
     * @param GenericFsAttachment $fileStorageAttachment
     */
    public function addFileStorageAttachment(GenericFsAttachment $fileStorageAttachment): void
    {
        $this->fileStorageAttachments[] = $fileStorageAttachment;
    }

}
