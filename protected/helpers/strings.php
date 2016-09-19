<?php
/* * ********************************************************************************************
 *								Open Business Card
 *								----------------
 * 	version				:	1.5.1
 * 	copyright			:	(c) 2016 Monoray
 * 							http://monoray.net
 *							http://monoray.ru
 * 
 * 	contact us			:	http://monoray.net/contact
 *							http://monoray.ru/contact
 *
 * 	license:			:	http://open-real-estate.info/en/license
 * 							http://open-real-estate.info/ru/license
 *
 * This file is part of Open Business Card
 *
 * ********************************************************************************************* */


function truncateText($text, $numOfWords = 10, $add = ''){
	if($numOfWords){
		$text = strip_tags($text, '<br/>');
		$text = str_replace(array("\r", "\n"), '', $text);

		$lenBefore = strlen($text);
		if($numOfWords){
			if(preg_match("/(\S+\s*){0,$numOfWords}/", $text, $match))
				$text = trim($match[0]);
			if(strlen($text) != $lenBefore){
				$text .= ' ... '.$add;
			}
		}
	}

	return $text;
}

function utf8_substr($str, $from, $len) {
	return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'.
	'((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s',
	'$1',$str);
}

function utf8_strlen($s) {
	return preg_match_all('/./u', $s, $tmp);
}

function utf8_ucfirst($string, $e ='utf-8') {
    if (function_exists('mb_strtoupper') && function_exists('mb_substr') && !empty($string)) {
        $string = mb_strtolower($string, $e);
        $upper = mb_strtoupper($string, $e);
            preg_match('#(.)#us', $upper, $matches);
            $string = $matches[1] . mb_substr($string, 1, mb_strlen($string, $e), $e);
    }
    else {
        $string = ucfirst($string);
    }
    return $string;
}

function utf8_strtolower($string, $e ='utf-8') {
	if (function_exists('mb_strtolower')) {
		$string = mb_strtolower($string, $e);
	}
	else {
		$string = strtolower($string);
	}
	return $string;
}

function translit($str, $separator = 'dash', $lowercase = TRUE, $removespace = TRUE)
{
    $str = strip_tags($str);

	$foreign_characters = array(
		'/ä|æ|ǽ/' => 'ae',
		'/ö|œ/' => 'oe',
		'/ü/' => 'ue',
		'/Ä/' => 'Ae',
		'/Ü/' => 'Ue',
		'/Ö/' => 'Oe',
		'/À|Á|Â|Ã|Ä|Å|Ǻ|Ā|Ă|Ą|Ǎ|А/' => 'A',
		'/à|á|â|ã|å|ǻ|ā|ă|ą|ǎ|ª|а/' => 'a',
		'/Б/' => 'B',
		'/б/' => 'b',
		'/Ç|Ć|Ĉ|Ċ|Č|Ц/' => 'C',
		'/ç|ć|ĉ|ċ|č|ц/' => 'c',
		'/Ð|Ď|Đ|Д/' => 'D',
		'/ð|ď|đ|д/' => 'd',
		'/È|É|Ê|Ë|Ē|Ĕ|Ė|Ę|Ě|Е|Ё|Э/' => 'E',
		'/è|é|ê|ë|ē|ĕ|ė|ę|ě|е|ё|э/' => 'e',
		'/Ф/' => 'F',
		'/ф/' => 'f',
		'/Ĝ|Ğ|Ġ|Ģ|Г/' => 'G',
		'/ĝ|ğ|ġ|ģ|г/' => 'g',
		'/Ĥ|Ħ|Х/' => 'H',
		'/ĥ|ħ|х/' => 'h',
		'/Ì|Í|Î|Ï|Ĩ|Ī|Ĭ|Ǐ|Į|İ|И/' => 'I',
		'/ì|í|î|ï|ĩ|ī|ĭ|ǐ|į|ı|и/' => 'i',
		'/Ĵ|Й/' => 'J',
		'/ĵ|й/' => 'j',
		'/Ķ|К/' => 'K',
		'/ķ|к/' => 'k',
		'/Ĺ|Ļ|Ľ|Ŀ|Ł|Л/' => 'L',
		'/ĺ|ļ|ľ|ŀ|ł|л/' => 'l',
		'/М/' => 'M',
		'/м/' => 'm',
		'/Ñ|Ń|Ņ|Ň|Н/' => 'N',
		'/ñ|ń|ņ|ň|ŉ|н/' => 'n',
		'/Ò|Ó|Ô|Õ|Ō|Ŏ|Ǒ|Ő|Ơ|Ø|Ǿ|О/' => 'O',
		'/ò|ó|ô|õ|ō|ŏ|ǒ|ő|ơ|ø|ǿ|º|о/' => 'o',
		'/П/' => 'P',
		'/п/' => 'p',
		'/Ŕ|Ŗ|Ř|Р/' => 'R',
		'/ŕ|ŗ|ř|р/' => 'r',
		'/Ś|Ŝ|Ş|Š|С/' => 'S',
		'/ś|ŝ|ş|š|ſ|с/' => 's',
		'/Ţ|Ť|Ŧ|Т/' => 'T',
		'/ţ|ť|ŧ|т/' => 't',
		'/Ù|Ú|Û|Ũ|Ū|Ŭ|Ů|Ű|Ų|Ư|Ǔ|Ǖ|Ǘ|Ǚ|Ǜ|У/' => 'U',
		'/ù|ú|û|ũ|ū|ŭ|ů|ű|ų|ư|ǔ|ǖ|ǘ|ǚ|ǜ|у/' => 'u',
		'/В/' => 'V',
		'/в/' => 'v',
		'/Ý|Ÿ|Ŷ|Ы/' => 'Y',
		'/ý|ÿ|ŷ|ы/' => 'y',
		'/Ŵ/' => 'W',
		'/ŵ/' => 'w',
		'/Ź|Ż|Ž|З/' => 'Z',
		'/ź|ż|ž|з/' => 'z',
		'/Æ|Ǽ/' => 'AE',
		'/ß/'=> 'ss',
		'/Ĳ/' => 'IJ',
		'/ĳ/' => 'ij',
		'/Œ/' => 'OE',
		'/ƒ/' => 'f',
		'/Ч/' => 'Ch',
		'/ч/' => 'ch',
		'/Ю/' => 'Ju',
		'/ю/' => 'ju',
		'/Я/' => 'Ja',
		'/я/' => 'ja',
		'/Ш/' => 'Sh',
		'/ш/' => 'sh',
		'/Щ/' => 'Shch',
		'/щ/' => 'shch',
		'/Ж/' => 'Zh',
		'/ж/' => 'zh',
	);

	$str = preg_replace(array_keys($foreign_characters), array_values($foreign_characters), $str);

	$replace = ($separator == 'dash') ? '-' : '_';

	$trans = array(
		'&\#\d+?;'                => '',
		'&\S+?;'                => '',
		'_+'            => $replace,
		$replace.'+'            => $replace,
		$replace.'$'            => $replace,
		'^'.$replace            => $replace,
		'\.+$'                    => ''
	);
	if ($removespace) {
		$trans['\s+'] = $replace;
		$trans['[^a-z0-9\-_]'] = '';
	}

	foreach ($trans as $key => $val) {
		$str = preg_replace("#".$key."#i", $val, $str);
	}

    $str = rtrim($str, $replace);

    if ($lowercase === TRUE)
	{
		if( function_exists('mb_convert_case') )
		{
			$str = mb_convert_case($str, MB_CASE_LOWER, "UTF-8");
		}
		else
		{
			$str = strtolower($str);
		}
	}

	$permitted_uri_chars = 'a-z 0-9~%.:_\-';

	$str = preg_replace('#[^'.$permitted_uri_chars.']#i', '', $str);

	return trim( stripslashes( substr($str, 0, 150) ) );
}

