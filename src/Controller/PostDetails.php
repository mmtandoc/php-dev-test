<?php

namespace silverorange\DevTest\Controller;

use silverorange\DevTest\Context;
use silverorange\DevTest\Model\Author;
use silverorange\DevTest\Model\Post;
use silverorange\DevTest\Template;
use silverorange\DevTest\Model;
use League\CommonMark\CommonMarkConverter;

class PostDetails extends Controller
{
    private ?Model\Post $post = null;
    private ?Model\Author $author = null;

    public function getContext(): Context
    {
        $context = new Context();



        if ($this->post === null) {
            $context->title = 'Not Found';
            $context->content = "A post with id {$this->params[0]} was not found.";
        } else {
            $converter = new CommonMarkConverter();

            $context->title = $this->post->title;
            $context->post = $this->post;
            $context->author = $this->author;

            //Convert markdown to HTML and replace \n's with real line breaks
            $context->content = $converter->convert(str_replace('\n', "\n", $this->post->body));
        }

        return $context;
    }

    public function getTemplate(): Template\Template
    {
        if ($this->post === null) {
            return new Template\NotFound();
        }

        return new Template\PostDetails();
    }

    public function getStatus(): string
    {
        if ($this->post === null) {
            return $_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found';
        }

        return $_SERVER['SERVER_PROTOCOL'] . ' 200 OK';
    }

    protected function getAuthorById($id): Author
    {
        $stmt = $this->db->prepare("SELECT * FROM authors WHERE id = ? LIMIT 1;");
        $stmt->setFetchMode(\PDO::FETCH_CLASS, "silverorange\DevTest\Model\Author");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    protected function getPostById($id): Post
    {
        $stmt = $this->db->prepare("SELECT * FROM posts WHERE id = ? LIMIT 1;");
        $stmt->setFetchMode(\PDO::FETCH_CLASS, "silverorange\DevTest\Model\Post");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    protected function loadData(): void
    {
        // TODO: Load post from database here. $this->params[0] is the post id.
        $this->post = $this->getPostById($this->params[0]);
        $this->author = $this->getAuthorById($this->post->author);
    }
}
