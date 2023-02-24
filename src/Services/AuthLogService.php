<?php
namespace Moez\ActivityLogger\Services;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Moez\ActivityLogger\Models\AuthLog;
use Moez\ActivityLogger\Services\HttpLogService;

class AuthLogService
{
    public function log(string $eventType, Request $request): JsonResponse
    {
        try {
            $data = [
                'ip_address' => $request->getClientIp(),
                'user_agent' => $request->userAgent(),
            ];
            
            $authLog = AuthLog::create([
                'authenticatable_id' => $request->user()?->id,
                'authenticatable_type' => $request->user() ? get_class( $request->user() ) : null,
                'event_type' => $eventType,
                'created_at' => Carbon::now(),
                'request_hash' => md5($request)
            ]);

            (new HttpLogService())->log($request, $authLog);

            return response()->json([
                'success' => true,
                'message' => 'Authentication Log has been created.',
            ], Response::HTTP_OK);
            
        } catch (Exception $exception) {
            logger()->error($exception);

            return response()->json([
                'success' => false,
                'error' => $exception->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    private static function isMobile() {
        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
    }
}