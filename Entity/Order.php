<?php

namespace Lopatinas\TinkoffPaymentBundle\Entity;

/**
 * Class Order
 * @package Lopatinas\TinkoffPaymentBundle\Entity
 */
class Order
{
    public static $availableLanguages = [
        'ru',
        'en',
    ];

    /**
     * @var string $terminalKey Terminal Id
     */
    private $terminalKey;

    /**
     * @var int $amount Sum in kopeck (0.01 rub)
     */
    private $amount;

    /**
     * @var string $orderId Order id in merchant system
     */
    private $orderId;

    /**
     * @var string $paymentId Payment id in payment system
     */
    private $paymentId;

    /**
     * @var string $description Short payment description
     */
    private $description;

    /**
     * @var bool $recurrent Is recurrent payment or not
     */
    private $recurrent = false;

    /**
     * @var string $customerKey Client Id
     */
    private $customerKey;

    /**
     * @var string $data Additional payment params
     */
    private $data;

    /**
     * @var string $language Payment form language, default: 'ru'
     */
    private $language = 'ru';

    /**
     * @var Receipt|null $receipt Receipt object
     */
    private $receipt = null;

    /**
     * Order constructor.
     * @param null $orderId
     * @param null $amount
     * @param null $data
     * @param null $description
     * @param Receipt|null $receipt
     */
    public function __construct($orderId = null, $amount = null, $data = null, $description = null, Receipt $receipt = null)
    {
        if (null !== $orderId) {
            $this->orderId = $orderId;
        }
        if (null !== $amount) {
            $this->amount = $amount;
        }
        if (null !== $data) {
            $this->data = $data;
        }
        if (null !== $description) {
            $this->description = $description;
        }
        if (null !== $receipt) {
            $this->receipt = $receipt;
        }
    }

    /**
     * @return string
     */
    public function getTerminalKey()
    {
        return $this->terminalKey;
    }

    /**
     * @param $terminalKey
     * @return Order
     */
    public function setTerminalKey($terminalKey)
    {
        $this->terminalKey = $terminalKey;
        return $this;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param $amount
     * @return Order
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return string
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param $orderId
     * @return Order
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param $description
     * @return Order
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param $data
     * @return Order
     */
    public function setData($data)
    {
        if (!is_array($data)) {
            $data = json_decode($data);
        }
        $this->data = $data;
        return $this;
    }

    public function __toArray()
    {
        $order = [
            'Amount'    => $this->amount,
            'OrderId'   => $this->orderId,
            'Language'  => $this->language,
            'DATA'      => json_encode($this->data),
        ];

        if (null !== $this->terminalKey) {
            $order['TerminalKey'] = $this->terminalKey;
        }

        if (null !== $this->description) {
            $order['Description'] = $this->description;
        }

        if ($this->recurrent){
            $order['Recurrent'] = 'Y';
        }

        if (null !== $this->customerKey) {
            $order['CustomerKey'] = $this->customerKey;
        }

        if (null !== $this->receipt) {
            $order['Receipt'] = json_encode($this->receipt->__toArray());
        }

        return $order;
    }

    /**
     * @param $email
     * @return Order
     */
    public function setEmail($email)
    {
        $this->data['Email'] = $email;

        return $this;
    }

    /**
     * @param $phone
     * @return Order
     */
    public function setPhone($phone)
    {
        $this->data['Phone'] = $phone;

        return $this;
    }

    /**
     * @return bool
     */
    public function getRecurrent()
    {
        return $this->recurrent;
    }

    /**
     * @param bool $recurrent
     * @return Order
     */
    public function setRecurrent($recurrent)
    {
        $this->recurrent = $recurrent;
        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerKey()
    {
        return $this->customerKey;
    }

    /**
     * @param $customerKey
     * @return Order
     */
    public function setCustomerKey($customerKey)
    {
        $this->customerKey = $customerKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param $language
     * @return Order
     */
    public function setLanguage($language)
    {
        if (in_array($language, self::$availableLanguages)) {
            $this->language = $language;
        }
        return $this;
    }

    /**
     * @return Receipt|null
     */
    public function getReceipt()
    {
        return $this->receipt;
    }

    /**
     * @param Receipt $receipt
     * @return Order
     */
    public function setReceipt(Receipt $receipt)
    {
        $this->receipt = $receipt;

        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentId(): string
    {
        return $this->paymentId;
    }

    /**
     * @param string $paymentId
     * @return Order
     */
    public function setPaymentId(string $paymentId)
    {
        $this->paymentId = $paymentId;

        return $this;
    }
}
