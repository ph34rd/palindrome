<?php

use Ph34rd\Palindrome\Palindrome;

if (! function_exists('palindrome_find')) {
	function palindrome_find($str, $useAsIs = false)
	{
		return Palindrome::find($str, $useAsIs);
	}
}
