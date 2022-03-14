<?php

use PHPUnit\Framework\TestCase;
use WilhelmSempre\Money\Currency;
use WilhelmSempre\Money\Money;
use WilhelmSempre\Money\Tax;

class TaxTest extends TestCase
{
    /**
     * @return array[]
     */
    public function validTaxValues(): array
    {
        return [
            [100, 23, 123],
            [200, 23, 246],
            [40, 8, 43.2],
            [25, 100, 50],
        ];
    }

    /**
     * @dataProvider validTaxValues
     *
     * @param float $value
     * @param float $tax
     * @param float $expectedValue
     *
     * @return void
     */
    public function testTaxValue(float $value, float $tax, float $expectedValue)
    {
        $currency = new Currency('PLN', 'zł');
        $money = new Money($value, $currency);
        $tax = new Tax($money, $tax);

        $tax = $tax->computeTax();

        $this->assertEquals($expectedValue, $tax->getValue());
    }
}