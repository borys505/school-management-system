<?php
/*
 *  Used to write in .env file
 *  @param
 *  $data as array of .env key & value
 *  @return nothing
 */

function envu($data = array())
{
    foreach ($data as $key => $value) {
        if (env($key) === $value) {
            unset($data[$key]);
        }
    }

    if (!count($data)) {
        return false;
    }

    // write only if there is change in content

    $env = file_get_contents(base_path() . '/.env');
    $env = explode("\n", $env);
    foreach ((array)$data as $key => $value) {
        foreach ($env as $env_key => $env_value) {
            $entry = explode("=", $env_value, 2);
            if ($entry[0] === $key) {
                $env[$env_key] = $key . "=" . (is_string($value) ? '"'.$value.'"' : $value);
            } else {
                $env[$env_key] = $env_value;
            }
        }
    }
    $env = implode("\n", $env);
    file_put_contents(base_path() . '/.env', $env);
    return true;
}

//////////////////////////////////////////////////////////////////////// Date helper function starts

/*
 *  Used to check whether date is valid or not
 *  @param
 *  $date as timestamp or date variable
 *  @return true if valid date, else if not
 */

function validateDate($date)
{
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}

/*
 *  Used to calculate date difference between two dates
 */

function dateDiff($date1, $date2)
{
    if ($date2 > $date1) {
        return date_diff(date_create($date1), date_create($date2))->days;
    } else {
        return date_diff(date_create($date2), date_create($date1))->days;
    }
}

/*
 *  Used to get date with start midnight time
 *  @param
 *  $date as timestamp or date variable
 *  @return date with start midnight time
 */

function getStartOfDate($date)
{
    return date('Y-m-d', strtotime($date)).' 00:00';
}

/*
 *  Used to get date with end midnight time
 *  @param
 *  $date as timestamp or date variable
 *  @return date with end midnight time
 */

function getEndOfDate($date)
{
    return date('Y-m-d', strtotime($date)).' 23:59';
}

/*
 *  Used to get date in desired format
 *  @return date format
 */

function getDateFormat()
{
    if (config('config.date_format') === 'DD-MM-YYYY') {
        return 'd-m-Y';
    } elseif (config('config.date_format') === 'MM-DD-YYYY') {
        return 'm-d-Y';
    } elseif (config('config.date_format') === 'DD-MMM-YYYY') {
        return 'd-M-Y';
    } elseif (config('config.date_format') === 'MMM-DD-YYYY') {
        return 'M-d-Y';
    } else {
        return 'd-m-Y';
    }
}

/*
 *  Used to convert date for database
 *  @param
 *  $date as date
 *  @return date
 */

function toDate($date)
{
    if (!$date) {
        return;
    }

    return date('Y-m-d', strtotime($date));
}

/*
 *  Used to convert time for database
 *  @param
 *  $time as time
 *  @return time
 */

function toTime($time)
{
    if (!$time) {
        return;
    }

    return date('H:i', strtotime($time));
}

/*
 *  Used to convert date in desired format
 *  @param
 *  $date as date
 *  @return date
 */

function showDate($date)
{
    if (!$date) {
        return;
    }

    $date_format = getDateFormat();
    return date($date_format, strtotime($date));
}

/*
 *  Used to convert time in desired format
 *  @param
 *  $datetime as datetime
 *  @return datetime
 */

function showDateTime($time = '')
{
    if (!$time) {
        return;
    }

    $date_format = getDateFormat();
    if (config('config.time_format') === 'H:mm') {
        return date($date_format.',H:i', strtotime($time));
    } else {
        return date($date_format.',h:i a', strtotime($time));
    }
}

/*
 *  Used to convert time in desired format
 *  @param
 *  $time as time
 *  @return time
 */

function showTime($time = '')
{
    if (!$time) {
        return;
    }

    if (config('config.time_format') === 'H:mm') {
        return date('H:i', strtotime($time));
    } else {
        return date('h:i a', strtotime($time));
    }
}
//////////////////////////////////////////////////////////////////////// Date helper function ends

