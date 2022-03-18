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
        $bookingRow = $this->mapToBookingRow($data);

        $id=$this->repository->insertBooking($bookingRow);


        return $id;
    }

    public function insertBookingUser( array $data): int
    {
        // Input validation
        $this->validator->validateBookingInsert($data);

        // Map form data to row
        $bookingRow = $this->mapToBookingRow($data);

        $id=$this->repository->insertBookingUser($bookingRow);


        return $id;
    }

    public function updateBooking(int $bookingId, array $data): void
    {

        $this->validator->validateBookingUpdate($bookingId, $data);


        $storeRow = $this->mapToBookingRow($data);

        // Insert store
        $this->repository->updateBooking($bookingId, $storeRow);

    }

    public function deleteBooking(int $bookingId, array $data): void
    {
        // Insert store
        $this->repository->deleteBooking($bookingId);

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
        if (isset($data['booking_no'])) {
            $result['booking_no'] = (string)$data['booking_no'];
        }
        if (isset($data['book_detail_id'])) {
            $result['book_detail_id'] = (string)$data['book_detail_id'];
        }
        if (isset($data['user_id'])) {
            $result['user_id'] = (string)$data['user_id'];
        }
        if (isset($data['room_id'])) {
            $result['room_id'] = (string)$data['room_id'];
        }
        if (isset($data['payment_id'])) {
            $result['payment_id'] = (string)$data['payment_id'];
        }
        if (isset($data['status'])) {
            $result['status'] = (string)$data['status'];
        }
        if (isset($data['booking_date'])) {
            $result['booking_date'] = (string)$data['booking_date'];
        }
        return $result;
    }    
}
