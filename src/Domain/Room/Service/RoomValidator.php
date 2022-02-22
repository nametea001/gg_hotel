<?php

namespace App\Domain\Room\Service;

use App\Domain\Room\Repository\RoomRepository;
use App\Factory\ValidationFactory;
use Cake\Validation\Validator;
use Selective\Validation\Exception\ValidationException;

final class RoomValidator
{
    private $repository;
    private $validationFactory;

    public function __construct(RoomRepository $repository, ValidationFactory $validationFactory)
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
    public function validateRoom(array $data): void
    {
        $validator = $this->createValidator();

        $validationResult = $this->validationFactory->createResultFromErrors(
            $validator->validate($data)
        );

        if ($validationResult->fails()) {
            throw new ValidationException('Please check your input', $validationResult);
        }
    }

    public function validateRoomUpdate(string $customer_name, array $data): void
    {
        /*
        if (!$this->repository->existsRoomNo($customerNo)) {
            throw new ValidationException(sprintf('Store not found: %s', $stocustomerNoreId));
        }
        */
        $this->validateRoom($data);
    }
    public function validateRoomInsert( array $data): void
    {
        $this->validateRoom($data);
    }
}
