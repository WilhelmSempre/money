<?php

namespace WilhelmSempre\Money;

class Tax
{
    /**
     * @var Money
     */
    private Money $money;

    /**
     * @var Percent
     */
    private Percent $taxValue;

    /**
     * @param Money $money
     * @param float $taxValue
     */
    public function __construct(Money $money, float $taxValue)
    {
        $this->money = $money;
        $this->taxValue =  new Percent($taxValue);
    }

    /**
     * @return Money
     */
    public function computeTax(): Money
    {
        $value = $this->money->getValue();
        return $this->money->multiply(
            $this->taxValue->getValue()
        )->add($value);
    }
}