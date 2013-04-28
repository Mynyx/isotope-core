<?php

/**
 * Isotope eCommerce for Contao Open Source CMS
 *
 * Copyright (C) 2009-2012 Isotope eCommerce Workgroup
 *
 * @package    Isotope
 * @link       http://www.isotopeecommerce.com
 * @license    http://opensource.org/licenses/lgpl-3.0.html LGPL
 */

namespace Isotope\CheckoutStep;

use Isotope\Interfaces\IsotopeCheckoutStep;


class OrderConditionsAfterProducts extends OrderConditions implements IsotopeCheckoutStep
{

    /**
     * Returns true if order conditions should be after products
     * @return  bool
     */
    public function isAvailable()
    {
        if ($this->iso_order_conditions_position == 'after') {
            return true;
        }

        return false;
    }
}