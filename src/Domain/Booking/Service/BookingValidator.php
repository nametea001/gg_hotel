<?php

namespace App\Domain\Booking\Service;

use App\Domain\Booking\Repository\BookingRepository;
use App\Factory\ValidationFactory;
use Cake\Validation\Validator;
use Selective\Validation\Exception\ValidationException;

final class BookingValidator
{
    private $repository;
    private $validationFactory;

    public function __construct(BookingRepository $repository, ValidationFactory $validationFactory)
    {
        $this->repository = $repository;
        $this->validationFactory = $validationFactory;
    }

    private function createValidator(): Validator
    {
        $validator = $this->validationFactory->createValidator();

        return $validator
            ->notEmptyString('rook_detail_id', 'Input required')
            ->notEmptyString('user_id', 'Input required')
            ->notEmptyString('deposit', 'Input required')
            ->notEmptyString('deposit', 'Input required')
            ->notEmptyString('customer_name', 'Input required');
    }
    public function validateBooking(array $data): void
    {
        $validator = $this->createValidator();

        $validationResult = $this->validationFactory->createResultFromErrors(
            $validator->validate($data)
        );

        if ($validationResult->fails()) {
            throw new ValidationException('Please check your input', $validationResult);
        }
    }

    public function validateBookingUpdate(string $customer_name, array $data): void
    {
        /*
        if (!$this->repository->existsBookingNo($customerNo)) {
            throw new ValidationException(sprintf('Store not found: %s', $stocustomerNoreId));
        }
        */
        $this->validateBooking($data);
    }
    public function validateBookingInsert( array $data): void
    {
        $this->validateBooking($data);
    }
}
