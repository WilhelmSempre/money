<?php

use PHPUnit\Framework\TestCase;
use WilhelmSempre\Money\Currency;
use WilhelmSempre\Money\Discount;
use WilhelmSempre\Money\Money;

class DiscountTest extends TestCase
{
    /**
     * @return array[]
     */
    public function validValueDiscountValues(): array
    {
        return [
            [200, 10, 190],
            [4500, 400, 4100],
            [40.50, 0.4, 40.1],
            [40, 40, 0],
        ];
    }

    /**
     * @dataProvider validValueDiscountValues
     *
     * @param float $value
     * @param float $discount
     * @param float $expectedDiscountValue
     *
     * @return void
     */
    public function testValueDiscountValue(float $value, float $discount, float $expectedDiscountValue)
    {
        $currency = new Currency('PLN', 'zł');
        $money = new Money($value, $currency);
        $discount = new Discount($money, $discount);

        $discount = $discount->computeDiscount();

        $this->assertEquals($expectedDiscountValue, $discount->getValue());
    }

    /**
     * @return array[]
     */
    public function validPercentDiscountValues(): array
    {
        return [
            [200, 10, 180],
            [4500, 50, 2250],
            [1000, 100, 0],
        ];
    }

    /**
     * @dataProvider validPercentDiscountValues
     *
     * @param float $value
     * @param float $percentDiscount
     * @param float $expectedDiscountValue
     *
     * @return void
     */
    public function testPercentDiscountValue(float $value, float $percentDiscount, float $expectedDiscountValue)
    {
        $currency = new Currency('PLN', 'zł');
        $money = new Money($value, $currency);
        $discount = new Discount($money, $percentDiscount, [Discount::DISCOUNT_TYPE => Discount::PERCENT]);

        $discount = $discount->computeDiscount();

        $this->assertEquals($expectedDiscountValue, $discount->getValue());
    }

    /**
     * @return array[]
     */
    public function invalidRangeDiscountValues(): array
    {
        return [
            [-1],
            [200],
            [-100],
            [1000],
        ];
    }

    /**
     * @dataProvider invalidRangeDiscountValues
     *
     * @param float $percent
     *
     * @return void
     */
    public function testThrowsExceptionWhenRangeInvalid(float $percent)
    {
        $this->expectException(RangeException::class);

        $currency = new Currency('PLN', 'zł');
        $money = new Money(100, $currency);
        new Discount($money, $percent, [Discount::DISCOUNT_TYPE => Discount::PERCENT]);
    }
}