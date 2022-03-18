<?php

namespace App\Domain\Booking\Service;

use App\Domain\Booking\Repository\BookingRepository;

/**
 * Service.
 */
final class BookingFinder
{
    private $repository;

    public function __construct(BookingRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findBookings(array $params): array
    {
        return $this->repository->findBookings($params);
    }
    
    public function findBookingsForBooking(array $params): array
    {
        return $this->repository->findBookingsForBooking($params);
    }

    public function findBookingsForUser(array $params): array
    {
        return $this->repository->findBookingsForUser($params);
    }
  
}
