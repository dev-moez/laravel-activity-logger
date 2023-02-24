<?php
namespace Moez\ActivityLogger\Services;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Http\UploadedFile;
use Moez\ActivityLogger\Models\HttpLog;
use Illuminate\Database\Eloquent\Model;

class HttpLogService
{
    public function log(Request $request, ?Model $model = null): JsonResponse
    {
        try {
            $files = (new Collection(iterator_to_array($request->files)))
                ->map([$this, 'flatFiles'])
                ->flatten();
                
            HttpLog::create([
                'model_type' => $model ? get_class($model): NULL,
                'model_id' => $model?->id,
                'method' => strtoupper($request->getMethod()),
                'uri' => $request->getPathInfo(),
                'body' => $request,
                'headers' => json_encode($request->headers->all()),
                'files' => $files,
                'ip_address' => $request->getClientIp(),
                'user_agent' => $request->userAgent(), 
                'is_mobile' => self::isMobile(),
                'created_at' => Carbon::now(),
                'request_hash' => md5($request),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Http Log has been created.',
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

    public function flatFiles($file)
    {
        if ($file instanceof UploadedFile) {
            return $file->getClientOriginalName();
        }
        if (is_array($file)) {
            return array_map([$this, 'flatFiles'], $file);
        }

        return (string) $file;
    }
}