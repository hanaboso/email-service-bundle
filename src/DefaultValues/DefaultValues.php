<?php declare(strict_types=1);

namespace EmailServiceBundle\DefaultValues;

/**
 * Class DefaultValues
 *
 * @package EmailServiceBundle\DefaultValues
 */
class DefaultValues
{

    /**
     * DefaultValues constructor.
     *
     * @param mixed[] $from
     * @param mixed[] $subject
     * @param mixed[] $to
     * @param mixed[] $bcc
     */
    public function __construct(
        protected array $from = [],
        protected array $subject = [],
        protected array $to = [],
        protected array $bcc = [],
    )
    {
    }

    /**
     * @param string $module
     *
     * @return string|null
     */
    public function getFrom(string $module): ?string
    {
        if (array_key_exists($module, $this->from)) {
            return $this->from[$module];
        }

        return NULL;
    }

    /**
     * @param string $module
     *
     * @return string|null
     */
    public function getSubject(string $module): ?string
    {
        if (array_key_exists($module, $this->subject)) {
            return $this->subject[$module];
        }

        return NULL;
    }

    /**
     * @param string $module
     *
     * @return string|null
     */
    public function getTo(string $module): ?string
    {
        if (array_key_exists($module, $this->to)) {
            return $this->to[$module];
        }

        return NULL;
    }

    /**
     * @param string $module
     *
     * @return string|null
     */
    public function getBcc(string $module): ?string
    {
        if (array_key_exists($module, $this->bcc)) {
            return $this->bcc[$module];
        }

        return NULL;
    }

    /**
     * @param string $module
     *
     * @return mixed[]
     */
    public function getDefaults(string $module): array
    {
        return [
            'from' => $this->getFrom($module),
            'subject' => $this->getSubject($module),
            'to' => $this->getTo($module),
            'bcc' => $this->getBcc($module),
        ];
    }

    /**
     * @param mixed[] $data
     * @param mixed[] $defaults
     * @param mixed[] $fields
     *
     * @return mixed[]
     */
    public static function handleDefaults(
        array $data,
        array $defaults,
        array $fields = ['from', 'subject', 'to', 'bcc'],
    ): array
    {
        foreach ($fields as $field) {
            if ((!array_key_exists($field, $data) || empty($data[$field])) && $defaults[$field]) {
                $data[$field] = $defaults[$field];
            }
        }

        return $data;
    }

}
