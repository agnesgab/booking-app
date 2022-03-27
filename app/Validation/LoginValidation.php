<?php

namespace App\Validation;

use App\Database;

class LoginValidation {

    private string $email;
    private string $password;
    private int $sessionId;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function validateLogin(){

        $userQuery = Database::connection()
            ->createQueryBuilder()
            ->select('id')
            ->from('users')
            ->where('email = ?', 'password = ?')
            ->setParameter(0, $this->getEmail())
            ->setParameter(1, $this->getPassword())
            ->executeQuery()
            ->fetchOne();

        if($userQuery !== false){
            return $this->sessionId = (int)$userQuery;
        }

        return false;

    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return int
     */
    public function getSessionId(): int
    {
        return $this->sessionId;
    }
}