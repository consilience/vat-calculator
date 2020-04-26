<?php

namespace Sprocketbox\VatCalculator\Validators;

use Illuminate\Validation\Validator;
use Sprocketbox\VatCalculator\Exceptions\VATCheckUnavailableException;
use Sprocketbox\VatCalculator\Facades\VatCalculator;

class VatCalculatorValidatorExtension
{
    /**
     * Usage: vat_number.
     *
     * @param string $attribute
     * @param mixed  $value
     * @param array  $parameters
     * @param $validator
     *
     * @return bool
     */
    public function validateVatNumber($attribute, $value, $parameters, $validator)
    {
        $validator->setCustomMessages([
            'vat_number' => $validator->getTranslator()->get('vatnumber-validator::validation.vat_number'),
        ]);

        try {
            return VatCalculator::isValidVATNumber($value);
        } catch (VATCheckUnavailableException $e) {
            return false;
        }
    }
}
