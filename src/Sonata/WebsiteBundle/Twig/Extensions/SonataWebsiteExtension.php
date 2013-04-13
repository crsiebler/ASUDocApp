<?php

namespace Sonata\WebsiteBundle\Twig\Extensions;

class SonataWebsiteExtension extends \Twig_Extension {

    public function getFilters() {
        return array(
            'phone' => new \Twig_Filter_Method($this, 'phoneNumberFormat'),
            'percent' => new \Twig_Filter_Method($this, 'percentageFormat'),
            'money_format' => new \Twig_Filter_Method($this, 'moneyFormat'),
        );
    }

    public function phoneNumberFormat($phoneNumber) {
        if (is_numeric($phoneNumber)) {
            if (strlen($phoneNumber) === 10) {
                return '('.substr($phoneNumber, 0, 3).') '.substr($phoneNumber, 3, 3).'-'.substr($phoneNumber, -4);
            } elseif (strlen($phoneNumber) === 7) {
                return substr($phoneNumber, 3, 3).'-'.substr($phoneNumber, -4);
            } else {
                return $phoneNumber;
            }
        } else {
            return $phoneNumber;
        }
    }

    public function percentageFormat($number) {
        if (is_numeric($number)) {
            return number_format($number, 2).'%';
        } else {
            return $number;
        }
    }

    public function moneyFormat($number, $decimals = 2, $decPoint = '.', $thousandsSep = ',') {
        if (is_numeric($number)) {
            return '$'.number_format($number, $decimals, $decPoint, $thousandsSep);
        } else {
            return $number;
        }
    }

    public function getName() {
        return 'sonata_website_extension';
    }

}

?>