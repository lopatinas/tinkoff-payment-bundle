<?php

namespace Lopatinas\TinkoffPaymentBundle\Service;

use Lopatinas\TinkoffPaymentBundle\Entity\Order;
use Lopatinas\TinkoffPaymentBundle\Entity\Response;

class TinkoffPaymentService
{
    /**
     * @var ApiService
     */
    private $apiService;

    /**
     * TinkoffPaymentService constructor.
     * @param ApiService $apiService
     */
    function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * @param Order $order
     * @return Response
     */
    public function init(Order $order)
    {
        $response = $this->apiService->init($order->__toArray());
        return new Response($response);
    }

    /**
     * @param string $paymentId
     * @return Response
     */
    public function getState($paymentId)
    {
        $response = $this->apiService->getState(['PaymentId' => $paymentId]);
        return new Response($response);
    }

    /**
     * @param $paymentId
     * @param null $reason
     * @param null $amount
     * @return Response
     */
    public function cancel($paymentId, $reason = null, $amount = null)
    {
        $params['PaymentId'] = $paymentId;

        if (null !== $reason) {
            $params['Reason'] = $reason;
        }

        if (null !== $amount) {
            $params['Amount'] = $amount;
        }

        $response = $this->apiService->cancel($params);
        return new Response($response);
    }
}
