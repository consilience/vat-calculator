<?php

Route::get('vatcalculator/tax-rate-for-location/{country?}/{postal_code?}', 'Consilience\VatCalculator\Controllers\Controller@getTaxRateForLocation');
Route::get('vatcalculator/calculate', 'Consilience\VatCalculator\Controllers\Controller@calculateGrossPrice');
Route::get('vatcalculator/country-code', 'Consilience\VatCalculator\Controllers\Controller@getCountryCode');
Route::get('vatcalculator/validate-vat-id/{vat_id}', 'Consilience\VatCalculator\Controllers\Controller@validateVATID');
