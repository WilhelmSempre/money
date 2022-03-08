<?php

use PHPUnit\Framework\TestCase;
use WilhelmSempre\Money\Currency;

class CurrencyTest extends TestCase
{

    /**
     * @return array
     */
    public function validNoSignValues(): array
    {
        return [
            ['USD', '', 'USD'],
            ['USD', null, 'USD'],
        ];
    }

    /**
     * @dataProvider validNoSignValues
     *
     * @param string $currencyName
     * @param string|null $currencySign
     * @param string $currencySignResult
     *
     * @return void
     */
    public function testCurrencyNoSign(string $currencyName, ?string $currencySign, string $currencySignResult)
    {
        $currency = new Currency($currencyName, $currencySign);
        $this->assertEquals($currencySignResult, $currency->getCurrencySign());
    }
}
