<?php

namespace App\Domain\Room\Service;

use App\Domain\Room\Repository\RoomRepository;

/**
 * Service.
 */
final class RoomUpdater
{
    private $repository;
    private $validator;

    public function __construct(
        RoomRepository $repository,
        RoomValidator $validator
    ) {
        $this->repository = $repository;
        $this->validator = $validator;
        //$this->logger = $loggerFactory
            //->addFileHandler('store_updater.log')
            //->createInstance();
    }

    public function insertRoom( array $data): int
    {
        // Input validation
        $this->validator->validateRoomInsert($data);

        // Map form data to row
        $customerRow = $this->mapToRoomRow($data);

        // Insert transferStore
        $id=$this->repository->insertRoom($customerRow);

        // Logging
        //$this->logger->info(sprintf('TransferStore updated successfully: %s', $id));
        return $id;
    }
    public function updateRoom(int $customerId, array $data): void
    {
        // Input validation
        $this->validator->validateRoomUpdate($customerId, $data);

        // Map form data to row
        $storeRow = $this->mapToRoomRow($data);

        // Insert store
        $this->repository->updateRoom($customerId, $storeRow);

        // Logging
        //$this->logger->info(sprintf('Store updated successfully: %s', $storeId));
    }

    public function deleteRoom(int $customerId, array $data): void
    {
        // Insert store
        $this->repository->deleteRoom($customerId);

        // Logging
        //$this->logger->info(sprintf('Store updated successfully: %s', $storeId));
    }

    /**
     * Map data to row.
     *
     * @param array<mixed> $data The data
     *
     * @return array<mixed> The row
     */
    private function mapToRoomRow(array $data): array
    {
        $result = [];
        if (isset($data['room_number'])) {
            $result['room_number'] = (string)$data['room_number'];
        }
        if (isset($data['room_price'])) {
            $result['room_price'] = (string)$data['room_price'];
        }
        if (isset($data['room_type'])) {
            $result['room_type'] = (string)$data['room_type'];
        }
        if (isset($data['bed_type'])) {
            $result['bed_type'] = (string)$data['bed_type'];
        }

        return $result;
    }
}
