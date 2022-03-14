<?php

use PHPUnit\Framework\TestCase;
use WilhelmSempre\Money\Percent;

class PercentTest extends TestCase
{
    /**
     * @return array[]
     */
    public function validPercentValues(): array
    {
        return [
            [5, 0.05],
            [20, 0.2],
            [40, 0.4],
            [25.5, 0.255],
        ];
    }

    /**
     * @dataProvider validPercentValues
     *
     * @param float $percent
     * @param float $expectedPercentValue
     *
     * @return void
     */
    public function testPercentValue(float $percent, float $expectedPercentValue)
    {
        $percent = new Percent($percent);
        $this->assertEquals($expectedPercentValue, $percent->getValue());
    }
}