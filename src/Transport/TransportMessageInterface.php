<?php declare(strict_types=1);

namespace EmailServiceBundle\Transport;

use EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder\GenericContentAttachment;
use EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder\GenericFsAttachment;

/**
 * Interface TransportMessageInterface
 *
 * @package App\Transport
 */
interface TransportMessageInterface
{

    /**
     * @return string
     */
    public function getFrom(): string;

    /**
     * @return string
     */
    public function getTo(): string;

    /**
     * @return string
     */
    public function getSubject(): string;

    /**
     * @return mixed
     */
    public function getDataContent();

    /**
     * @param string $content
     *
     * @return mixed
     */
    public function setContent(string $content);

    /**
     * @return string
     */
    public function getContent(): string;

    /**
     * @return string
     */
    public function getContentType(): string;

    /**
     * @return null|string
     */
    public function getTemplate(): ?string;

    /**
     * @return GenericContentAttachment[]
     */
    public function getContentAttachments(): array;

    /**
     * @param GenericContentAttachment $contentAttachment
     */
    public function addContentAttachment(GenericContentAttachment $contentAttachment): void;

    /**
     * @return GenericFsAttachment[]
     */
    public function getFileStorageAttachments(): array;

    /**
     * @param GenericFsAttachment $fileStorageAttachment
     */
    public function addFileStorageAttachment(GenericFsAttachment $fileStorageAttachment): void;

}
