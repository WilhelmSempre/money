<?php
declare(strict_types = 1);

namespace WilhelmSempre\Money;

class Currency
{
    private string $name;
    private ?string $currencySign;

    public function __construct(string $name, ?string $currencySign = null)
    {
        $this->name = $name;
        $this->currencySign = !empty($currencySign) ? $currencySign : null;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCurrencySign(): string
    {
        return $this->currencySign ?? $this->name;
    }
}