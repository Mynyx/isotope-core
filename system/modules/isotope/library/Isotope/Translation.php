<?php

/**
 * Isotope eCommerce for Contao Open Source CMS
 *
 * Copyright (C) 2009-2014 terminal42 gmbh & Isotope eCommerce Workgroup
 *
 * @package    Isotope
 * @link       http://isotopeecommerce.org
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */

namespace Isotope;

use Isotope\Model\Label;

/**
 * Translates labels
 *
 * @author Yanick Witschi <yanick.witschi@terminal42.ch>
 */
class Translation
{

    /**
     * Labels
     * @var array
     */
    protected static $arrLabels = array();

    /**
     * Labels loaded
     * @var array
     */
    protected static $arrLoaded = array();

    /**
     * Get a translation of a value using the translation label
     *
     * @param mixed  $varLabel
     * @param string $strLanguage
     *
     * @return mixed
     */
    public static function get($varLabel, $strLanguage = null)
    {
        if (!\Database::getInstance()->tableExists(Label::getTable())) {
            return $varLabel;
        }

        if (null === $strLanguage) {
            $strLanguage = $GLOBALS['TL_LANGUAGE'];
        }

        // Convert Language Tag to Locale ID
        $strLanguage = str_replace('-', '_', $strLanguage);

        // Recursively translate label array
        if (is_array($varLabel)) {
            foreach ($varLabel as $k => $v) {
                $varLabel[$k] = static::get($v, $strLanguage);
            }

            return $varLabel;
        }

        // Load labels
        static::initialize($strLanguage);

        $varLabel = \StringUtil::decodeEntities($varLabel);

        if (isset(static::$arrLabels[$strLanguage][$varLabel])) {
            return static::$arrLabels[$strLanguage][$varLabel];
        }

        return $varLabel;
    }

    /**
     * Add a translation that is not stored in translation table
     *
     * @param string $strLabel       The label
     * @param string $strReplacement The replacement
     * @param string $strLanguage    The language
     */
    public static function add($strLabel, $strReplacement, $strLanguage = null)
    {
        if (null === $strLanguage) {
            $strLanguage = $GLOBALS['TL_LANGUAGE'];
        }

        static::initialize($strLanguage);

        static::$arrLabels[$strLanguage][\StringUtil::decodeEntities($strLabel)] = $strReplacement;
    }

    /**
     * Initialize the data in translation table
     *
     * @param string $strLanguage The language
     */
    protected static function initialize($strLanguage = null)
    {
        if (null === $strLanguage) {
            $strLanguage = $GLOBALS['TL_LANGUAGE'];
        }

        if (!isset(static::$arrLoaded[$strLanguage])) {

            /** @var Label[]|\Model\Collection $objLabels */
            $objLabels = Label::findBy('language', $strLanguage);

            if (null !== $objLabels) {
                while ($objLabels->next()) {
                    static::$arrLabels[$strLanguage][\StringUtil::decodeEntities($objLabels->label)] = $objLabels->replacement;
                }
            }

            static::$arrLoaded[$strLanguage] = true;
        }
    }
}
