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


/**
 * Register PSR-0 namespace
 */
if (class_exists('NamespaceClassLoader')) {
    NamespaceClassLoader::add('Isotope', 'system/modules/isotope_rules/library');
}


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
    'iso_coupons'    => 'system/modules/isotope_rules/templates',
));
