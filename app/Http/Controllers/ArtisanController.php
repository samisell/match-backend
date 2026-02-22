<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class ArtisanController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request)
    {
        $command = $request->input('command');
        $parameters = $request->input('parameters', []);

        if (!$command) {
            return response()->json(['error' => 'Command not specified.'], 400);
        }

        // Prevent running dangerous commands
        if (in_array($command, ['down', 'tinker'])) {
            return response()->json(['error' => 'This command is not allowed.'], 403);
        }

        try {
            Artisan::call($command, $parameters);
            $output = Artisan::output();
            return response()->json(['output' => $output]);
        } catch (\Exception $e) {
            Log::error('Artisan command failed: ' . $e->getMessage());
            return response()->json(['error' => 'Command failed to execute.'], 500);
        }
    }
}