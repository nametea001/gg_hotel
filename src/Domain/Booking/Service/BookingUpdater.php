<?php

namespace App\Domain\Booking\Service;

use App\Domain\Booking\Repository\BookingRepository;

/**
 * Service.
 */
final class BookingUpdater
{
    private $repository;
    private $validator;

    public function __construct(
        BookingRepository $repository,
        BookingValidator $validator
    ) {
        $this->repository = $repository;
        $this->validator = $validator;
        //$this->logger = $loggerFactory
            //->addFileHandler('store_updater.log')
            //->createInstance();
    }

    public function insertBooking( array $data): int
    {
        // Input validation
        $this->validator->validateBookingInsert($data);

        // Map form data to row
        $customerRow = $this->mapToBookingRow($data);

        // Insert transferStore
        $id=$this->repository->insertBooking($customerRow);

        // Logging
        //$this->logger->info(sprintf('TransferStore updated successfully: %s', $id));
        return $id;
    }
    public function updateBooking(int $customerId, array $data): void
    {
        // Input validation
        $this->validator->validateBookingUpdate($customerId, $data);

        // Map form data to row
        $storeRow = $this->mapToBookingRow($data);

        // Insert store
        $this->repository->updateBooking($customerId, $storeRow);

        // Logging
        //$this->logger->info(sprintf('Store updated successfully: %s', $storeId));
    }

    public function deleteBooking(int $customerId, array $data): void
    {
        // Insert store
        $this->repository->deleteBooking($customerId);

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
    private function mapToBookingRow(array $data): array
    {
        $result = [];
        if (isset($data['booking_number'])) {
            $result['booking_number'] = (string)$data['booking_number'];
        }
        if (isset($data['booking_price'])) {
            $result['booking_price'] = (string)$data['booking_price'];
        }
        if (isset($data['booking_type'])) {
            $result['booking_type'] = (string)$data['booking_type'];
        }
        if (isset($data['bed_type'])) {
            $result['bed_type'] = (string)$data['bed_type'];
        }

        return $result;
    }
}