//////////////////////////////////////////////////////////////////////// String helper function starts

/*
 *  Used to convert slugs into human readable words
 *  @param
 *  $word as string
 *  @return string
 */

function toWord($word)
{
    $word = str_replace('_', ' ', $word);
    $word = str_replace('-', ' ', $word);
    $word = ucwords($word);
    return $word;
}

/*
 *  Used to generate random string of certain lenght
 *  @param
 *  $length as numeric
 *  $type as optional param, can be token or password or username. Default is token
 *  @return random string
 */

function randomString($length, $type = 'token')
{
    if ($type === 'password') {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
    } elseif ($type === 'username') {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
    } else {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    }
    $token = substr(str_shuffle($chars), 0, $length);
    return $token;
}

/*
 *  Used to whether string contains unicode
 *  @param
 *  $string as string
 *  @return boolean
 */

function checkUnicode($string)
{
    if (strlen($string) != strlen(utf8_decode($string))) {
        return true;
    } else {
        return false;
    }
}

/*
 *  Used to generate slug from string
 *  @param
 *  $string as string
 *  @return slug
 */

function createSlug($string)
{
    if (! $string) {
        return;
    }

    if (checkUnicode($string)) {
        $slug = str_replace(' ', '-', $string);
    } else {
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower($string));
    }
    return $slug;
}

/*
 *  Used to remove script tag from input
 *  @param
 *  $string as string
 *  @return slug
 */

function scriptStripper($string)
{
    return preg_replace('#<script(.*?)>(.*?)</script>#is', '', $string);
}

function isInteger($input){
    return(ctype_digit(strval($input)));
}

//////////////////////////////////////////////////////////////////////////////////// String helper function ends

//////////////////////////////////////////////////////////////////////////////////// Select helper function starts

/*
 *  Used to generate select option for vue.js multiselect plugin
 *  @param
 *  $data as array of key & value pair
 *  @return select options
 */

function generateSelectOption($data)
{
    $options = array();
    foreach ($data as $key => $value) {
        $options[] = ['name' => $value, 'id' => $key];
    }
    return $options;
}

/*
 *  Used to generate translated select option for vue.js multiselect plugin
 *  @param
 *  $data as array of key & value pair
 *  @return select options
 */

function generateTranslatedSelectOption($data)
{
    $options = array();
    foreach ($data as $key => $value) {
        $options[] = ['name' => trans('list.'.$value), 'id' => $value];
    }
    return $options;
}

/*
 *  Used to generate select option for default select box
 *  @param
 *  $data as array of key & value pair
 *  @return select options
 */

function generateNormalSelectOption($data)
{
    $options = array();
    foreach ($data as $key => $value) {
        $options[] = ['text' => $value, 'value' => $key];
    }
    return $options;
}

/*
 *  Used to generate select option for default select box (translated)
 *  @param
 *  $data as array of key & value pair
 *  @return select options
 */

function generateNormalTranslatedSelectOption($data)
{
    $options = array();
    foreach ($data as $key => $value) {
        $options[] = ['text' => trans('list.'.$value), 'value' => $value];
    }
    return $options;
}

/*
 *  Used to generate select option for default select box where value is same as text
 *  @param
 *  $data as array of key & value pair
 *  @return select options
 */

function generateNormalSelectOptionValueOnly($data)
{
    $options = array();
    foreach ($data as $value) {
        $options[] = ['text' => $value, 'value' => $value];
    }
    return $options;
}

//////////////////////////////////////////////////////////////////////////////////// Select helper function ends

/*
 *  Used to round number
 *  @param
 *  $number as numeric value
 *  $decimal_place as integer for round precision
 *  @return number
 */

function formatNumber($number, $decimal_place = 2)
{
    return round($number, $decimal_place);
}

////////////////////////////////////////////////////////////////////////////////////// IP helper function starts

