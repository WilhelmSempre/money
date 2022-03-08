<?php
declare(strict_types = 1);

use PHPUnit\Framework\TestCase;
use WilhelmSempre\Money\Currency;
use WilhelmSempre\Money\Money;

final class MoneyTest extends TestCase
{
    public function validMoneyAddValues(): array
    {
        return [
            [20, 2, 22],
            [40, 10, 50],
            [120, 100, 220],
            [50.50, 0.50, 51],
            [12.80, 0.65, 13.45],
            [1235.80, 200.98, 1436.78],
        ];
    }

    /**
     * @dataProvider validMoneyAddValues
     */
    public function testMoneyAdd(float $value, float $addValue, float $addResult)
    {
        $currency = new Currency('USD', '$');
        $money = new Money($value, $currency);
        $money = $money->add($addValue);

        $this->assertEquals($addResult, $money->getValue());
    }

    public function validMoneySubtractValues(): array
    {
        return [
            [20, 2, 18],
            [40, 10, 30],
            [120, 100, 20],
            [50.50, 0.50, 50],
            [12.80, 0.65, 12.15],
            [1235.80, 200.98, 1034.82],
        ];
    }

    /**
     * @dataProvider validMoneySubtractValues
     */
    public function testMoneySubtract(float $value, float $subtractValue, float $subtractResult)
    {
        $currency = new Currency('USD', '$');
        $money = new Money($value, $currency);
        $money = $money->subtract($subtractValue);

        $this->assertEquals($subtractResult, $money->getValue());
    }

    public function validMoneyMultiplyValues(): array
    {
        return [
            [20, 2, 40],
            [40, 10, 400],
            [120, 100, 12000],
            [50.50, 0.50, 25.25],
            [12.80, 0.65, 8.32],
            [1235.80, 200.98, 248371.084],
        ];
    }

    /**
     * @dataProvider validMoneyMultiplyValues
     */
    public function testMoneyMultiply(float $value, float $multiplyValue, float $multiplyResult)
    {
        $currency = new Currency('USD', '$');
        $money = new Money($value, $currency);
        $money = $money->multiply($multiplyValue);

        $this->assertEquals($multiplyResult, $money->getValue());
    }

    public function validMoneyDivideValues(): array
    {
        return [
            [20, 2, 10],
            [40, 10, 4],
            [120, 6, 20],
            [50.50, 0.50, 101],
            [12.80, 0.65, 19.692307692307693],
            [1235.80, 200.98, 6.148870534381531],
        ];
    }

    /**
     * @dataProvider validMoneyDivideValues
     */
    public function testMoneyDivide(float $value, float $divideValue, float $divideResult)
    {
        $currency = new Currency('USD', '$');
        $money = new Money($value, $currency);
        $money = $money->divide($divideValue);

        $this->assertEquals($divideResult, $money->getValue());
    }

    public function validMoneyWithZerosWithRightCurrencyFormat(): array
    {
        return [
            [20, 'USD', '$', '20.00 $'],
            [40, 'USD', '$', '40.00 $'],
            [120, 'PLN', 'zł', '120.00 zł'],
            [120, 'PLN', '', '120.00 PLN'],
            [250, 'PLN', 'PLN', '250.00 PLN'],
            [250, 'PLN', null, '250.00 PLN'],
        ];
    }

    /**
     * @dataProvider validMoneyWithZerosWithRightCurrencyFormat
     */
    public function testMoneyWithZerosWithRightCurrencyFormat(float $value, string $currencyName, ?string $currencySign, string $formattedMoney)
    {
        $currency = new Currency($currencyName, $currencySign);
        $money = new Money($value, $currency);

        $this->assertEquals($formattedMoney, $money->getFormattedValue());
    }

    public function validMoneyWithoutZerosWithRightCurrencyFormat(): array
    {
        return [
            [20, 'USD', '$', '20 $'],
            [40, 'USD', '$', '40 $'],
            [120, 'PLN', 'zł', '120 zł'],
            [120, 'PLN', '', '120 PLN'],
            [250, 'PLN', 'PLN', '250 PLN'],
            [250, 'PLN', null, '250 PLN'],
        ];
    }

    /**
     * @dataProvider validMoneyWithoutZerosWithRightCurrencyFormat
     */
    public function testMoneyWithoutZerosWithRightCurrencyFormat(float $value, string $currencyName, ?string $currencySign, string $formattedMoney)
    {
        $currency = new Currency($currencyName, $currencySign);
        $money = new Money($value, $currency, [Money::REMOVE_LEADING_ZEROS => true]);

        $this->assertEquals($formattedMoney, $money->getFormattedValue());
    }

    public function validMoneyWithZerosWithLeftCurrencyFormat(): array
    {
        return [
            [20, 'USD', '$', '$ 20.00'],
            [40, 'USD', '$', '$ 40.00'],
            [120, 'PLN', '', 'PLN 120.00'],
            [250, 'PLN', 'PLN', 'PLN 250.00'],
            [250, 'PLN', null, 'PLN 250.00'],
        ];
    }

    /**
     * @dataProvider validMoneyWithZerosWithLeftCurrencyFormat
     */
    public function testMoneyWithZerosWithLeftCurrencyFormat(float $value, string $currencyName, ?string $currencySign, string $formattedMoney)
    {
        $currency = new Currency($currencyName, $currencySign);
        $money = new Money($value, $currency, [Money::CURRENCY_POSITION => Money::CURRENCY_POSITION_LEFT]);

        $this->assertEquals($formattedMoney, $money->getFormattedValue());
    }

    public function validMoneyWithoutZerosWithLeftCurrencyFormat(): array
    {
        return [
            [20, 'USD', '$', '$ 20'],
            [40, 'USD', '$', '$ 40'],
            [120, 'PLN', '', 'PLN 120'],
            [250, 'PLN', 'PLN', 'PLN 250'],
            [250, 'PLN', null, 'PLN 250'],
        ];
    }

    /**
     * @dataProvider validMoneyWithoutZerosWithLeftCurrencyFormat
     */
    public function testMoneyWithoutZerosWithLeftCurrencyFormat(float $value, string $currencyName, ?string $currencySign, string $formattedMoney)
    {
        $currency = new Currency($currencyName, $currencySign);
        $money = new Money($value, $currency, [Money::REMOVE_LEADING_ZEROS => true, Money::CURRENCY_POSITION => Money::CURRENCY_POSITION_LEFT]);

        $this->assertEquals($formattedMoney, $money->getFormattedValue());
    }
}
