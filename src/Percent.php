<?php

namespace WilhelmSempre\Money;

class Percent
{
    private float $value;

    /**
     * @param float $value
     */
    public function __construct(float $value)
    {
        $this->value = $value;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value / 100;
    }

    public function getFormattedValue(): string
    {
        return $this->value . '%';
    }
}