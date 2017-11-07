<?php

namespace App\ReadModel;

use App\ReadModel\Views\PostView;

class PostReadRepository
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function countAll(): int
    {
        $stmt = $this->pdo->query('SELECT COUNT(id) FROM posts');
        return $stmt->fetchColumn();
    }

    /**
     * @param int $offset
     * @param int $limit
     * @return PostView[]
     */
    public function getAll(int $offset, int $limit): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM posts ORDER BY id DESC LIMIT ? OFFSET ?');
        $stmt->execute([$limit, $offset]);

        return array_map([$this, 'hydratePost'], $stmt->fetchAll());
    }

    public function find($id): ?PostView
    {
        $stmt = $this->pdo->prepare('SELECT * FROM posts WHERE id = ?');
        $stmt->execute([$id]);

        return ($row = $stmt->fetch()) ? $this->hydratePost($row) : null;
    }

    private function hydratePost(array $row): PostView
    {
        $view = new PostView();

        $view->id = (int)$row['id'];
        $view->date = new \DateTimeImmutable($row['date']);
        $view->title = $row['title'];
        $view->content = $row['content'];

        return $view;
    }
}
