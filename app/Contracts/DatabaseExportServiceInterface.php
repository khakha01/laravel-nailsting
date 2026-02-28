<?php

namespace App\Contracts;

interface DatabaseExportServiceInterface
{
    /**
     * Execute database export and return a downloadable response.
     *
     * @return \Illuminate\Http\Response
     */
    public function export();
}
