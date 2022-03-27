<?php

namespace App\Validation;

use App\Database;

class SignupValidation {

    private string $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function validateEmail(): int
    {
        return Database::connection()
            ->createQueryBuilder()
            ->select('email')
            ->from('users')
            ->where('email = ?')
            ->setParameter(0, $this->getEmail())
            ->executeQuery()
            ->rowCount();
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

}