<?php

namespace App\Exceptions;

use Exception;

class InvalidSearchException extends Exception
{
    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
        // Bad user input, don't log
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response("Search input was incorrect.", 400);
    }
}