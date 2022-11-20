<?php

namespace silverorange\DevTest\Controller;

use silverorange\DevTest\Context;
use silverorange\DevTest\Template;

class PostIndex extends Controller
{
    private array $posts = [];
    private array $authors = [];

    public function getContext(): Context
    {
        $context = new Context();
        $context->title = 'Posts';
        $context->posts = $this->posts;
        $context->authors = $this->authors;
        return $context;
    }

    public function getTemplate(): Template\Template
    {
        return new Template\PostIndex();
    }

    protected function getAuthors($ids)
    {
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $this->db->prepare("SELECT * from authors WHERE id in ($placeholders)");
        $stmt->execute($ids);
        return $stmt->fetchAll(\PDO::FETCH_CLASS, "silverorange\DevTest\Model\Author");
    }

    protected function getPosts()
    {
        return $this->db
            ->query("SELECT * FROM posts ORDER BY modified_at DESC;")
            ->fetchAll(\PDO::FETCH_CLASS, "silverorange\DevTest\Model\Post");
    }

    protected function loadData(): void
    {
        $this->posts = $this->getPosts();

        $authorIds = array_map(function ($post) {
            return $post->author;
        }, $this->posts);

        $this->authors = $this->getAuthors($authorIds);
    }
}
