<?php
namespace Moez\ActivityLogger\Services;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Model;
use Moez\ActivityLogger\Models\ModelLog;
use Moez\ActivityLogger\Services\HttpLogService;

class ModelLogService
{
    public function create(Model $model, string $modelEventType, Request $request): JsonResponse
    {
        try {
            $modelLog = ModelLog::create([
                'authenticatable_id' => $request->user()?->id,
                'authenticatable_type' => $request->user() ? get_class( $request->user() ) : null,
                'model_type' => get_class($model),
                'model_id' => $model->id,
                'table_name' => $model->getTable(),
                'event_type' => $modelEventType,
                'data' => self::getData($model, $modelEventType),
                'created_at' => Carbon::now(),
                'request_hash' => md5($request)
            ]);

            if (config('user-activity-log.http_log_enabled'))
            {
                (new HttpLogService())->log($request, $modelLog);
            }

            return response()->json([
                'success' => true,
                'message' => 'Log has been created.',
            ], Response::HTTP_OK);
            
        } catch (Exception $exception) {
            logger()->error($exception);

            return response()->json([
                'success' => false,
                'error' => $exception->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private static function getData(Model $model, $modelEventType)
    {
        $data = $model->toArray();

        if (!empty($model->ignoreLogAttributes))
        {
            $data = Arr::except($model->toArray(), $model->ignoreLogAttributes);
        }
        if (!empty($model->logAttributes))
        {
            $data = Arr::only($model->toArray(), $model->logAttributes);
        }
        $wrapData['attributes'] = $data;
        if (count($model->getDirty()) != 0 and in_array($modelEventType, ['updated', 'updating']))
        {
            $wrapData['changes'] = $model->getDirty();
        }
        return json_encode($wrapData);
    }
}