/*
 *  Used to check whether IP is in range
 */

function ipRange($network, $ip)
{
    $network=trim($network);
    $orig_network = $network;
    $ip = trim($ip);
    if ($ip === $network) {
        return true;
    }
    $network = str_replace(' ', '', $network);
    if (strpos($network, '*') != false) {
        if (strpos($network, '/') != false) {
            $asParts = explode('/', $network);
            $network = @ $asParts[0];
        }
        $nCount = substr_count($network, '*');
        $network = str_replace('*', '0', $network);
        if ($nCount === 1) {
            $network .= '/24';
        } elseif ($nCount === 2) {
            $network .= '/16';
        } elseif ($nCount === 3) {
            $network .= '/8';
        } elseif ($nCount > 3) {
            return true;
        }
    }

    $d = strpos($network, '-');
    if ($d === false) {
        $ip_arr = explode('/', $network);
        if (!preg_match("@\d*\.\d*\.\d*\.\d*@", $ip_arr[0], $matches)) {
            $ip_arr[0].=".0";
        }
        $network_long = ip2long($ip_arr[0]);
        $x = ip2long($ip_arr[1]);
        $mask = long2ip($x) === $ip_arr[1] ? $x : (0xffffffff << (32 - $ip_arr[1]));
        $ip_long = ip2long($ip);
        return ($ip_long & $mask) === ($network_long & $mask);
    } else {
        $from = trim(ip2long(substr($network, 0, $d)));
        $to = trim(ip2long(substr($network, $d+1)));
        $ip = ip2long($ip);
        return ($ip>=$from and $ip<=$to);
    }
}

/*
 *  Used to check whether IP is valid or not
 *  @return boolean
 */

function validateIp($wl_ips)
{

    // $ip = getClientIp();
    $ip = '192.168.1.1';

    $allowedIps = array();
    foreach ($wl_ips as $wl_ip) {
        if ($wl_ip->end_ip) {
            $allowedIps[] = $wl_ip->start_ip.'-'.$wl_ip->end_ip;
        } else {
            $allowedIps[] = $wl_ip->start_ip;
        }
    }

    foreach ($allowedIps as $allowedIp) {
        if (strpos($allowedIp, '*')) {
            $range = [
                str_replace('*', '0', $allowedIp),
                str_replace('*', '255', $allowedIp)
            ];
            if (ipExistsInRange($range, $ip)) {
                return true;
            }
        } elseif (strpos($allowedIp, '-')) {
            $range = explode('-', str_replace(' ', '', $allowedIp));
            if (ipExistsInRange($range, $ip)) {
                return true;
            }
        } else {
            if (ip2long($allowedIp) === ip2long($ip)) {
                return true;
            }
        }
    }
    return false;
}

function ipExistsInRange(array $range, $ip)
{
    if (ip2long($ip) >= ip2long($range[0]) && ip2long($ip) <= ip2long($range[1])) {
        return true;
    }
    return false;
}

/*
 *  Used to get IP address of visitor
 *  @return date
 */

function getRemoteIPAddress()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    return array_key_exists('REMOTE_ADDR', $_SERVER) ? $_SERVER['REMOTE_ADDR'] : null;
}

/*
 *  Used to get IP address of visitor
 *  @return IP address
 */

function getClientIp()
{
    $ips = getRemoteIPAddress();
    $ips = explode(',', $ips);
    return !empty($ips[0]) ? $ips[0] : \Request::getClientIp();
}

////////////////////////////////////////////////////////////////////////////////////////// IP helper function ends

/*
 *  Used to check mode
 *  @return boolean
 */

function isTestMode()
{
    if (env('APP_MODE') == 'test') {
        return true;
    } else {
        return false;
    }
}

/*
 * get Maximum post size of server
 */

