<?php

namespace Lopatinas\TinkoffPaymentBundle\Entity;

/**
 * Class Response
 * @package Lopatinas\TinkoffPaymentBundle\Entity
 */
class Response
{
    const STATUS_NEW = 'NEW';                           // Registered but not processed
    const STATUS_CANCELED = 'CANCELED';                 // Cancelled by merchant
    const STATUS_PREAUTHORIZING = 'PREAUTHORIZING';     // Check client payment data
    const STATUS_FORMSHOWED = 'FORMSHOWED';             // Client redirected to payment form
    const STATUS_AUTHORIZING = 'AUTHORIZING';           // Authentication started
    const STATUS_3DS_CHECKING = '3DS_CHECKING';         // 3-D Secure authentication started
    const STATUS_3DS_CHECKED = '3DS_CHECKED';           // 3-D Secure authentication finished
    const STATUS_AUTHORIZED = 'AUTHORIZED';             // Funds blocked
    const STATUS_REVERSING = 'REVERSING';               // Starting unblocking funds
    const STATUS_REVERSED = 'REVERSED';                 // Funds unblocked
    const STATUS_CONFIRMING = 'CONFIRMING';             // Start of debiting funds
    const STATUS_CONFIRMED = 'CONFIRMED';               // Funds are debited
    const STATUS_REFUNDING = 'REFUNDING';               // Start of refunding
    const STATUS_REFUNDED = 'REFUNDED';                 // Refunded
    const STATUS_PARTIAL_REFUNDED = 'PARTIAL_REFUNDED'; // Partial refunded
    const STATUS_REJECTED = 'REJECTED';                 // Rejected by bank
    const STATUS_UNKNOWN = 'UNKNOWN';                   // Unknown status

    /**
     * @var string $terminalKey Terminal Id
     */
    private $terminalKey;

    /**
     * @var int $amount Sum in kopeck (0.01 rub)
     */
    private $amount;

    /**
     * @var int $originalAmount
     */
    private $originalAmount;

    /**
     * @var int $newAmount
     */
    private $newAmount;

    /**
     * @var string $orderId Order id in merchant system
     */
    private $orderId;

    /**
     * @var boolean $success
     */
    private $success;

    /**
     * @var string $status
     */
    private $status;

    /**
     * @var int $paymentId
     */
    private $paymentId;

    /**
     * @var string $errorCode
     */
    private $errorCode = "0";

    /**
     * @var string $paymentUrl
     */
    private $paymentUrl;

    /**
     * @var string $message
     */
    private $message;

    /**
     * @var string $details
     */
    private $details;

    /**
     * Response constructor.
     * @param array $response
     */
    function __construct(array $response)
    {
        if (isset($response['TerminalKey'])) {
            $this->terminalKey = $response['TerminalKey'];
        }
        if (isset($response['Amount'])) {
            $this->amount = $response['Amount'];
        }
        if (isset($response['OriginalAmount'])) {
            $this->originalAmount = $response['OriginalAmount'];
        }
        if (isset($response['NewAmount'])) {
            $this->newAmount = $response['NewAmount'];
        }
        $this->orderId = $response['OrderId'];
        $this->success = $response['Success'];
        $this->status = $response['Status'];
        $this->paymentId = $response['PaymentId'];
        $this->errorCode = $response['ErrorCode'];
        if (isset($response['PaymentURL'])) {
            $this->paymentUrl = $response['PaymentURL'];
        }
        if (isset($response['Message'])) {
            $this->message = $response['Message'];
        }
        if (isset($response['Details'])) {
            $this->details = $response['Details'];
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
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return $this->success;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getPaymentId()
    {
        return $this->paymentId;
    }

    /**
     * @return string
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * @return string
     */
    public function getPaymentUrl()
    {
        return $this->paymentUrl;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @return int
     */
    public function getOriginalAmount()
    {
        return $this->originalAmount;
    }

    /**
     * @return int
     */
    public function getNewAmount()
    {
        return $this->newAmount;
    }
}
