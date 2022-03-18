<?php

namespace App\Domain\BookingDetail\Service;

use App\Domain\BookingDetail\Repository\BookingDetailRepository;

/**
 * Service.
 */
final class BookingDetailUpdater
{
    private $repository;
    private $validator;

    public function __construct(
        BookingDetailRepository $repository,
        BookingDetailValidator $validator
    ) {
        $this->repository = $repository;
        $this->validator = $validator;
        //$this->logger = $loggerFactory
            //->addFileHandler('store_updater.log')
            //->createInstance();
    }

    public function insertBookingDetail( array $data): int
    {
        // Input validation
        $this->validator->validateBookingDetailInsert($data);

        // Map form data to row
        $bookingDetailRow = $this->mapToBookingDetailRow($data);

        $id=$this->repository->insertBookingDetail($bookingDetailRow);


        return $id;
    }
    
    public function updateBookingDetail(int $bookingDetailId, array $data): void
    {

        $this->validator->validateBookingDetailUpdate($bookingDetailId, $data);


        $storeRow = $this->mapToBookingDetailRow($data);

        // Insert store
        $this->repository->updateBookingDetail($bookingDetailId, $storeRow);

    }

    public function deleteBookingDetail(int $bookingDetailId, array $data): void
    {
        // Insert store
        $this->repository->deleteBookingDetail($bookingDetailId);

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
    private function mapToBookingDetailRow(array $data): array
    {
        $result = [];
        if (isset($data['date_in'])) {
            $result['date_in'] = (string)$data['date_in'];
        }
        if (isset($data['date_out'])) {
            $result['date_out'] = (string)$data['date_out'];
        }
        if (isset($data['check_in'])) {
            $result['check_in'] = (string)$data['check_in'];
        }
        if (isset($data['check_out'])) {
            $result['check_out'] = (string)$data['check_out'];
        }
        return $result;
    }    

    
}
