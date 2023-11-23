<?php


namespace App\Helpers;
use App\Http\Resources\LogsResource;
use Request;
use App\Models\LogActivity as LogActivityModel;


class LogActivity
{
    public static function addToLog($subject, $user_id)
    {
        $log = [];

        $log['subject'] = $subject;
        $log['url'] = Request::fullUrl();
        $log['method'] = Request::method();
        $log['ip'] = Request::ip();
        $log['agent'] = Request::header('user-agent');
        $log['user_id'] = $user_id;

        LogActivityModel::create($log);
    }

    public static function logActivityLists()
    {
        $logs = LogActivityModel::with('user')->latest()->get();
        return LogsResource::collection($logs);
    }
}
