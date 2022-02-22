<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserRepository;
use App\Domain\User\Type\UserRoleType;
use App\Factory\ValidationFactory;
use Cake\Validation\Validator;
use Selective\Validation\Exception\ValidationException;

/**
 * Service.
 */
final class UserValidator
{
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * @var ValidationFactory
     */
    private $validationFactory;

    /**
     * The constructor.
     *
     * @param UserRepository $repository The repository
     * @param ValidationFactory $validationFactory The validation
     */
    public function __construct(UserRepository $repository, ValidationFactory $validationFactory)
    {
        $this->repository = $repository;
        $this->validationFactory = $validationFactory;
    }

    /**
     * Create validator.
     *
     * @return Validator The validator
     */
    private function createValidator(): Validator
    {
        $validator = $this->validationFactory->createValidator();

        return $validator
            ->notEmptyString('username', 'Input required')
            ->notEmptyString('password', 'Input required')
            ->minLength('password', 4, 'Too short')
            ->maxLength('password', 40, 'Too long')
            ->email('email', false, 'Input required')
            ->inList('user_role_id', [UserRoleType::ROLE_ADMIN, UserRoleType::ROLE_USER, UserRoleType::ROLE_STORE, UserRoleType::ROLE_MANAGER, UserRoleType::ROLE_STORE_MANAGER, UserRoleType::ROLE_SUPER_ADMIN, UserRoleType::ROLE_FINANCE], 'Invalid')
            ->notEmptyString('locale', 'Input required')
            ->regex('locale', '/^[a-z]{2}\_[A-Z]{2}$/', 'Invalid')
            ->boolean('enabled', 'Invalid');
    }

    /**
     * Validate new user.
     *
     * @param array<mixed> $data The data
     *
     * @throws ValidationException
     *
     * @return void
     */
    public function validateUser(array $data): void
    {
        $validator = $this->createValidator();

        $validationResult = $this->validationFactory->createResultFromErrors(
            $validator->validate($data)
        );

        if ($validationResult->fails()) {
            throw new ValidationException('Please check your input', $validationResult);
        }
    }

    /**
     * Validate update.
     *
     * @param int $userId The user id
     * @param array<mixed> $data The data
     *
     * @return void
     */
    public function validateUserUpdate(int $userId, array $data): void
    {
        if (!$this->repository->existsUserId($userId)) {
            throw new ValidationException(sprintf('User not found: %s', $userId));
        }

        $this->validateUser($data);
    }
}
