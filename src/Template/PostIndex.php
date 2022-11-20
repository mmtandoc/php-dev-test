<?php

namespace silverorange\DevTest\Template;

use silverorange\DevTest\Context;
use silverorange\DevTest\Model\Author;

class PostIndex extends Layout
{
    protected function renderPage(Context $context): string
    {
        $post_items = '';
        foreach ($context->posts as $post) {
            $author = $context->authors[array_search($post->author, $context->authors)];
            $post_items .= <<<HTML
            <div class="post-item">
                <a class="post-item__title-link" href="/posts/{$post->id}">
                    {$post->title}
                </a>
                <span class="post-item__author">By {$author->full_name}</span>
            </div>
            HTML;
        }
        // @codingStandardsIgnoreStart
        return <<<HTML
        <div>
            <h1>Posts</h1>
            {$post_items}
        </div>

        HTML;
        // @codingStandardsIgnoreEnd
    }
}
