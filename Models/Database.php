<?php
declare(strict_types=1);


class Database
{
    private string $hostname;
    private string $username;
    private string $password;
    private string $dbname;
    protected mysqli $connectionToDB;

    public function __construct(
        string $hostname = '127.0.0.1',
        string $username = 'root',
        string $password = 'root',
        string $dbname = 'toma_db_killer_oop'
    ) {
        $this->hostname = $hostname;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;

        $this->connectionToDB = new mysqli(
            $this->hostname,
            $this->username,
            $this->password,
            $this->dbname
        );
    }
}
