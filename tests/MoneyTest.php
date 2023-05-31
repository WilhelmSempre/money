<?php
declare(strict_types = 1);

use PHPUnit\Framework\TestCase;
use WilhelmSempre\Money\Currency;
use WilhelmSempre\Money\Exception\DivisionByZeroException;
use WilhelmSempre\Money\Money;

final class MoneyTest extends TestCase
{

    /**
     * @return array
     */
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
     *
     * @param float $value
     * @param float $addValue
     * @param float $addResult
     *
     * @return void
     */
    public function testMoneyAdd(float $value, float $addValue, float $addResult)
    {
        $currency = new Currency('USD', '$');
        $money = new Money($value, $currency);
        $money = $money->add($addValue);

        $this->assertEquals($addResult, $money->getValue());
    }

    /**
     * @return array
     */
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
     *
     * @param float $value
     * @param float $subtractValue
     * @param float $subtractResult
     *
     * @return void
     */
    public function testMoneySubtract(float $value, float $subtractValue, float $subtractResult)
    {
        $currency = new Currency('USD', '$');
        $money = new Money($value, $currency);
        $money = $money->subtract($subtractValue);

        $this->assertEquals($subtractResult, $money->getValue());
    }

    /**
     * @return array
     */
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
     *
     * @param float $value
     * @param float $multiplyValue
     * @param float $multiplyResult
     *
     * @return void
     */
    public function testMoneyMultiply(float $value, float $multiplyValue, float $multiplyResult)
    {
        $currency = new Currency('USD', '$');
        $money = new Money($value, $currency);
        $money = $money->multiply($multiplyValue);

        $this->assertEquals($multiplyResult, $money->getValue());
    }

    /**
     * @return array
     */
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
     *
     * @param float $value
     * @param float $divideValue
     * @param float $divideResult
     *
     * @return void
     * @throws DivisionByZeroException
     */
    public function testMoneyDivide(float $value, float $divideValue, float $divideResult)
    {
        $currency = new Currency('USD', '$');
        $money = new Money($value, $currency);
        $money = $money->divide($divideValue);

        $this->assertEquals($divideResult, $money->getValue());
    }

    /**
     * @return array[]
     */
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
     *
     * @param float $value
     * @param string $currencyName
     * @param string|null $currencySign
     * @param string $formattedMoney
     *
     * @return void
     */
    public function testMoneyWithZerosWithRightCurrencyFormat(float $value, string $currencyName, ?string $currencySign, string $formattedMoney)
    {
        $currency = new Currency($currencyName, $currencySign);
        $money = new Money($value, $currency);

        $this->assertEquals($formattedMoney, $money->getFormattedValue());
    }

    /**
     * @return array[]
     */
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
     *
     * @param float $value
     * @param string $currencyName
     * @param string|null $currencySign
     * @param string $formattedMoney
     *
     * @return void
     */
    public function testMoneyWithoutZerosWithRightCurrencyFormat(float $value, string $currencyName, ?string $currencySign, string $formattedMoney)
    {
        $currency = new Currency($currencyName, $currencySign);
        $money = new Money($value, $currency, [Money::REMOVE_LEADING_ZEROS => true]);

        $this->assertEquals($formattedMoney, $money->getFormattedValue());
    }

    /**
     * @return array[]
     */
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
     *
     * @param float $value
     * @param string $currencyName
     * @param string|null $currencySign
     * @param string $formattedMoney
     *
     * @return void
     */
    public function testMoneyWithZerosWithLeftCurrencyFormat(float $value, string $currencyName, ?string $currencySign, string $formattedMoney)
    {
        $currency = new Currency($currencyName, $currencySign);
        $money = new Money($value, $currency, [Money::CURRENCY_POSITION => Money::CURRENCY_POSITION_LEFT]);

        $this->assertEquals($formattedMoney, $money->getFormattedValue());
    }

    /**
     * @return array[]
     */
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
     *
     * @param float $value
     * @param string $currencyName
     * @param string|null $currencySign
     * @param string $formattedMoney
     *
     * @return void
     */
    public function testMoneyWithoutZerosWithLeftCurrencyFormat(float $value, string $currencyName, ?string $currencySign, string $formattedMoney)
    {
        $currency = new Currency($currencyName, $currencySign);
        $money = new Money($value, $currency, [Money::REMOVE_LEADING_ZEROS => true, Money::CURRENCY_POSITION => Money::CURRENCY_POSITION_LEFT]);

        $this->assertEquals($formattedMoney, $money->getFormattedValue());
    }

    /**
     * @return array[]
     */
    public function validMoneyWithZerosWithLeftNoSpaceCurrencyFormat(): array
    {
        return [
            [20, 'USD', '$', '$20.00'],
            [40, 'USD', '$', '$40.00'],
            [120, 'PLN', '', 'PLN120.00'],
            [250, 'PLN', 'PLN', 'PLN250.00'],
            [250, 'PLN', null, 'PLN250.00'],
        ];
    }

    /**
     * @dataProvider validMoneyWithZerosWithLeftNoSpaceCurrencyFormat
     *
     * @param float $value
     * @param string $currencyName
     * @param string|null $currencySign
     * @param string $formattedMoney
     *
     * @return void
     */
    public function testMoneyWithZerosWithLeftNoSpaceCurrencyFormat(float $value, string $currencyName, ?string $currencySign, string $formattedMoney)
    {
        $currency = new Currency($currencyName, $currencySign);
        $money = new Money($value, $currency, [Money::CURRENCY_POSITION => Money::CURRENCY_POSITION_LEFT_WITHOUT_SPACE]);

        $this->assertEquals($formattedMoney, $money->getFormattedValue());
    }

    /**
     * @return array[]
     */
    public function validMoneyWithZerosWithRightNoSpaceCurrencyFormat(): array
    {
        return [
            [20, 'USD', '$', '20.00$'],
            [40, 'USD', '$', '40.00$'],
            [120, 'PLN', 'zł', '120.00zł'],
            [120, 'PLN', '', '120.00PLN'],
            [250, 'PLN', 'PLN', '250.00PLN'],
            [250, 'PLN', null, '250.00PLN'],
        ];
    }

    /**
     * @dataProvider validMoneyWithZerosWithRightNoSpaceCurrencyFormat
     *
     * @param float $value
     * @param string $currencyName
     * @param string|null $currencySign
     * @param string $formattedMoney
     *
     * @return void
     */
    public function testMoneyWithZerosWithRightNoSpaceCurrencyFormat(float $value, string $currencyName, ?string $currencySign, string $formattedMoney)
    {
        $currency = new Currency($currencyName, $currencySign);
        $money = new Money($value, $currency, [Money::CURRENCY_POSITION => Money::CURRENCY_POSITION_RIGHT_WITHOUT_SPACE]);

        $this->assertEquals($formattedMoney, $money->getFormattedValue());
    }
}
