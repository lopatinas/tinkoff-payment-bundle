<?php

namespace Lopatinas\TinkoffPaymentBundle\Service;

use Lopatinas\TinkoffPaymentBundle\Entity\Order;
use Lopatinas\TinkoffPaymentBundle\Entity\Response;
use Lopatinas\TinkoffPaymentBundle\Exception\TinkoffPaymentRequestException;

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
        $result = $this->apiService->init($order->__toArray());
        $response = new Response($result);
        $this->checkErrors($response);
        return $response;
    }

    /**
     * @param string $paymentId
     * @return Response
     */
    public function getState($paymentId)
    {
        $result = $this->apiService->getState(['PaymentId' => $paymentId]);
        $response = new Response($result);
        $this->checkErrors($response);
        return $response;
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

        $result = $this->apiService->cancel($params);
        $response = new Response($result);
        $this->checkErrors($response);
        return $response;
    }

    /**
     * @param Response $response
     */
    private function checkErrors(Response $response)
    {
        if (!$response->isSuccess()) {
            $message = $response->getDetails() ? $response->getDetails() : $response->getMessage();
            throw new TinkoffPaymentRequestException($message, $response->getErrorCode());
        }
    }

    /**
     * @param $data
     * @param $token
     * @return bool
     */
    public function checkToken($data, $token)
    {
        return $this->apiService->checkToken($data, $token);
    }
}
