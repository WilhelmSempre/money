<?php
declare(strict_types = 1);

namespace WilhelmSempre\Money;

class Currency
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @var string|null
     */
    private ?string $currencySign;

    /**
     * @param string $name
     * @param string|null $currencySign
     */
    public function __construct(string $name, ?string $currencySign = null)
    {
        $this->name = $name;
        $this->currencySign = !empty($currencySign) ? $currencySign : null;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getCurrencySign(): string
    {
        return $this->currencySign ?? $this->name;
    }
}