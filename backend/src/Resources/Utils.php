<?php 

namespace App\Resources;

use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use InvalidArgumentException;

/**
 * @package namespace
 *
 * Class Utils
 *
 * @author Anailson Mota mota.a.santos@gmail.com
 * 
 * @version 1.0.0
 */ 
class Utils { 


	/**
	 * Construtor
	 *
	 * @param 
	 * @return 
	 * @throws 
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public static function createDateTime(string $sData): ?DateTimeInterface {
		if (empty($sData)) {
			return null;
		}

		try {
			return self::createDateTimeFromFormat($sData, "Y-m-d");
		} catch (Exception $e) { }

		try {
			return self::createDateTimeFromFormat($sData, "d/m/Y");
		} catch (Exception $e) { }

		throw new InvalidArgumentException("Não foi possível construir a data: \"$sData\".");
	}

	/**
	 * 
	 *
	 * @param 
	 * @return 
	 * @throws 
	 *
	 * @author Anailson Mota mota.a.santos@gmail.com
	 * @since 1.0.0
	 */
	public static function createDateTimeFromFormat(string $sData, string $sFormato): DateTimeInterface {
		$mData = DateTimeImmutable::createFromFormat($sFormato, $sData);
		if ($mData instanceof DateTimeInterface) {
			return $mData;
		}
		throw new InvalidArgumentException("Não foi possível construir a data: \"$sData\".");
	}
}