function getPostMaxSize()
{
    if (is_numeric($postMaxSize = ini_get('post_max_size'))) {
        return (int) $postMaxSize;
    }

    $metric = strtoupper(substr($postMaxSize, -1));
    $postMaxSize = (int) $postMaxSize;

    switch ($metric) {
        case 'K':
            return $postMaxSize * 1024;
        case 'M':
            return $postMaxSize * 1048576;
        case 'G':
            return $postMaxSize * 1073741824;
        default:
            return $postMaxSize;
    }
}

/*
 *  Used to get value-list json
 *  @return array
 */

function getVar($list)
{
    $file = resource_path('var/'.$list.'.json');

    return (\File::exists($file)) ? json_decode(file_get_contents($file), true) : [];
}

/*
 *  Used to get seed value-list json
 *  @return array
 */

function getSeedVar($list)
{
    $file = resource_path('var/seed/'.$list.'.json');

    return (\File::exists($file)) ? json_decode(file_get_contents($file), true) : [];
}

function isConnected()
{
    $connected = @fsockopen("www.google.com", 80);
    if ($connected) {
        fclose($connected);
        return true;
    }

    return false;
}

/*
 *  Used to URL via CURL
 *  @return array
 */

function curlIt($url, $postData = array())
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

/*
 *  Used to get Default Currency
 *  @return array
 */

function getDefaultCurrency($prop = null)
{
    $default_currency_key = array_search(config('config.currency'), array_column(getVar('currency'), 'name'));
    $currency = ($default_currency_key !== false) ? getVar('currency')[$default_currency_key] : null;

    if (! $prop) {
        return $currency;
    }

    return ($currency && isset($currency[$prop])) ? $currency[$prop] : null;
}

/*
 *  Used to format amount in given currency
 *  @param
 *  $amount as numeric
 *  $symbol as boolean, 1 for with currency symbol or 0 for without currency symbol
 *  @return string
 */
function currency($amount, $symbol = 0)
{
    $currency = getDefaultCurrency();

    if (! $currency) {
        return round($amount, 2);
    }
    
    $decimal_value   = $currency['decimal_place'];

    if (! $symbol) {
        return round($amount, $decimal_value);
    }

    $position        = $currency['position'];
    $currency_symbol = $currency['symbol'];

    $amount = round($amount, $decimal_value);

    if ($position === 'suffix') {
        return $amount.''.$currency_symbol;
    } else {
        return $currency_symbol.''.$amount;
    }
}

function gv($params, $key, $default = null)
{
    return (isset($params[$key]) && $params[$key]) ? $params[$key] : $default;
}

function gbv($params, $key)
{
    return (isset($params[$key]) && $params[$key]) ? 1 : 0;
}

function dateBetweenSession($date)
{
    if (! $date) {
        return false;
    }

    if ($date >= config('config.default_academic_session.start_date') && $date <= config('config.default_academic_session.end_date')) {
        return true;
    }

    return false;
}

function dateLessThanSessionStart($date)
{
    if (! $date) {
        return false;
    }

    if ($date <= config('config.default_academic_session.start_date')) {
        return true;
    }

    return false;
}

function dateLessThanSessionEnd($date)
{
    if (! $date) {
        return false;
    }

    if ($date <= config('config.default_academic_session.end_date')) {
        return true;
    }

    return false;
}

function dateGreaterThanSessionStart($date)
{
    if (! $date) {
        return false;
    }

    if ($date >= config('config.default_academic_session.start_date')) {
        return true;
    }

    return false;
}

function dateGreaterThanSessionEnd($date)
{
    if (! $date) {
        return false;
    }

    if ($date >= config('config.default_academic_session.end_date')) {
        return true;
    }

    return false;
}

