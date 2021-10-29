<?php
    use App\Models\Menus;
    use Illuminate\Support\Carbon;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\CacheHelper;
    use Illuminate\Support\Facades\Http;
    use Illuminate\Support\Facades\Auth;

    if (! function_exists('getTitlePage')) {
        function getTitlePage($request_segments){
            $request_segments = (array)$request_segments;
            $headerTitle = '';
            while (empty($headerTitle)){
                $realPath = '/' . implode('/',$request_segments);

                $menu = Menus::where('href', $realPath)->first();

                if(is_object($menu)){
                    $headerTitle = $menu->name;
                }else{
                    if(!array_pop($request_segments)){
                        $headerTitle = '頁面功能名稱';
                    }
                }

            }
            return $headerTitle;
        }
    }

    if(! function_exists('getParentMenuTitlePage')) {
        function getParentMenuTitlePage($request_segments){
            $request_segments = (array)$request_segments;
            $headerTitle = '';
            while (empty($headerTitle)){
                $realPath = '/' . implode('/',$request_segments);

                $menu = Menus::where('href', $realPath)->first();

                if(is_object($menu)){
                    if($menu->parent_id != null){
                        $parent_menu = Menus::find($menu->parent_id);
                        $headerTitle = $parent_menu->name;
                    }else{
                        $headerTitle = "none";
                    }
                }else{
                    if(!array_pop($request_segments)){
                        $headerTitle = '頁面功能名稱';
                    }
                }

            }
            return $headerTitle;
        }
    }

    if (! function_exists('getActionPermission')) {
        function getActionPermission($sys_tag, $current_href = ""){
            $user_permissions = session("user_permissions");
            if($current_href == ""){
                $current_href = '/'.Route::current()->uri();
            }

            $is_use = $user_permissions[$current_href][$sys_tag]['is_use'] ?? 1;
            return $is_use;
        }
    }

    function getStartEndDateTimeOfType($type, $format = null, $sub_count = 0){
        $start = null;
        $end = null;

        switch ($type) {
            case 'day':
                $start = Carbon::now()->subDays($sub_count)->startOfDay();
                $end = Carbon::now()->subDays($sub_count)->endOfDay();
                break;
            case "week":
                $start = Carbon::now()->subWeeks($sub_count)->startOfWeek();
                $end = Carbon::now()->subWeeks($sub_count)->endOfWeek();
                break;
            case "month":
                $start = Carbon::now()->subMonths($sub_count)->startOfMonth();
                $end = Carbon::now()->subMonths($sub_count)->endOfMonth();
                break;
            case "season":
                $start = Carbon::now()->subQuarters($sub_count)->startOfQuarter();
                $end = Carbon::now()->subQuarters($sub_count)->endOfQuarter();
                break;
            case "year":
                $start = Carbon::now()->subYears($sub_count)->startOfYear();
                $end = Carbon::now()->subYears($sub_count)->endOfYear();
                break;
            default:
                throw new Exception("Use Error Type");
                break;
        }

        return [
            "start_datetime" => $format ? $start->format($format): $start->toDateTimeString(),
            "end_datetime" => $format ? $end->format($format): $end->toDateTimeString()
        ];
    }

    function getDateTime($time = null, $format = null, $timezone = null, $return_to_object = false){
        $timezone = $timezone ?: config('app.timezone', 'Asia/Taipei');

        $datetime = $time ? Carbon::parse($time): Carbon::now();
        $datetime->setTimezone($timezone);

        return $return_to_object ? $datetime : ($format ? $datetime->format($format): $datetime->toDateTimeString());
    }

    function getImageLink($table_or_setting_data, string $column = null, string $id = null, string $updated_at = null){
        $setting_data = $table_or_setting_data;
        if (is_string($table_or_setting_data)
        && is_string($column)
        && is_string($id)
        && is_string($updated_at)){
            $setting_data = ['table' => $table_or_setting_data, 'column' => $column, 'id' => $id, 'updated_at' => $updated_at];
        }
        return route("pictureApi", ["q" => base64_encode(json_encode($setting_data))]);
    }