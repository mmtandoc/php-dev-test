<?php

namespace silverorange\DevTest\Template;

use silverorange\DevTest\Context;

class PostDetails extends Layout
{
    protected function renderPage(Context $context): string
    {
        $post = $context->post;
        // @codingStandardsIgnoreStart
        return <<<HTML
            <div class="post">
                <h1 class="post__title">{$post->title}</h1>
                <p class="post__author">Posted by {$context->author->full_name}</p>
                <div class="post__body">{$context->content}</div>
            </div>
        HTML;
        // @codingStandardsIgnoreEnd
    }
}
