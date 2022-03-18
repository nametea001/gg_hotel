<?php

namespace App\Domain\BookingDetail\Repository;

use App\Factory\QueryFactory;
use DomainException;
use Cake\Chronos\Chronos;
use Symfony\Component\HttpFoundation\Session\Session;

final class BookingDetailRepository
{
    private $queryFactory;
    private $session;

    public function __construct(Session $session, QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
        $this->session = $session;
    }
    public function insertBookingDetail(array $row): int
    {
        $row['created_at'] = Chronos::now()->toDateTimeString();
        $row['created_user_id'] = $this->session->get('user')["id"];
        $row['updated_at'] = Chronos::now()->toDateTimeString();
        $row['updated_user_id'] = $this->session->get('user')["id"];

        return (int)$this->queryFactory->newInsert('booking_details', $row)->execute()->lastInsertId();
    }
    public function updateBookingDetail(int $booking_detailID, array $data): void
    {
        $data['updated_at'] = Chronos::now()->toDateTimeString();
        $data['updated_user_id'] = $this->session->get('user')["id"];

        $this->queryFactory->newUpdate('booking_details', $data)->andWhere(['id' => $booking_detailID])->execute();
    }

    public function deleteBookingDetail(int $booking_detailID): void
    {
        $this->queryFactory->newDelete('booking_details')->andWhere(['id' => $booking_detailID])->execute();
    }

    public function findBookingDetails(array $params): array
    {
        $query = $this->queryFactory->newSelect('booking_details');
        $query->select(
            [
                'id',
                'date_in',
                'date_out',
                'check_in',
                'check_out',
            ]
        ); 
        return $query->execute()->fetchAll('assoc') ?: [];
    }

   

  
}