function cleanPostData($data){
	$data = trim($data);
	$data = strip_tags($data);
	$data = addslashes($data);
	$data = mb_strtolower($data, 'UTF-8');
	$data = preg_replace('~[^a-z0-9 \x80-\xFF]~i', "",$data);
	return $data;
}

function purify($text){
    $purifier = new CHtmlPurifier;
    $purifier->options = array(
        'AutoFormat.AutoParagraph' => true,
        //'HTML.Allowed'=>'p,ul,li,b,i,a[href],pre',
        'AutoFormat.Linkify'=>true,
        'HTML.Nofollow'=>true,
        'Core.EscapeInvalidTags'=>true,
    );

    return $purifier->purify($text);
}

function purifyForDemo($text){
    $purifier = new CHtmlPurifier;
    $purifier->options = array(
        'HTML.Allowed'=>'p,ul[style],ol,li,strong,b,em,span',
        'HTML.Nofollow'=>true,
        'Core.EscapeInvalidTags'=>true,
    );

    return $purifier->purify($text);
}

function cleanArrayToSearch($words = array(), $max = 0, $min_length){
	$result = array();
	$i = 0;
	foreach($words as $key => $value){
		if(strlen(trim($value)) >= $min_length){
			$i++;
			if($i <= $max){
				$result[] = trim($value);
			}
		}
	}
	return $result;
}

function highlightKeywords($string, $keywords) {
	if ($keywords != "" || $keywords != NULL) {
		$words = explode(" ", $keywords);
		foreach ($words as $word) {
			$position = 0;
			while ($position !== false) {
				$position = strpos(strtolower($string), strtolower($word), $position);
				if ($position !== false) {
					$replace_string = substr($string, $position, strlen($word));
					$replace_string = "<span class=\"highlight\">" . $replace_string . "</span>";
					$string = substr_replace($string, $replace_string, $position, strlen($word));
					$position = $position + strlen($replace_string);
				}
			}
		}
	}
	return $string;
}

function highlightContent($wordsArr = array(), $string = '', $highlightClass = 'highlight') {
	//return utf8_substr(strip_tags(nl2br($string)), 0, 300).'...';

	$compareWords = implode('|', $wordsArr);

	if ($compareWords && $string) {
		$reg = '/(.{0,80})('.$compareWords.')(.*)$/isUu';

		if(preg_match($reg, strip_tags(nl2br($string)), $text))
			$content = '...'.preg_replace('/('.$compareWords.')/isUu','<span class="'.$highlightClass.'">$1</span>', utf8_substr(strip_tags(nl2br($text[0])), 0, 300)).'...';
		else
			$content = utf8_substr(strip_tags(nl2br($string)), 0, 300).'...';

		return $content;
	}
	return $string;
}