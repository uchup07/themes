<?php
namespace Uchup07\Themes\Facades;

use Illuminate\Support\Facades\Facade;

class Theme extends Facade
{
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'uchup07.themes';
	}
}
