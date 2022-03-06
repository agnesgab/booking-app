<?php

class User {

    private string $name;
    private string $surname;
    private string $password;
    private string $email;
    private string $birthday;

    /**
     * @param string $name
     * @param string $surname
     * @param string $password
     * @param string $email
     * @param string $birthday
     */
    public function __construct(string $name, string $surname, string $password, string $email, string $birthday)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->password = $password;
        $this->email = $email;
        $this->birthday = $birthday;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
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
    public function getBirthday(): string
    {
        return $this->birthday;
    }


}