function getLateFeeFrequencies()
{
    return [
        ['value' => '1', 'text' => trans('finance.late_fee_frequency_daily')],
        ['value' => '7', 'text' => trans('finance.late_fee_frequency_weekly')],
        ['value' => '15', 'text' => trans('finance.late_fee_frequency_fortnightly')],
        ['value' => '30', 'text' => trans('finance.late_fee_frequency_monthly')],
        ['value' => '60', 'text' => trans('finance.late_fee_frequency_bi_monthly')],
        ['value' => '90', 'text' => trans('finance.late_fee_frequency_quarterly')],
        ['value' => '180', 'text' => trans('finance.late_fee_frequency_bi_annually')],
        ['value' => '365', 'text' => trans('finance.late_fee_frequency_annually')],
        ['value' => '500', 'text' => trans('general.custom')]
    ];
}

function getLateFeeFrequenciesInWord($frequency)
{
    if ($frequency == 1) {
        return 'daily';
    } elseif ($frequency == 7) {
        return 'weekly';
    } elseif ($frequency == 15) {
        return 'fortnightly';
    } elseif ($frequency == 30) {
        return 'monthly';
    } elseif ($frequency == 60) {
        return 'bi_monthly';
    } elseif ($frequency == 90) {
        return 'quarterly';
    } elseif ($frequency == 180) {
        return 'bi_annually';
    } elseif ($frequency == 365) {
        return 'annually';
    } else {
        return 'daily';
    }
}

function getLateFeeFrequenciesInDays($frequency)
{
    if ($frequency == 'daily') {
        return 1;
    } elseif ($frequency == 'weekly') {
        return 7;
    } elseif ($frequency == 'fortnightly') {
        return 15;
    } elseif ($frequency == 'monthly') {
        return 30;
    } elseif ($frequency == 'bi_monthly') {
        return 60;
    } elseif ($frequency == 'quarterly') {
        return 90;
    } elseif ($frequency == 'bi_annually') {
        return 180;
    } elseif ($frequency == 'annually') {
        return 365;
    } else {
        return 1;
    }
}

function getRollNumber($student_record){
    if (! $student_record->roll_number) {
        return;
    }

    if ($student_record->batch->getOption('roll_number_digit')) {
        $roll_number = str_pad($student_record->roll_number, $student_record->batch->getOption('roll_number_digit'), '0', STR_PAD_LEFT);    
    } else {
        $roll_number = $student_record->roll_number;
    }
    
    return $student_record->batch->getOption('roll_number_prefix').$roll_number;
}

function getStudentBatchOnDate($student, $date = null)
{
    $date = ($date) ? : date('Y-m-d');

    if (! $student->studentRecords()->count())
        return null;

    $student_record = $student->StudentRecords->where('date_of_entry','<=',$date)->where('is_promoted',0)->first();

    return ($student_record) ? $student_record->Batch->batch_with_course : null;
}

function getEmployeeDesignation($employee, $date = null)
{
    $date = ($date) ? : date('Y-m-d');

    if (! $employee) {
        return null;
    }

    if (! $employee->relationLoaded('employeeDesignations')) {
        $employee->load('employeeDesignations');
    }

    return $employee->employeeDesignations->sortByDesc('date_effective')->firstWhere('date_effective', '<=', $date);
}

function getEmployeeDesignationId($employee, $date = null)
{
    $designation = getEmployeeDesignation($employee, $date);

    return $designation ? $designation->designation_id : null;
}

function getEmployeeDesignationName($employee, $date = null)
{
    $designation = getEmployeeDesignation($employee, $date);

    return $designation ? $designation->Designation->name.' ('.$designation->Designation->EmployeeCategory->name.')' : null;
}

function getEmployeeTerm($employee, $date = null)
{
    $date = ($date) ? : date('Y-m-d');

    return  $employee->EmployeeTerms->sortByDesc('date_of_joining')->filter(function ($term) use ($date) {
        return ($term->date_of_joining <= $date && (!$term->date_of_leaving || $term->date_of_leaving >= $date));
    })->first();
}

function isActiveEmployee($employee, $date = null)
{
    return getEmployeeTerm($employee, $date) ? true : false;
}

