<?php

namespace App\Domain\Booking\Repository;

use App\Factory\QueryFactory;
use DomainException;
use Cake\Chronos\Chronos;
use Symfony\Component\HttpFoundation\Session\Session;

final class BookingRepository
{
    private $queryFactory;
    private $session;

    public function __construct(Session $session, QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
        $this->session = $session;
    }
    public function insertBooking(array $row): int
    {
        $row['created_at'] = Chronos::now()->toDateTimeString();
        $row['created_user_id'] = $this->session->get('user')["id"];
        $row['updated_at'] = Chronos::now()->toDateTimeString();
        $row['updated_user_id'] = $this->session->get('user')["id"];

        return (int)$this->queryFactory->newInsert('bookings', $row)->execute()->lastInsertId();
    }
    public function updateBooking(int $bookingID, array $data): void
    {
        $data['updated_at'] = Chronos::now()->toDateTimeString();
        $data['updated_user_id'] = $this->session->get('user')["id"];

        $this->queryFactory->newUpdate('bookings', $data)->andWhere(['id' => $bookingID])->execute();
    }

    public function deleteBooking(int $bookingID): void
    {
        $this->queryFactory->newDelete('bookings')->andWhere(['id' => $bookingID])->execute();
    }

    public function findBookings(array $params): array
    {
        $query = $this->queryFactory->newSelect('bookings');
        $query->select(
            [
                'bookings.id',
                'booking_no',
                'book_detail_id',
                'user_id',
                'room_id',
                'payment_id',
                'deposit',
                'status',
                'booking_date',
                'bookings.created_at',
                'room_number',
                'room_price',
                'room_type',
                'first_name',
                'last_name',
            ]
        ); 
        $query->join([
            'r' => [
                'table' => 'rooms',
                'type' => 'INNER',
                'conditions' => 'r.id = room_id',
            ]
        ]);
        $query->join([
            'u' => [
                'table' => 'users',
                'type' => 'INNER',
                'conditions' => 'u.id = user_id',
            ]
        ]);
        if (isset($params["startDate"])) {
            $query->andWhere(['booking_date <=' => $params['endDate'], 'booking_date >=' => $params['startDate']]);
        }

        return $query->execute()->fetchAll('assoc') ?: [];
    }

    public function findBookingsForBooking(array $params): array
    {
        $query = $this->queryFactory->newSelect('bookings');
        $query->select(
            [
                'bookings.id',
                'booking_no',
                'book_detail_id',
                'user_id',
                'room_id',
                'payment_id',
                'deposit',
                'status',
                'booking_date',
                'bookings.created_at',
                'room_number',
                'room_price',
                'room_type',
                'date_in',
                'date_out',
            ]
        ); 
        $query->join([
            'r' => [
                'table' => 'rooms',
                'type' => 'INNER',
                'conditions' => 'r.id = room_id',
            ]
        ]);
        $query->join([
            'bd' => [
                'table' => 'booking_details',
                'type' => 'INNER',
                'conditions' => 'bd.id = book_detail_id',
            ]
        ]);
        if(isset($params['room_type'])){
            $query->andWhere(['room_type' => $params['room_type']]);
        }
        if (isset($params["startDate"])) {
            $query->andWhere(['date_in <=' => $params['endDate'], 'date_out >=' => $params['startDate']]);
        }
        $query->andWhere(['status !=' => 'CANCEL']);
        $query->andWhere(['status !=' => 'CHECK_OUT']);
        

        return $query->execute()->fetchAll('assoc') ?: [];
    }

    public function findBookingsSigleTabel(array $params): array
    {
        $query = $this->queryFactory->newSelect('bookings');
        $query->select(
            [
                'bookings.id',
                'book_detail_id',
                'user_id',
                'room_id',
                'payment_id',
                'deposit',
                'status',
                'booking_date',
            ]
        ); 
        return $query->execute()->fetchAll('assoc') ?: [];
    }
}
