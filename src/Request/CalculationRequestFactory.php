<?php

namespace ArvPayolutionApi\Request;

/**
 * Class CalculationRequestFactory
 */
class CalculationRequestFactory extends RequestFactoryAbstract
{
    /**
     * @return string
     */
    public static function getRequestVersion(): string
    {
        return self::API_VERSION_NUMBER_TWO;
    }

    /**
     * @param $context
     * @param TransactionAbstract $transaction
     *
     * @return mixed
     */
    public static function createRequest($context, TransactionAbstract $transaction)
    {
        return new RestApiRequest($transaction, 'PSP Name');
    }

    /**
     * @param $requestType
     * @param $paymentBrand
     * @param $data
     * @param $referenceId
     *
     * @return TransactionAbstract|PreCheckTransaction
     */
    public static function createTransaction($requestType, $paymentBrand, $data, $referenceId)
    {
        return CalculationTransactionFactory::create($requestType, $paymentBrand, $data, $referenceId);
    }
}
