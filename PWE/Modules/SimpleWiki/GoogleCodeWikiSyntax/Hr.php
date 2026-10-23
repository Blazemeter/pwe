<?php

namespace PWE\Modules\SimpleWiki\GoogleCodeWikiSyntax;


/**
 * traite les signes de types hr
 */
class Hr extends \WikiRendererBloc
{
    public $type = 'hr';
    protected $regexp = '/^-{4,}$/';
    protected $_closeNow = true;

    public function getRenderedLine()
    {
        return '<hr />';
    }
}