function amIClassTeacherOnDate($class_teachers, $date = null)
{
    $date = ($date) ? : date('Y-m-d');
    $employee_id = optional(\Auth::user()->Employee)->id;

    $class_teacher = $class_teachers->where('date_effective','<=',$date)->where('employee_id', $employee_id)->first();

    if (! $class_teacher) {
        return false;
    }

    $next_class_teacher = $class_teachers->where('employee_id', '!=', $employee_id)->where('date_effective','>',$class_teacher->date_effective)->where('date_effective','<=',$date)->first();

    if (! $next_class_teacher) {
        return true;
    }

    return false;
}

function amISubjectTeacherOnDate($subject_teachers, $date = null)
{
    $date = ($date) ? : date('Y-m-d');
    $employee_id = optional(\Auth::user()->Employee)->id;

    $subject_teacher = $subject_teachers->where('date_effective','<=',$date)->where('employee_id', $employee_id)->first();

    if (! $subject_teacher) {
        return false;
    }

    $next_subject_teacher = $subject_teachers->where('employee_id', '!=', $employee_id)->where('date_effective','>',$subject_teacher->date_effective)->where('date_effective','<=',$date)->first();

    if (! $next_subject_teacher) {
        return true;
    }

    return false;
}

/*
 *  Used to get children from tree structure
 *  @return array
 */

function getChilds($array, $currentParent = 1, $level = 1, $child = array(), $currLevel = 0, $prevLevel = -1)
{
    foreach ($array as $categoryId => $category) {
        if ($currentParent === $category['parent_id']) {
            if ($currLevel > $prevLevel) {
            }
            if ($currLevel === $prevLevel) {
            }
            $child[] = $categoryId;
            if ($currLevel > $prevLevel) {
                $prevLevel = $currLevel;
            }
            $currLevel++;
            if ($level) {
                $child = getChilds($array, $categoryId, $level, $child, $currLevel, $prevLevel);
            }
            $currLevel--;
        }
    }
    if ($currLevel === $prevLevel) {
    }
    return $child;
}

/*
 *  Used to get logo
 *  @return string
 */
function getLogo()
{
    if (config('config.logo') && \File::exists(config('config.logo'))) {
        return '<img style="max-width:125px;" src="'.url('/'.config('config.logo')).'">';
    } else {
        return '<img style="max-width:225px;" src="'.url('/images/default_logo.png').'">';
    }
}

function numberPadding($number, $length)
{
    return str_pad($number, $length, '0', STR_PAD_LEFT);
}

function getCurrentClassTeacherEmployeeId($class_teachers = array())
{
    $date = date('Y-m-d');
    $class_teacher = $class_teachers->sortByDesc('date_effective')->filter(function ($class_teacher) use ($date) {
        return ($class_teacher->date_effective <= $date);
    })->first();

    if ($class_teacher) {
        return $class_teacher->employee_id;
    }

    return null;
}

function getCurrentClassTeacher($batch, $class_teachers = array())
{
    $date = date('Y-m-d');
    $class_teacher = $class_teachers->sortByDesc('date_effective')->filter(function ($class_teacher) use ($date) {
        return ($class_teacher->date_effective <= $date);
    })->first();

    if ($class_teacher) {
        return $class_teacher->Employee->name_with_code;
    }

    return '-';
}

function getCurrentSubjectTeacher($batch, $subject_teachers = array())
{
    $date = date('Y-m-d');
    $subject_teacher = $subject_teachers->sortByDesc('date_effective')->filter(function ($subject_teacher) use ($date) {
        return ($subject_teacher->date_effective <= $date);
    })->first();

    if ($subject_teacher) {
        return $subject_teacher->Employee->name_with_code;
    }

    return '-';
}

function getTimetableStatus($timetable)
{
    $total = 0;
    $allocated = 0;

    foreach ($timetable->TimetableAllocations as $timetable_allocation) {
        foreach ($timetable_allocation->TimetableAllocationDetails as $timetable_allocation_detail) {
            if (! $timetable_allocation_detail->ClassTimingSession->is_a_break) {
                $total++;
                if ($timetable_allocation_detail->subject_id) {
                    $allocated++;
                }
            }
        }
    }

    return $allocated.'/'.$total;
}

