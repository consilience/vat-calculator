<?php

Route::get('vatcalculator/tax-rate-for-location/{country?}/{postal_code?}', 'Sprocketbox\VatCalculator\Http\Controller@getTaxRateForLocation');
Route::get('vatcalculator/calculate', 'Sprocketbox\VatCalculator\Http\Controller@calculateGrossPrice');
Route::get('vatcalculator/country-code', 'Sprocketbox\VatCalculator\Http\Controller@getCountryCode');
Route::get('vatcalculator/validate-vat-id/{vat_id}', 'Sprocketbox\VatCalculator\Http\Controller@validateVATID');
