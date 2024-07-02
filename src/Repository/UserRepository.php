<?php

declare(strict_types=1);

require_once __DIR__.'/../../common/database.php';
require_once __DIR__.'/../Entity/User.php';

final readonly class UserRepository
{
    public function __construct(private PDO $connection)
    {
    }

    public function getByUsername(string $username): User|false
    {
        $user = $this->connection
            ->query(
                sprintf(
                    'SELECT id, username, password FROM users WHERE username = %s',
                    $this->connection->quote($username),
                ),
            )->fetch(PDO::FETCH_ASSOC);

        if ($user === false) {
            return false;
        }

        return new User(
            id: $user['id'],
            username: $user['username'],
            password: $user['password'],
        );
    }

    public function insert(string $username, string $password): void
    {
        $this->connection->query(
            sprintf(
                'INSERT INTO users (username, password) VALUES (%s, %s)',
                $this->connection->quote($username),
                $this->connection->quote($password),
            ),
        );
    }

    public function lastInsertId(): int
    {
        return (int)$this->connection->lastInsertId();
    }

    public function getById(int $id): User
    {
        $user = database_connect()
            ->query('SELECT id, username, password FROM users WHERE id = '.$id)
            ->fetch(PDO::FETCH_ASSOC);

        return new User(
            id: $user['id'],
            username: $user['username'],
            password: $user['password'],
        );
    }
}

return new UserRepository(database_connect());
