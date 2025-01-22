<?php

declare(strict_types=1);


require_once 'Database.php';

class User extends Database
{
    public string $userEmail;
    public string $userPassword;

    private function emailExist(string $userEmail): bool
    {
        $userEmail = $this->connectionToDB->real_escape_string($userEmail);
        $result = $this->connectionToDB->query("SELECT * FROM users WHERE userEmail = '{$userEmail}'");

        return $result->num_rows > 0 ? true : false;
    }

    private function hashPassword(string $userPassword): string
    {
        $userPassword = $this->connectionToDB->real_escape_string($userPassword);

        return password_hash($userPassword, PASSWORD_BCRYPT);
    }

    public function registerUser(string $userEmail, string $userPassword)
    {
        $userEmail = $this->connectionToDB->real_escape_string($userEmail);
        $userPassword = $this->connectionToDB->real_escape_string($userPassword);

        (bool) $emailInDB = $this->emailExist($userEmail);

        if ($emailInDB) {
            die('Email is taken');
        } else {
            (string) $hashedUserPassword = $this->hashPassword($userPassword);

            $this->connectionToDB->query(
                "INSERT INTO users (userEmail, userPassword) VALUES('{$userEmail}', '{$hashedUserPassword}')"
            );

            echo 'Account created';
        }
    }

    public function deleteUser(string $userEmail)
    {
        $userEmail = $this->connectionToDB->real_escape_string($userEmail);

        (bool) $emailInDB = $this->emailExist($userEmail);

        if ($emailInDB) {
            $this->connectionToDB->query("DELETE FROM users WHERE userEmail = '{$userEmail}'");

            echo 'Account deleted';
        } else {
            die('Account does not exist');
        }
    }

    public function updateUserEmail(string $userEmail, string $newUserEmail, string $newUserPassword)
    {
        $userEmail = $this->connectionToDB->real_escape_string($userEmail);
        $newUserEmail = $this->connectionToDB->real_escape_string($newUserEmail);
        $newUserPassword = $this->connectionToDB->real_escape_string($newUserPassword);

        (bool) $emailInDB = $this->emailExist($userEmail);

        if ($emailInDB) {
            (string) $hashedUserPassword = $this->hashPassword($newUserPassword);

            $this->connectionToDB->query(
                "UPDATE users SET userEmail = '{$newUserEmail}', userPassword = '{$hashedUserPassword}' WHERE userEmail = '{$userEmail}'"
            );

            echo 'Account details updated';
        } else {
            die('Account does not exist');
        }
    }
}
