<?php

namespace Lopatinas\TinkoffPaymentBundle\Entity;

class Receipt
{
    public static $taxationList = [
        "osn"                   => "Общая СН",
        "usn_income"            => "Упрощенная СН (доходы)",
        "usn_income_outcome"    => "Урощенная СН (доходы минус расходы)",
        "envd"                  => "Единый налог на вмененный доход",
        "esn"                   => "Единый сельскохозяйственный налог",
        "patent"                => "Патентная СН",
    ];

    /**
     * @var Item[]|array
     */
    private $items = [];

    /**
     * @var string
     */
    private $email = '';

    /**
     * @var string
     */
    private $phone = '';

    /**
     * @var string
     */
    private $taxation = 'usn_income_outcome';

    /**
     * @return array
     */
    public function __toArray(): array
    {
        $receipt = [
            'Items'     => [],
            'Email'     => $this->email,
            'Taxation'  => $this->taxation,
        ];

        if (!empty($this->phone)) {
            $receipt['Phone'] = $this->phone;
        }

        foreach ($this->items as $item) {
            $receipt['Items'][] = $item->__toArray();
        }

        return $receipt;
    }

    /**
     * @param string $email
     * @return Receipt
     */
    public function setEmail(string $email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $phone
     * @return Receipt
     */
    public function setPhone(string $phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $taxation
     * @return Receipt
     */
    public function setTaxation(string $taxation)
    {
        if (!isset(self::$taxationList[$taxation])) {
            throw new \InvalidArgumentException('Wrong taxation');
        }

        $this->taxation = $taxation;

        return $this;
    }

    /**
     * @return string
     */
    public function getTaxation(): string
    {
        return $this->taxation;
    }

    /**
     * @return array|Item[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param Item $item
     * @return Receipt
     */
    public function addItem(Item $item)
    {
        $this->items[] = $item;

        return $this;
    }
}
