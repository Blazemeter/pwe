<?php

namespace PWE\Modules\SimpleWiki\GitHubMarkdownSyntax;


class Inliner extends \WikiTagXhtml
{

    protected $name = 'tt';
    public $beginTag = "`";
    public $endTag = "`";
    protected $checkWikiWordIn = array();
}

