<?php

namespace App\Entity;

use App\Currency\Currency;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @ORM\Table(name="products")
 *
 * @JMS\ExclusionPolicy("all")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @JMS\Expose
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", name="name", length=1024, nullable=false)
     *
     * @JMS\Expose
     */
    protected $name;

    /**
     * @var int
     * @ORM\Column(type="integer", name="price_integer", nullable=false, options={"default": 0})
     */
    protected $priceInteger = 0;

    /**
     * @var int
     * @ORM\Column(type="integer", name="price_decimal", nullable=false, options={"default": 0})
     */
    protected $priceDecimal = 0;

    public function getId()
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setPrice(Currency $price)
    {
        $this->priceInteger = $price->getInteger();
        $this->priceDecimal = $price->getDecimal();
    }

    public function getPrice(): Currency
    {
        return new Currency($this->priceInteger, $this->priceDecimal);
    }

    /**
     * @JMS\VirtualProperty
     * @JMS\Type("string")
     * @JMS\SerializedName("price")
     */
    public function serializePrice(): string
    {
        return "{$this->priceInteger}.{$this->priceDecimal}";
    }
}
