<?php

namespace silverorange\DevTest;

use silverorange\DevTest\Model\Post;
use silverorange\DevTest\Model\Author;

class Context
{
    // TODO: You can add more properties to this class to pass values to templates

    public string $title = '';

    public string $content = '';

    // Properties for PostDetails
    public ?Post $post = null;
    public ?Author $author = null;

    // Properties for PostIndex
    public array $posts = [];
    public array $authors = [];
}
