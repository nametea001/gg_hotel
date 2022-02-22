<?php

namespace App\Domain\Room\Repository;

use App\Factory\QueryFactory;
use DomainException;
use Cake\Chronos\Chronos;
use Symfony\Component\HttpFoundation\Session\Session;

final class RoomRepository
{
    private $queryFactory;
    private $session;

    public function __construct(Session $session, QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
        $this->session = $session;
    }
    public function insertRoom(array $row): int
    {
        $row['created_at'] = Chronos::now()->toDateTimeString();
        $row['created_user_id'] = $this->session->get('user')["id"];
        $row['updated_at'] = Chronos::now()->toDateTimeString();
        $row['updated_user_id'] = $this->session->get('user')["id"];

        return (int)$this->queryFactory->newInsert('rooms', $row)->execute()->lastInsertId();
    }
    public function updateRoom(int $roomID, array $data): void
    {
        $data['updated_at'] = Chronos::now()->toDateTimeString();
        $data['updated_user_id'] = $this->session->get('user')["id"];

        $this->queryFactory->newUpdate('rooms', $data)->andWhere(['id' => $roomID])->execute();
    }

    public function deleteRoom(int $roomID): void
    {
        $this->queryFactory->newDelete('rooms')->andWhere(['id' => $roomID])->execute();
    }

    public function findRooms(array $params): array
    {
        $query = $this->queryFactory->newSelect('rooms');
        $query->select(
            [
                'id',
                'room_number',
                'room_price',
                'room_type',
                'bed_type',
            ]
        );
        return $query->execute()->fetchAll('assoc') ?: [];
    }
}
