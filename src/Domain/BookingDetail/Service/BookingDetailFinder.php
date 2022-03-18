<?php

namespace App\Domain\BookingDetail\Service;

use App\Domain\BookingDetail\Repository\BookingDetailRepository;

/**
 * Service.
 */
final class BookingDetailFinder
{
    private $repository;

    public function __construct(BookingDetailRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findBookingDetails(array $params): array
    {
        return $this->repository->findBookingDetails($params);
    }
    
   
  
}
