<?php
namespace Joomla\Component\Kwpanorama\Administrator\Helper;


// No direct access to this file
defined('_JEXEC') or die('Restricted access');

//require_once 'ckuri.php';

//use Joomla\CMS\Language\Text as CKText;
 use Joomla\CMS\Uri\Uri ;
 use Joomla\CMS\HTML\HTMLHelper;
 use Joomla\CMS\Factory;
//use \Carouselck\CKUri;
HTMLHelper::_('jquery.framework');

/**
 * Framework Helper
 */
class KwpframeworkHelper {

	private static $assetsPath = '/administrator/components/com_kwpanorama/assets';

	private static $version = '1.0.0';

	private static $doload;
	
	private static $wa;

	public static function init() {
		global $kwpframeworkloaded;
		global $kwpframeworkloadedversion;
		self::$wa = Factory::getApplication()->getDocument()->getWebAssetManager();
//var_dump(self::$wa);
		// if the framework is already loaded with a same or better version, do nothing
		if ($kwpframeworkloaded && version_compare($kwpframeworkloadedversion, self::$version, '>=')) {
			self::$doload = false;
		}

		self::$doload = true;
	}

	public static function getInline() {
		if (self::$doload === false) return '';

		$assets = self::getInlineCss() . self::getInlineJs();

		return $assets;
	}

	public static function getInlineCss() {
		if (self::$doload === false) return '';

		$assets = '<link rel="stylesheet" href="' . Uri::root(true) .  'administrator/components/com_kwpanorama/assets/css/kwpframework.css" type="text/css" />';

		return $assets;
	}

	public static function getInlineJs() {
		if (self::$doload === false) return '';

		$assets = '<script src="' . Uri::root(true) . 'administrator/components/com_kwpanorama/assets/js/kwpframework.js" type="text/javascript"></script>';

		return $assets;
	}

	public static function loadInline() {
		echo self::getInline();
	}

	public static function load() {
		if (self::$doload === false) return;

		//HTMLHelper::_('jquery.framework');
		$this->wa->registerAndUseStyle('kwpframeworkcss',Uri::root(true) . self::$assetsPath . '/css/kwpframework.css' );
		$this->wa->registerAndUseScript('kwpframeworkjs',Uri::root(true) . self::$assetsPath . '/js/kwpframework.js' );
		/*$doc = Factory::getDocument();
		$doc->addStylesheet(CKUri::root(true) . self::$assetsPath . '/ckframework.css');
		$doc->addScript(CKUri::root(true) . self::$assetsPath . '/ckframework.js');*/
	}

	public static function loadCss() {
		if (self::$doload === false) return;
        		self::$wa->registerAndUseStyle('kwpframeworkcss',Uri::root(true) . self::$assetsPath . '/css/kwpframework.css' );
//var_dump(Uri::root(true) . self::$assetsPath . '/css/kwpframework.css');
		//$doc = \Joomla\CMS\Factory::getDocument();
		//$doc->addStylesheet(Uri::root(true) . self::$assetsPath . '/css/kwpframework.css');
	}

	public static function loadJs() {
		if (self::$doload === false) return;
		$this->wa->registerAndUseScript('kwpframeworkjs',Uri::root(true) . self::$assetsPath . '/js/kwpframework.js' );
/*
		$doc = \Joomla\CMS\Factory::getDocument();
		$doc->addScript(CKUri::root(true) . self::$assetsPath . '/ckframework.js');*/
	}

	public static function getFaIconsInline() {
		return '<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous" />';
	}

	public static function loadFaIconsInline() {
		echo self::getFaIconsInline();
	}

	/*
	 * Load the JS and CSS files needed to use CKBox
	 *
	 * Return void
	 */
	public static function loadCkbox() {
		//$doc = \Joomla\CMS\Factory::getDocument();
		//HTMLHelper::_('jquery.framework');
				$this->wa->registerAndUseScript('kwpboxjs',Uri::root(true) . self::$assetsPath . '/js/panobox.js' );
				$this->wa->registerAndUseStyle('kwpboxcss',Uri::root(true) . self::$assetsPath . '/css/panobox.css' );


		//$doc->addStyleSheet(CKUri::root(true) . self::$assetsPath . '/ckbox.css');
		//$doc->addScript(CKUri::root(true) . self::$assetsPath . '/ckbox.js');
	}
}

KwpframeworkHelper::init();