<?php

namespace App\Domain\Payment\Service;

use App\Domain\Payment\Repository\PaymentRepository;
use App\Factory\ValidationFactory;
use Cake\Validation\Validator;
use Selective\Validation\Exception\ValidationException;

final class PaymentValidator
{
    private $repository;
    private $validationFactory;

    public function __construct(PaymentRepository $repository, ValidationFactory $validationFactory)
    {
        $this->repository = $repository;
        $this->validationFactory = $validationFactory;
    }

    private function createValidator(): Validator
    {
        $validator = $this->validationFactory->createValidator();

        return $validator
            ->notEmptyString('user_id', 'Input required')
            ->notEmptyString('status', 'Input required')
            ->notEmptyString('room_id', 'Input required');
    }
    public function validatePayment(array $data): void
    {
        $validator = $this->createValidator();

        $validationResult = $this->validationFactory->createResultFromErrors(
            $validator->validate($data)
        );

        if ($validationResult->fails()) {
            throw new ValidationException('Please check your input', $validationResult);
        }
    }

    public function validatePaymentUpdate(string $customer_name, array $data): void
    {
        /*
        if (!$this->repository->existsPaymentNo($customerNo)) {
            throw new ValidationException(sprintf('Store not found: %s', $stocustomerNoreId));
        }
        */
        $this->validatePayment($data);
    }
    public function validatePaymentInsert( array $data): void
    {
        $this->validatePayment($data);
    }
}
