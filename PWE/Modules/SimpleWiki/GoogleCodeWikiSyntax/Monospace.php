<?php

namespace PWE\Modules\SimpleWiki\GoogleCodeWikiSyntax;


class Monospace extends \WikiTagXhtml
{

    protected $name = 'tt';
    public $beginTag = '{{{';
    public $endTag = '}}}';

    public function isOtherTagAllowed()
    {
        return false;
    }


}

