<?php

use Illuminate\Support\Facades\Log;

if (!function_exists('projectLog')) {
    function projectLog($message, array $context = [])
    {
        Log::channel('project')->error($message, $context);
    }
}

?>