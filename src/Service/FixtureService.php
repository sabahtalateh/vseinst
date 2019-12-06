<?php

namespace App\Service;

use App\Currency\Currency;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Faker\Factory;

class FixtureService
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function generateProducts(int $count = 20): int
    {
        $faker = Factory::create();

        for ($i = 0; $i < $count; ++$i) {
            $adjective = $faker->randomElement(['Натуральный', 'Вертолётный', 'Самолётный', 'Колбасный']);
            $noun = $faker->randomElement(['Ботинок', 'Пароход', 'Журнал', 'Самолёт', 'Вертолёт', 'Пирожок']);
            $productName = "{$adjective} {$noun}";

            $priceInteger = $faker->numberBetween(10, 100);
            $priceDecimal = $faker->numberBetween(10, 99);

            $product = new Product();
            $product->setName($productName);
            $product->setPrice(new Currency($priceInteger, $priceDecimal));
            $this->productRepository->persist($product);
        }
        $this->productRepository->flush();

        return $count;
    }
}
