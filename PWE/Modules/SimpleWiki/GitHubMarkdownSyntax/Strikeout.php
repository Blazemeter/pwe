<?php

namespace PWE\Modules\SimpleWiki\GitHubMarkdownSyntax;


class Strikeout extends \WikiTagXhtml
{

    protected $name = 's';
    public $beginTag = "~~";
    public $endTag = "~~";

}

