<?php

namespace App\Domain\Payment\Service;

use App\Domain\Payment\Repository\PaymentRepository;

/**
 * Service.
 */
final class PaymentFinder
{
    private $repository;

    public function __construct(PaymentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findPayments(array $params): array
    {
        return $this->repository->findPayments($params);
    }
    
    public function findPaymentsForPayment(array $params): array
    {
        return $this->repository->findPaymentsForPayment($params);
    }
  
}