function getSubjectTeacher($subject, $date = null)
{
    $date = $date ? $date : date('Y-m-d');
    $subject_teacher = $subject->SubjectTeachers->sortByDesc('date_effective')->filter(function ($subject_teacher) use ($date) {
        return ($subject_teacher->date_effective <= $date);
    })->first();

    if ($subject_teacher) {
        return $subject_teacher->Employee->name_with_code;
    }

    return '-';
}

function getLeaveRequestCount($leave_request)
{
    $holidays = $leave_request->getOption('holidays');
    $excluded_holiday = gv($holidays, 'excluded', []);
    $included_holiday = gv($holidays, 'included', []);
    $day = dateDiff($leave_request->start_date, $leave_request->end_date) + 1;
    return $day - count($excluded_holiday);
}

function getSelectedEmployee($employee)
{
    return ($employee) ? ['id' => $employee->id, 'name' => $employee->name.' ('.$employee->code.')'] : null;
}

function getPayrollNumber($number, $length = 3)
{
    return str_pad($number, $length, '0', STR_PAD_LEFT);
}

function isColumnVisible($column, $filter)
{
    if (! isset($filter['columns'])) {
        return true;
    }

    if (in_array($column, $filter['columns'])) {
        return true;
    }

    return false;
}

function createExcerpt( $content, $length = 20, $more = '...' ) {
    $excerpt = strip_tags( trim( $content ) );
    $words = str_word_count( $excerpt, 2 );
    if ( count( $words ) > $length ) {
        $words = array_slice( $words, 0, $length, true );
        end( $words );
        // $position = key( $words ) + strlen( current( $words ) );
        $position = key( $words );
        $excerpt = substr( $excerpt, 0, $position ) . $more;
    }
    return $excerpt;
}

function stripInlineStyle($content) {
    return preg_replace('/(<[^>]+) style=".*?"/i', '$1', $content);
}

function getPaymentGatewayHandlingFee($gateway, $amount) {
    if (! config('config.'.$gateway.'_charge_handling_fee'))
        return 0;

    if (config('config.'.$gateway.'_fixed_handling_fee'))
        return config('config.'.$gateway.'_handling_fee');
    else 
        return currency($amount * (config('config.'.$gateway.'_handling_fee') / 100));
}

function beginTransaction() {
    \DB::beginTransaction();
}

function rollBackTransaction() {
    \DB::rollBack();
}

function commitTransaction() {
    \DB::commit();
}

function calc( $mathString )
{
    $mathString = trim($mathString);
    $mathString = preg_replace('[^0-9\+-\*\/\(\) ]', '', $mathString);

    $compute = create_function("", "return (" . $mathString . ");" );
    return 0 + $compute();
}

function searchByKey($data, $key, $value)
{
    $index = array_search($value, array_column($data, $key));

    return ($index === FALSE) ? [] : $data[$index];
}

function currencyInWord(float $number)
{
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'one', 2 => 'two',
        3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
        7 => 'seven', 8 => 'eight', 9 => 'nine',
        10 => 'ten', 11 => 'eleven', 12 => 'twelve',
        13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
        40 => 'forty', 50 => 'fifty', 60 => 'sixty',
        70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
    $digits = array('', 'hundred','thousand','lakh', 'crore');
    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
    return ucwords(($Rupees ? $Rupees . 'Rupees ' : '') . $paise);
}

function getTransportFee($student_fee_record) {
    $transport_fee_detail = $student_fee_record->feeInstallment->transportFee->transportFeeDetails->firstWhere('transport_circle_id', $student_fee_record->transport_circle_id);

    return $transport_fee_detail ? currency($transport_fee_detail->amount,1) : null;
}