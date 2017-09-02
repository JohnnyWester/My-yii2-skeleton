<?php

namespace app\helpers;

class DateUtils {

	const FORMAT_DEFAULT = 'Y-m-d H:i:s';
	const START_DATE = 'Y-m-d 00:00:00';
	const FORMAT_DEFAULT_DATE = 'Y-m-d';
	const FORMAT_HUMAN_D = 'M d, Y';
	const FORMAT_HUMAN_DT = 'M d, Y H:i:s';
	const FORMAT_HUMAN_DT_SHORT = 'm/d/y H:i';
	const FORMAT_HUMAN_DTZ = 'M d, Y H:i:s T';
	const FORMAT_MDY_SLASH = 'm/d/Y';
	const FORMAT_DATE_PICKER = 'm/d/Y';
	const RANGE_SEPARATOR = ' - ';
	const FORMAT_POG = 'd/M/Y';
	const FORMAT_FOLDER = 'ymd';
	const FORMAT_RUS = 'd/m/Y';
	const FORMAT_RUS_DATETIME = 'd/m/Y H:i';


	/**
	 * @param string $to
	 * @param string $sqldate
	 * @return string
	 */
	public static function getFromSqleDate($sqldate, $to = self::FORMAT_POG)
	{
		if ($sqldate === '0000-00-00 00:00:00' || $sqldate === null) {
			$formattedDate = '';//empty string if no value in DB or new record
		} else {
			$date = \DateTime::createFromFormat('Y-m-d H:i:s', $sqldate);
			$formattedDate = $date->format($to);
		}

		return $formattedDate;
	}

	/**
	 * @param string $date
	 * @param string $format
	 * @return string
	 */
	public static function getFromFormatTosql($date, $format = self::FORMAT_POG)
	{
		if (empty($date)) {
			$sqldate = '0000-00-00 00:00:00';
		} else {
			$date = \DateTime::createFromFormat($format, $date);
			$sqldate = $date->format('Y-m-d H:i:s');
		}

		return $sqldate;
	}


	/**
	 *
	 * @return string
	 */
	public static function getUserTimezone() {
		$officeTimezone = false;
		if (!empty(\Yii::$app->user->identity->timezone)) {
			$officeTimezone = \Yii::$app->user->identity->timezone;
		}

		if (empty($officeTimezone)) {
			$officeTimezone = date_default_timezone_get();
		}

		return $officeTimezone;
	}

	/**
	 *
	 * @param integer $stamp unix timastamp
	 * @return \DateTime
	 */
	public static function createDtFromTimeStamp($stamp) {
		$dt = new \DateTime;
		$dt->setTimestamp($stamp);
		return $dt;
	}


	/**
	 *
	 * @param integer $stamp
	 * @param string $format
	 * @return string
	 */
	public static function formatTimeStamp($stamp, $format = self::FORMAT_DEFAULT) {
		$dt = self::createDtFromTimeStamp($stamp);
		return $dt->format($format);
	}

	/**
	 *
	 * @param type $date
	 * @return string Formated date - M d, Y H:i:s
	 */
	public static function renderDateTime($date, $format = self::FORMAT_HUMAN_DTZ) {
		$dateTime = new \DateTime($date, new \DateTimeZone('UTC'));
		$dateTime->setTimezone(new \DateTimeZone(self::getUserTimezone()));
		return $dateTime->format($format);
	}

	/**
	 *
	 * @param type $date
	 * @return string Formated date - M d, Y H:i:s
	 */
	public static function renderDateTimeWise($date) {
		$dNow = self::renderDateTime('NOW', self::FORMAT_DEFAULT);
		$dDate = self::renderDateTime($date, self::FORMAT_DEFAULT);

		if ( substr($dNow, 0, 10) == substr($dDate, 0, 10) ) {
			$template = 'H:i';
		}
		else if ( substr($dNow, 0, 7) == substr($dDate, 0, 7) ) {
			$template = 'd, H:i';
		}
		else if ( substr($dNow, 0, 4) == substr($dDate, 0, 4) ) {
			$template = 'M d, H:i';
		}
		else {
			$template = 'M d, Y H:i';
		}

		return self::renderDateTime($date, $template);
	}


	/**
	 * Get formatted date from date string
	 * @param $date - may contain the name of the month(easy for datepicker)
	 * @param string $format
	 * @return string - formatted date
	 */
	public static function getFormatFromAnyString($date, $format = self::FORMAT_DEFAULT) {
		return date($format, strtotime($date));
	}

	public static function getDateFromDatePicker($date, $format = self::FORMAT_DATE_PICKER) {
        $aDate = date_parse_from_format(self::FORMAT_DATE_PICKER, $date);
		return $aDate['year'] . '-' . str_pad($aDate['month'], 2, "0", STR_PAD_LEFT) . '-' . str_pad($aDate['day'], 2, "0", STR_PAD_LEFT). ' 00:00:00';
	}


	/**
	 *
	 * @param type $date
	 * @return string Formated date - M d, Y
	 */
	public static function renderDate($date) {
		return date(self::FORMAT_HUMAN_D, strtotime($date));
	}

	public static function renderDateRus($date) {
        setlocale(LC_TIME , null);
		//return strftime ('%d/%m/ %Y', strtotime($date));
        return date(self::FORMAT_RUS, strtotime($date));
	}
	public static function renderDateTimeRus($date) {
        setlocale(LC_TIME , null);
        return date(self::FORMAT_RUS_DATETIME, strtotime($date));
	}


