<?php

namespace Xmen\StarterKit\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ScriptController
{
    public function show(Request $request)
    {
        $path = Arr::get(\StarterKit::allScripts(), $request->script);

        abort_if(is_null($path), 404);

        return response(
            file_get_contents($path),
            200,
            [
                'Content-Type' => 'application/javascript',
            ]
        )->setLastModified(DateTime::createFromFormat('U', filemtime($path)));
    }
}