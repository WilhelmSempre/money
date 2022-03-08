<?php
declare(strict_types = 1);

require_once 'vendor/autoload.php';

use WilhelmSempre\Money\Currency;
use WilhelmSempre\Money\Money;

ini_set('display_errors', '1');
error_reporting(E_ALL);

$currency = new Currency('USD', '$');
$productPrice = new Money(20, $currency);
$productPrice = $productPrice
    ->subtract(3)
    ->add(2)
    ->multiply(10);

echo $productPrice->getFormattedValue();
