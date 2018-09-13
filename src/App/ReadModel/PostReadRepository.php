<?php

namespace App\ReadModel;

class PostReadRepository
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function countAll(): int
    {
        return $this->pdo->query('SELECT COUNT(id) FROM posts')->fetchColumn();
    }

    public function all(int $offset, int $limit): array
    {
        $stmt = $this->pdo->prepare('
            SELECT
                p.*,
                (SELECT COUNT(*) FROM comments c WHERE c.post_id = p.id) comments_count
            FROM posts p ORDER BY p.create_date DESC LIMIT :limit OFFSET :offset
        ');

        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);

        $stmt->execute();

        return array_map([$this, 'hydratePostList'], $stmt->fetchAll());
    }

    public function find(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT p.* FROM posts p WHERE id = :id');
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        if (!$post = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            return null;
        }

        $stmt = $this->pdo->prepare('SELECT * FROM comments WHERE post_id = :post_id ORDER BY id ASC');
        $stmt->bindValue(':post_id', (int)$post['id'], \PDO::PARAM_INT);
        $stmt->execute();
        $comments = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $this->hydratePostDetail($post, $comments);
    }

    private function hydratePostList(array $row): array
    {
        return [
            'id' => (int)$row['id'],
            'date' => new \DateTimeImmutable($row['create_date']),
            'title' => $row['title'],
            'preview' => $row['content_short'],
            'commentsCount' => $row['comments_count'],
        ];
    }

    private function hydratePostDetail(array $row, array $comments): array
    {
        return [
            'id' => (int)$row['id'],
            'date' => new \DateTimeImmutable($row['create_date']),
            'title' => $row['title'],
            'content' => $row['content_full'],
            'meta' => [
                'title' => $row['meta_title'],
                'description' => $row['meta_description'],
            ],
            'comments' => array_map([$this, 'hydrateComment'], $comments),
        ];
    }

    private function hydrateComment(array $row): array
    {
        return [
            'id' => (int)$row['id'],
            'date' => new \DateTimeImmutable($row['date']),
            'author' => $row['author'],
            'text' => $row['text'],
        ];
    }
}
