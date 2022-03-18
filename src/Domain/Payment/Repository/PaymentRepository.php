<?php

namespace App\Domain\Payment\Repository;

use App\Factory\QueryFactory;
use DomainException;
use Cake\Chronos\Chronos;
use Symfony\Component\HttpFoundation\Session\Session;

final class PaymentRepository
{
    private $queryFactory;
    private $session;

    public function __construct(Session $session, QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
        $this->session = $session;
    }
    public function insertPayment(array $row): int
    {
        $row['created_at'] = Chronos::now()->toDateTimeString();
        $row['created_user_id'] = $this->session->get('user')["id"];
        $row['updated_at'] = Chronos::now()->toDateTimeString();
        $row['updated_user_id'] = $this->session->get('user')["id"];

        return (int)$this->queryFactory->newInsert('payments', $row)->execute()->lastInsertId();
    }
    public function updatePayment(int $paymentID, array $data): void
    {
        $data['updated_at'] = Chronos::now()->toDateTimeString();
        $data['updated_user_id'] = $this->session->get('user')["id"];

        $this->queryFactory->newUpdate('payments', $data)->andWhere(['id' => $paymentID])->execute();
    }

    public function deletePayment(int $paymentID): void
    {
        $this->queryFactory->newDelete('payments')->andWhere(['id' => $paymentID])->execute();
    }

    public function findPayments(array $params): array
    {
        $query = $this->queryFactory->newSelect('payments');
        $query->select(
            [
                'id',
                'deposit',
                'amount',
            ]
        ); 
        

        return $query->execute()->fetchAll('assoc') ?: [];
    }

}
