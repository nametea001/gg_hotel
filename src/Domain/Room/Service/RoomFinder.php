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
    
    public function getLocalMaxRoomId():int
    {
        $data=$this->repository->getLocalMaxRoomId()[0]["max_id"];
        if(is_null($data)){
            return 0;
        }
        else{
            return $data;
        }
    }
    public function getSyncRooms(int $maxId):array
    {
        return $this->repository->getSyncRooms($maxId);
    }
}
