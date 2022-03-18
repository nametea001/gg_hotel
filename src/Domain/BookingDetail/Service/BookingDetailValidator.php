<?php

namespace App\Domain\BookingDetail\Service;

use App\Domain\BookingDetail\Repository\BookingDetailRepository;
use App\Factory\ValidationFactory;
use Cake\Validation\Validator;
use Selective\Validation\Exception\ValidationException;

final class BookingDetailValidator
{
    private $repository;
    private $validationFactory;

    public function __construct(BookingDetailRepository $repository, ValidationFactory $validationFactory)
    {
        $this->repository = $repository;
        $this->validationFactory = $validationFactory;
    }

    private function createValidator(): Validator
    {
        $validator = $this->validationFactory->createValidator();

        return $validator
            ->notEmptyString('check_in', 'Input required')
            ->notEmptyString('check_out', 'Input required');
    }
    public function validateBookingDetail(array $data): void
    {
        $validator = $this->createValidator();

        $validationResult = $this->validationFactory->createResultFromErrors(
            $validator->validate($data)
        );

        if ($validationResult->fails()) {
            throw new ValidationException('Please check your input', $validationResult);
        }
    }

    public function validateBookingDetailUpdate(string $customer_name, array $data): void
    {
        /*
        if (!$this->repository->existsBookingDetailNo($customerNo)) {
            throw new ValidationException(sprintf('Store not found: %s', $stocustomerNoreId));
        }
        */
        $this->validateBookingDetail($data);
    }

    public function validateBookingDetailInsert( array $data): void
    {
        $this->validateBookingDetail($data);
    }
    
}
