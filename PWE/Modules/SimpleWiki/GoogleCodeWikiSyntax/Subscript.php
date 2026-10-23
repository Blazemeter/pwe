<?php

namespace PWE\Modules\SimpleWiki\GoogleCodeWikiSyntax;


/**
 * Gestion du texte en indice.
 */
class Subscript extends \WikiTagXhtml
{
    protected $name = 'sub';
    public $beginTag = ',,';
    public $endTag = ',,';
}

