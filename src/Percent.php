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
        $this->value = $value / 100;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }
}