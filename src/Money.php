<?php
declare(strict_types = 1);

namespace WilhelmSempre\Money;

class Money
{
    public const CURRENCY_POSITION_LEFT = 'left';
    public const CURRENCY_POSITION_RIGHT = 'right';
    public const REMOVE_LEADING_ZEROS = 'remove_leading_zeros';
    public const DECIMALS = 'decimals';
    public const CURRENCY_POSITION = 'currency_position';

    private Currency $currency;
    private float $value;
    private array $flags = [
        self::REMOVE_LEADING_ZEROS => false,
        self::DECIMALS => 2,
        self::CURRENCY_POSITION => self::CURRENCY_POSITION_RIGHT,
    ];

    public function __construct(float $value, Currency $currency, array $flags = [])
    {
        $this->currency = $currency;
        $this->value = $value;
        $this->flags = array_merge($this->flags, $flags);
    }

    public function add(float $value): self
    {
        $this->value += $value;
        return $this;
    }

    public function subtract(float $value): self
    {
        $this->value -= $value;
        return $this;
    }

    public function multiply(float $value): self
    {
        $this->value *= $value;
        return $this;
    }

    public function divide(float $value): self
    {
        $this->value /= $value;
        return $this;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function getFormattedValue(): string
    {
        $money = number_format($this->value, $this->flags[self::DECIMALS]);

        if ($this->flags[self::REMOVE_LEADING_ZEROS] && $this->value == intval($this->value)) {
            $money = number_format($this->value);
        }

        switch ($this->flags[self::CURRENCY_POSITION]) {
            case self::CURRENCY_POSITION_LEFT:
                return $this->currency->getCurrencySign() . ' ' . $money;
            case self::CURRENCY_POSITION_RIGHT:
                return $money . ' ' . $this->currency->getCurrencySign();
        }

        return $money . ' ' . $this->currency->getCurrencySign();
    }
}
