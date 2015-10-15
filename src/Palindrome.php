<?php

namespace Ph34rd\Palindrome;

// поиск полиндрома по алгоритму Манакера
// https://en.wikipedia.org/wiki/Longest_palindromic_substring
// на вход принимаются строки в utf-8
class Palindrome {

	public static function find($str, $useAsIs = false) {
		if (!$useAsIs) {
			// конвертируем строку в нижний регистр
			$str = mb_strtolower($str, 'UTF-8');
			// оставляем в строке тольцо буквы и цифры
			$str = preg_replace('/[^\w]+/u', '', $str);
		}

		// проверяем длину оставшейся строки
		$len = mb_strlen($str, 'UTF-8');

		// пустую строку или единичной длины возвращаем как есть
		if ($len === 0 || $len === 1) {
			return $str;
		}

		// кодируем строку в UTF-32 big endian, для постоянной длины в байтах
		$fixed = mb_convert_encoding($str, 'UTF-32BE', 'UTF-8');
		$pLen = ($len+1)*2+1;
		$p = new \SplFixedArray($pLen); // фиксированный массив для записи промежуточных результатов

		$center = 0;
		$r = 0;

		for ($i = 1; $i < $pLen-1; $i++) {
			$i_mirror = 2*$center-$i;

			$p[$i] = ($r > $i) ? min($r-$i, $p[$i_mirror]) : 0;

			// пробуем расшириться от центра
			while (true) {
				$m = $i + 1 + $p[$i];
				$n = $i - 1 - $p[$i];

				if ($m === ($pLen-1)) break;
				if ($n === 0) break;

				if (!($m % 2)) {
					// проверка символа
					$offsetM = ($m/2-1)*4;
					$offsetN = ($n/2-1)*4;
					if (ord($fixed[$offsetM]) !== ord($fixed[$offsetN]) ||
						ord($fixed[$offsetM+1]) !== ord($fixed[$offsetN+1]) ||
						ord($fixed[$offsetM+2]) !== ord($fixed[$offsetN+2]) ||
						ord($fixed[$offsetM+3]) !== ord($fixed[$offsetN+3])) {

						break;
					}
				}
				$p[$i] = $p[$i]+1;
			}

			// расширяем r если i центр палиндрома
			if ($i + $p[$i] > $r) {
				$center = $i;
				$r = $i + $p[$i];
			}
		}

		// ищем первый палиндром максимальной длинны
		$maxLen = 0;
		$center = 0;
		for ($i = 1; $i < $pLen-1; $i++) {
			if ($p[$i] > $maxLen) {
				$maxLen = $p[$i];
				$center = $i;
			}
		}

		// возвращаем подстроку
		return mb_substr($str, ($center-1-$maxLen)/2, $maxLen, 'UTF-8');
	}

}
