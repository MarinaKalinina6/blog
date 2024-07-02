<?php

declare(strict_types=1);

require_once __DIR__.'/../../common/database.php';
require_once __DIR__.'/../Entity/Post.php';

final readonly class PostRepository
{
    public function __construct(private PDO $connection)
    {
    }

    public function getById(int $id): ?Post
    {
        $post = $this->connection->query(
            sprintf(
                'SELECT
                    p.id,
                    p.user_id,
                    p.title,
                    p.text,
                    p.added_at,
                    u.username
                FROM posts p
                LEFT JOIN users u ON p.user_id = u.id
                WHERE p.id= %d',
                $id,
            ),
        )->fetch(PDO::FETCH_ASSOC);

        if ($post === false) {
            return null;
        }

        return new Post(
            id: $post['id'],
            authorId: $post['user_id'],
            authorName: $post['username'],
            title: $post['title'],
            text: $post['text'],
            time: $post['added_at'],
        );
    }

    /**
     * @return array<Post>
     */
    public function getByLimit(int $offset, int $limit): array
    {
        $posts = $this->connection->query(
            sprintf(
                'SELECT
                    p.id,
                    p.user_id,
                    p.title,
                    p.text,
                    p.added_at,
                    u.username
                FROM posts p
                LEFT JOIN users u ON p.user_id = u.id
                ORDER BY added_at desc LIMIT %d, %d',
                $offset,
                $limit,
            ),
        )->fetchAll(PDO::FETCH_ASSOC);

        return array_map(static function (array $post): Post {
            return new Post(
                id: $post['id'],
                authorId: $post['user_id'],
                authorName: $post['username'],
                title: $post['title'],
                text: $post['text'],
                time: $post['added_at'],
            );
        }, $posts);
    }

    public function update(string $title, string $text, int $id): void
    {
        $this->connection->query(
            sprintf(
                'UPDATE posts SET title = %s,text = %s WHERE id = %d',
                $this->connection->quote($title),
                $this->connection->quote($text),
                $id,
            ),
        );
    }

    public function insert(int $userId, string $title, string $text): int
    {
        $this->connection->query(
            sprintf(
                'INSERT INTO posts(user_id, title, text, added_at) VALUES (%d,  %s, %s, \'%s\')',
                $userId,
                $this->connection->quote($title),
                $this->connection->quote($text),
                date('Y-m-d H:i:s'),
            ),
        );

        return (int)$this->connection->lastInsertId();
    }

    public function remove(int $postId): void
    {
        $this->connection->query('DELETE FROM posts  WHERE id='.$postId);
    }

    public function countPosts(): int
    {
        return $this->connection->query('SELECT COUNT(*) FROM posts')->fetchColumn();
    }
}

return new PostRepository(database_connect());
