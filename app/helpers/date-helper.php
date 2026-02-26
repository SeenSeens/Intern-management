<?php
namespace InternManagement\App\Helpers;

use DateTime;
use DateTimeZone;
if ( ! defined( 'ABSPATH' ) ) exit;
class DateHelper {

    public static function formatDatetimeLocal(string $input, string $format = 'Y-m-d', string $time = '00:00:00'){
        $input = sanitize_text_field($input);
        if (empty($input)) return null;
        $timezone = new DateTimeZone('Asia/Ho_Chi_Minh');
        $datetime = DateTime::createFromFormat($format, $input, $timezone);
        if (!$datetime) return null;
        if ($time !== '00:00:00') {
            $parts = explode(':', $time);
            if (count($parts) === 3) $datetime->setTime((int)$parts[0], (int)$parts[1], (int)$parts[2]);
        }
        return $datetime->format('Y-m-d H:i:s');
    }
}
