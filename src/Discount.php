<?php

namespace WilhelmSempre\Money;

class Discount
{
    public const PERCENT = 'percent';
    public const VALUE = 'value';
    public const DISCOUNT_TYPE = 'type';

    /**
     * @var Money
     */
    private Money $money;

    /**
     * @var float
     */
    private float $value;

    /**
     * @var array
     */
    private array $flags = [
        self::DISCOUNT_TYPE => self::VALUE,
    ];

    /**
     * @param Money $money
     * @param float $value
     * @param array $flags
     */
    public function __construct(Money $money, float $value, array $flags = [])
    {
        $this->money = $money;
        $this->value = $value;
        $this->flags = array_merge($this->flags, $flags);

        if ($this->flags[self::DISCOUNT_TYPE] === self::PERCENT) {
            if ($value < 0 || $value > 100) {
                throw new \RangeException('Discount value should be in [0-100] range!');
            }
        }
    }

    /**
     * @return Money
     */
    private function computeValueDiscount(): Money
    {
        return $this->money->subtract($this->value);
    }

    /**
     * @return Money
     */
    private function computePercentDiscount(): Money
    {
        $percent = new Percent($this->value);
        $value = $this->money->getValue();
        return $this->money->subtract($value * $percent->getValue());
    }

    /**
     * @return Money
     */
    public function computeDiscount(): Money
    {
        switch ($this->flags[self::DISCOUNT_TYPE]) {
            case self::VALUE:
                return $this->computeValueDiscount();
            case self::PERCENT:
                return $this->computePercentDiscount();
        }

        return $this->money;
    }
}