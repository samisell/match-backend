<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ApiLogger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        error_log("ApiLogger hit: " . $request->fullUrl());
        if (!$request->is('api/*')) {
            return $next($request);
        }

        $startTime = microtime(true);

        $response = $next($request);

        $duration = microtime(true) - $startTime;

        $logData = [
            'ip' => $request->ip(),
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'user_id' => $request->user()?->id ?? 'guest',
            'request_body' => $this->maskSensitiveData($request->all()),
            'status' => $response->getStatusCode(),
            'duration' => round($duration * 1000, 2) . 'ms',
        ];

        if ($response->getStatusCode() >= 400) {
            $logData['response_body'] = $this->maskSensitiveData(json_decode($response->getContent(), true) ?? []);
        }

        Log::channel('api')->info('API Interaction', $logData);

        // Also record to database for high-level tracking
        try {
            \App\Models\ActivityLog::create([
                'user_id' => $request->user()?->id,
                'action' => $request->method() . ' ' . $request->path(),
                'status' => $response->getStatusCode(),
                'ip_address' => $request->ip(),
                'details' => json_encode([
                    'duration' => $logData['duration'],
                    'has_error' => $response->getStatusCode() >= 400
                ]),
            ]);
        } catch (\Exception $e) {
            // Silently fail database logging to not break the API
            Log::error('Failed to write activity log to DB: ' . $e->getMessage());
        }

        return $response;
    }

    /**
     * Mask sensitive fields in data.
     */
    protected function maskSensitiveData($data)
    {
        if (!is_array($data)) {
            return $data;
        }

        $sensitiveFields = ['password', 'password_confirmation', 'token', 'otp', 'access_token'];

        foreach ($data as $key => $value) {
            if (in_array(strtolower($key), $sensitiveFields)) {
                $data[$key] = '********';
            } elseif (is_array($value)) {
                $data[$key] = $this->maskSensitiveData($value);
            }
        }

        return $data;
    }
}
