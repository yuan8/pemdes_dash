<?php

namespace App\Events;

use Illuminate\Http\Request;
use Validator;
class ChatterAfterNewResponse
{
    /**
     * @var Request
     */
    public $request;

    /**
     * Constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}