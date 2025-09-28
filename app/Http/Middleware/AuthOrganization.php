<?php

namespace App\Http\Middleware;

use App\Models\Organization;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthOrganization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $requesterId = $request->header('x-requester-id');
        $apiKey = $request->header('x-api-key');
        $apiSecret = $request->header('x-api-secret');
        $timestamp = $request->header('x-timestamp');

        if (!$apiKey || !$apiSecret || !$timestamp || !$requesterId) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $organization = Organization::query()->where('uuid', $requesterId)->first();
        if (!$organization) {
            return response()->json(['error' => 'Invalid Requester ID'], 401);
        }

        $hashedApiKey = $organization->api_key;
        if (!Hash::check($apiKey, $hashedApiKey)) {
            return response()->json(['error' => 'Invalid API key'], 401);
        }

        $decodedApiSecret = base64_decode($apiSecret);
        $decodedApiSecret = json_decode($decodedApiSecret, true);
        if (empty($decodedApiSecret['requesterId']) || empty($decodedApiSecret['secret'])) {
            return response()->json(['error' => 'Invalid API Secret'], 401);
        }

        if ($decodedApiSecret['requesterId'] !== $requesterId) {
            return response()->json(['error' => 'Invalid Requester ID'], 401);
        }

        $hashedApiSecret = $organization->api_secret;
        if (!Hash::check($decodedApiSecret['secret'], $hashedApiSecret)) {
            return response()->json(['error' => 'Invalid API Secret'], 401);
        }

        if (abs(time() - (int)$timestamp) > 600) {
            return response()->json(['error' => 'Request expired'], 401);
        }

        $request->merge(['organization' => [
            'id' => $organization->id,
            'uuid' => $organization->uuid,
            'name' => $organization->name,
        ]]);

        return $next($request);
    }
}
