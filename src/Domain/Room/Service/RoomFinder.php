<?php

namespace App\Domain\Room\Service;

use App\Domain\Room\Repository\RoomRepository;

/**
 * Service.
 */
final class RoomFinder
{
    private $repository;

    public function __construct(RoomRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findRooms(array $params): array
    {
        return $this->repository->findRooms($params);
    }

    public function findRoomsForBooking(array $params): array
    {
        return $this->repository->findRoomsForBooking($params);
    }
    
}
