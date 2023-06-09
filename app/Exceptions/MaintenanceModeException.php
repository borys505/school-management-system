<?php

namespace App\Exceptions;

use Exception;

class MaintenanceModeException extends Exception
{
    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
        //
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response()->json(['message' => config('config.maintenance_mode_message')], 422);

        return parent::render($request);
    }
}