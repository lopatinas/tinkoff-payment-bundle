<?php

namespace Lopatinas\TinkoffPaymentBundle\Service;

use Lopatinas\TinkoffPaymentBundle\Exception\TinkoffPaymentNotFoundHttpException;

class ApiService
{
    /** @var string */
    private $_apiUrl;

    /** @var string */
    private $_terminalKey;

    /** @var string */
    private $_secretKey;

    private $_response;

    /**
     * @param $apiUrl
     */
    public function setApiUrl($apiUrl)
    {
        $this->_apiUrl = $apiUrl;
    }

    /**
     * @param $terminalKey
     */
    public function setTerminalKey($terminalKey)
    {
        $this->_terminalKey = $terminalKey;
    }

    /**
     * @param $secretKey
     */
    public function setSecretKey($secretKey)
    {
        $this->_secretKey = $secretKey;
    }

    /**
     * Initialize the payment
     *
     * @param mixed $args mixed You could use associative array or url params string
     *
     * @return array
     */
    public function init($args)
    {
        return $this->buildQuery('Init', $args);
    }

    /**
     * Get state of payment
     *
     * @param mixed $args Can be associative array or string
     *
     * @return mixed
     */
    public function getState($args)
    {
        return $this->buildQuery('GetState', $args);
    }

    /**
     * Confirm 2-staged payment
     *
     * @param mixed $args Can be associative array or string
     *
     * @return mixed
     */
    public function confirm($args)
    {
        return $this->buildQuery('Confirm', $args);
    }

    /**
     * Performs recursive (re) payment - direct debiting of funds from the
     * account of the Buyer's credit card.
     *
     * @param mixed $args Can be associative array or string
     *
     * @return mixed
     */
    public function charge($args)
    {
        return $this->buildQuery('Charge', $args);
    }

    /**
     * Registers in the terminal buyer Seller. (Init do it automatically)
     *
     * @param mixed $args Can be associative array or string
     *
     * @return mixed
     */
    public function addCustomer($args)
    {
        return $this->buildQuery('AddCustomer', $args);
    }

    /**
     * Returns the data stored for the terminal buyer Seller.
     *
     * @param mixed $args Can be associative array or string
     *
     * @return mixed
     */
    public function getCustomer($args)
    {
        return $this->buildQuery('GetCustomer', $args);
    }

    /**
     * Deletes the data of the buyer.
     *
     * @param mixed $args Can be associative array or string
     *
     * @return mixed
     */
    public function removeCustomer($args)
    {
        return $this->buildQuery('RemoveCustomer', $args);
    }

    /**
     * Returns a list of bounded card from the buyer.
     *
     * @param mixed $args Can be associative array or string
     *
     * @return mixed
     */
    public function getCardList($args)
    {
        return $this->buildQuery('GetCardList', $args);
    }

    /**
     * Removes the customer's bounded card.
     *
     * @param mixed $args Can be associative array or string
     *
     * @return mixed
     */
    public function removeCard($args)
    {
        return $this->buildQuery('RemoveCard', $args);
    }

    /**
     * The method is designed to send all unsent notification
     *
     * @return mixed
     */
    public function resend()
    {
        return $this->buildQuery('Resend', []);
    }

    /**
     * Cancel payment
     *
     * @param array $args
     *
     * @return mixed
     */
    public function cancel($args)
    {
        return $this->buildQuery('Cancel', $args);
    }

    /**
     * Builds a query string and call sendRequest method.
     * Could be used to custom API call method.
     *
     * @param $path
     * @param $args
     * @return mixed
     */
    public function buildQuery($path, $args)
    {
        $url = $this->_apiUrl;
        if (is_array($args)) {
            if (! array_key_exists('TerminalKey', $args)) {
                $args['TerminalKey'] = $this->_terminalKey;
            }
            if (! array_key_exists('Token', $args)) {
                $args['Token'] = $this->_genToken($args);
            }
        }
        $url = $this->_combineUrl($url, $path);

        return $this->_sendRequest($url, $args);
    }

    /**
     * Generates token
     *
     * @param array $args array of query params
     *
     * @return string
     */
    private function _genToken($args)
    {
        $token = '';
        $args['Password'] = $this->_secretKey;
        ksort($args);
        foreach ($args as $arg) {
            $token .= $arg;
        }
        $token = hash('sha256', $token);

        return $token;
    }

    /**
     * Combines parts of URL. Simply gets all parameters and puts '/' between
     *
     * @return string
     */
    private function _combineUrl()
    {
        $args = func_get_args();
        $url = '';
        foreach ($args as $arg) {
            if (!is_string($arg)) {
                continue;
            }
            if ($arg[strlen($arg) - 1] !== '/') {
                $arg .= '/';
            }
            $url .= $arg;
        }

        return $url;
    }

    /**
     * Main method. Call API with params
     *
     * @param $apiUrl
     * @param $args
     * @return mixed
     */
    private function _sendRequest($apiUrl, $args)
    {
        if (is_array($args)) {
            $args = http_build_query($args);
        }

        $curl = curl_init();
        if (!$curl) {
            throw new TinkoffPaymentNotFoundHttpException(sprintf('Can not create connection to %s with args %s', $apiUrl, $args));
        }

        curl_setopt($curl, CURLOPT_URL, $apiUrl);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $args);
        $out = curl_exec($curl);

        curl_close($curl);

        return json_decode($out);
    }
}
