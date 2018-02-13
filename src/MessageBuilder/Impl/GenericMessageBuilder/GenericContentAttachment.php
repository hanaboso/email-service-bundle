<?php declare(strict_types=1);

namespace EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder;

/**
 * Class GenericContentAttachment
 *
 * @package App\MessageBuilder\Impl\GenericMessageBuilder
 */
class GenericContentAttachment extends GenericAttachmentAbstract
{

    /**
     * @var string
     */
    private $content;

    /**
     * GenericContentAttachment constructor.
     *
     * @param string $content
     * @param string $contentType
     * @param string $filename
     */
    public function __construct(string $content, string $contentType, string $filename)
    {
        parent::__construct($contentType, $filename);

        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

}