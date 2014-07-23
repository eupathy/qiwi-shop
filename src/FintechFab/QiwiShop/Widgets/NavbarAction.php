<?php
namespace FintechFab\QiwiShop\Widgets;

use URL;

class NavbarAction
{

	/**
	 * @param $url
	 *
	 * @return string
	 */
	public static function isActive($url)
	{
		if (URL::current() == $url) {
			return 'active';
		}

		return '';
	}

	/**Возвращает ссылку для логина
	 *
	 * @return string
	 */
	public static function url2Sign()
	{
		$url = URL::route('registration') . '?' . http_build_query(array(
				'back' => urlencode(URL::current()),
			));

		return $url;
	}


} 