<?php

namespace App\Entity;

use App\Currency\Currency;
use App\Enum\OrderProcessStatus;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @ORM\Table(name="orders")
 *
 * @JMS\ExclusionPolicy("all")
 */
class Order
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
     *
     * @ORM\Column(name="process_status", type="string", length=255, nullable=false, options={"default": OrderProcessStatus::NEW})
     *
     * @JMS\Expose
     */
    protected $processStatus = OrderProcessStatus::NEW;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="Product")
     * @ORM\JoinTable(
     *      name="orderd_products",
     *      joinColumns={@ORM\JoinColumn(name="order_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     *
     * @JMS\Expose
     */
    protected $products;

    /**
     * @var int
     * @ORM\Column(type="integer", name="total_integer", nullable=false, options={"default": 0})
     */
    protected $totalInteger = 0;

    /**
     * @var int
     * @ORM\Column(type="integer", name="total_decimal", nullable=false, options={"default": 0})
     */
    protected $totalDecimal = 0;

    /**
     * Order constructor.
     */
    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getProcessStatus(): OrderProcessStatus
    {
        return new OrderProcessStatus($this->processStatus);
    }

    public function isNew()
    {
        return $this->processStatus === OrderProcessStatus::NEW;
    }

    public function isPayed()
    {
        return $this->processStatus === OrderProcessStatus::PAYED;
    }

    public function setProcessStatus(OrderProcessStatus $processStatus): void
    {
        $this->processStatus = $processStatus->getValue();
    }

    /**
     * @return Collection<Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    /**
     * @param Collection<Product> $products
     */
    public function setProducts(Collection $products): void
    {
        $this->products = $products;
    }

    public function setTotal(Currency $price)
    {
        $this->totalInteger = $price->getInteger();
        $this->totalDecimal = $price->getDecimal();
    }

    public function getTotal(): Currency
    {
        return new Currency($this->totalInteger, $this->totalDecimal);
    }

    /**
     * @JMS\VirtualProperty
     * @JMS\Type("string")
     * @JMS\SerializedName("total")
     */
    public function serializeTotal(): string
    {
        return "{$this->totalInteger}.{$this->totalDecimal}";
    }
}