	/**
	 *
	 */
	public static function getMonthOptions() {
		return [
			'' => '',
			'01' => '01',
			'02' => '02',
			'03' => '03',
			'04' => '04',
			'05' => '05',
			'06' => '06',
			'07' => '07',
			'08' => '08',
			'09' => '09',
			'10' => '10',
			'11' => '11',
			'12' => '12',
		];
	}


	/**
	 *
	 */
	public static function getYearOptions() {
		return [
			'' => '',
			'2015' => '2015',
			'2016' => '2016',
			'2017' => '2018',
		];
	}

	/**
	 *
	 * @return array
	 */
	public static function getDefaultRange($format = self::FORMAT_DEFAULT_DATE) {
		$from = new \DateTime();
//		$from->modify('-1 month');
		$from->modify('first day of this month');
		$fromDate = $from->setTime(0, 0, 0)->format($format);

		$to = new \DateTime();
//		$to->modify('-1 month');
		$to->modify('last day of this month');
		$toDate = $to->setTime(23, 59, 59)->format($format);

		return [
			$fromDate,
			$toDate,
			$from->format($format) . ' - ' . $to->format($format)
		];
	}

	/**
	 *
	 * @param string $range
	 * @return array
	 */
	static function parseAnyRangeToDefault($range, $format = DateUtils::FORMAT_DEFAULT) {
		$dates = explode(' - ', $range);
		if (is_array($dates) && count($dates) == 2) {
			// non UTC standard convert
			if ( strpos($dates[0], '/') !== false ) {
				$fromDateTime = new \DateTime();
				$fromDateTime->setTimestamp( strtotime($dates[0]) );

				$toDateTime = new \DateTime();
				$toDateTime->setTimestamp( strtotime($dates[1]) );

				if ( is_a($fromDateTime, 'DateTime') ) {
					$from = $fromDateTime->format(DateUtils::FORMAT_DEFAULT);
				}
				if ( is_a($toDateTime, 'DateTime') ) {
					$to = $toDateTime->setTime(23, 59, 59)->format(DateUtils::FORMAT_DEFAULT);
				}
			}
			else {  // UTC not convert needed
				$from = $dates[0];
				$to = $dates[1];
			}
			if ($from && $to) {
				return array($from, $to);
			}
			else {
				return false;
			}
		}
		else {
			return false;
		}
	}

	/**
	 *
	 * @param string $range
	 * @return array
	 */
	static function parseDatesRange($range, $format = DateUtils::FORMAT_MDY_SLASH) {
		$dates = explode(' - ', $range);
		if (is_array($dates) && count($dates) == 2) {
			$from = new \DateTime();
			$from->setTimestamp( strtotime($dates[0]) );

			$to = new \DateTime();
			$to->setTimestamp( strtotime($dates[1]) );

			if (!$from || !$to) {
				list ($from, $to) = self::rangeFromNow('-365 day');
				return self::formatDatesRange($from, $to, DateUtils::FORMAT_DEFAULT);
			}
		}
		else {
			list ($from, $to) = self::rangeFromNow('-365 day');
		}
		return self::formatDatesRange($from, $to, DateUtils::FORMAT_DEFAULT);
	}

	/**
	 *
	 * @param string $modify
	 * @return array
	 */
	public static function rangeFromNow($modify) {
		$from = new \DateTime();
		$to = new \DateTime();
		$from->modify($modify);
		return array($from, $to);
	}

	/**
	 *
	 * @param DateTime $from
	 * @param DateTime $to
	 * @param string $format
	 * @return array
	 */
	public static function formatDatesRange($from, $to, $format) {
		return array($from->setTime(0, 0, 0)->format($format), $to->setTime(23, 59, 59)->format($format));
	}

	/**
	 *
	 * @param string $dateTime
	 * @return \DateTime
	 */
	public static function getDateTimeUTC($dateTime = null) {
		$dateTimeUTC = new \DateTime($dateTime, new \DateTimeZone('UTC'));
		return $dateTimeUTC;
	}

	public static function getTimestampUTC($dateTime = null)
	{
        $dateObj = DateUtils::getDateTimeUTC($dateTime);
        return $dateObj->getTimestamp();
	}

	/**
	 *
	 * @param string $format
	 * @return string
	 */
	public static function getDateTimeUTCformated($format = self::FORMAT_DEFAULT) {
		$dateTimeUTC = self::getDateTimeUTC();
		return $dateTimeUTC->format($format);
	}


	/**
	 * @param bool|true $value_key Value = key array
	 *
	 * @return array
	 */
	public static function getTimeZoneList($value_key = true) {
		$time_zone_list = [];

		if ($value_key) {
			foreach (\DateTimeZone::listIdentifiers() as $k_zone => $v_zone) {
				$time_zone_list[$v_zone] = $v_zone;
			}
		}
		else {
			$time_zone_list = \DateTimeZone::listIdentifiers();
		}

		return $time_zone_list;

	}


    /**
     * Возвращает DayDate для начала дня
     * @return bool|\DateTime
     */
	public static function startDayDateTime()
	{
        $today = date('d.m.Y');

        return \DateTime::createFromFormat('d.m.Y H:i:s', $today . ' 00:00:00');
	}
}
