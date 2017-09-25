<?php

namespace Lopatinas\TinkoffPaymentBundle\Entity;

class Item
{
    public static $taxesList = [
        "none"      => "Без НДС",
        "vat0"      => "НДС по ставке 0%",
        "vat10"     => "НДС чека по ставке 10%",
        "vat18"     => "НДС чека по ставке 18%",
        "vat110"    => "НДС чека по расчетной ставке 10/110",
        "vat118"    => "НДС чека по расчетной ставке 18/118",
    ];

    /**
     * @var string
     */
    private $name = '';

    /**
     * @var integer
     */
    private $price = 0;

    /**
     * @var integer
     */
    private $quantity = 0;

    /**
     * @var integer
     */
    private $amount = 0;

    /**
     * @var string
     */
    private $tax = 'vat18';

    /**
     * @var string
     */
    private $ean13 = '';

    /**
     * @var string
     */
    private $shopCode = '';

    public function __toArray(): array
    {
        $item = [
            'Name'      => $this->name,
            'Price'     => $this->price,
            'Quantity'  => $this->quantity,
            'Amount'    => $this->amount,
            'Tax'       => $this->tax,
        ];

        if (!empty($this->ean13)) {
            $item['Ean13'] = $this->ean13;
        }

        if (!empty($this->shopCode)) {
            $item['ShopCode'] = $this->shopCode;
        }

        return $item;
    }

    /**
     * @param string $name
     * @return Item
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param $price
     * @return Item
     */
    public function setPrice(int $price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return integer
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param $quantity
     * @return Item
     */
    public function setQuantity(int $quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return integer
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $amount
     * @return Item
     */
    public function setAmount(int $amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param string $tax
     * @return Item
     */
    public function setTax(string $tax)
    {
        if (!isset(self::$taxesList[$tax])) {
            throw new \InvalidArgumentException('Wrong taxation');
        }

        $this->tax = $tax;

        return $this;
    }

    /**
     * @return string
     */
    public function getTax(): string
    {
        return $this->tax;
    }

    /**
     * @param string $ean13
     * @return Item
     */
    public function setEan13(string $ean13)
    {
        $this->ean13 = $ean13;

        return $this;
    }

    /**
     * @return string
     */
    public function getEan13(): string
    {
        return $this->ean13;
    }

    /**
     * @param string $shopCode
     * @return Item
     */
    public function setShopCode(string $shopCode)
    {
        $this->shopCode = $shopCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getShopCode()
    {
        return $this->shopCode;
    }
}
