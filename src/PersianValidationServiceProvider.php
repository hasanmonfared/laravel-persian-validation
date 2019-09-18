<?php

namespace Sadegh19b\LaravelPersianValidation;

use Illuminate\Support\ServiceProvider;
use Validator;

/**
 * @author Sadegh Barzegar <sadegh19b@gmail.com>
 * @since September 18, 2019
 */
class PersianValidationServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    private $validatorsMap = [
        'persian_alpha'         => 'PersianAlpha',
        'persian_num'           => 'PersianNumber',
        'persian_alpha_num'     => 'PersianAlphaNumber',
        'persian_not_accept'    => 'PersianNotAccept',
        'ir_mobile'             => 'IranianMobile',
        'ir_phone'              => 'IranianPhone',
        'ir_phone_code'         => 'IranianPhoneAreaCode',
        'ir_phone_with_code'    => 'IranianPhoneWithAreaCode',
        'ir_postal_code'        => 'IranianPostalCode',
        'ir_card_number'        => 'IranianBankCardNumber',
        'ir_sheba'              => 'IranianBankSheba',
        'ir_national_code'      => 'IranianNationalCode',
        'a_url'                 => 'CheckUrl',
        'a_domain'              => 'CheckDomain',
    ];

    /**
     * Create Custom Persian Validation
     *
     * @return void
     */
    public function boot()
    {
        $vendorLangPath = $langLoaderPath = __DIR__.'/../lang/';
        $resourceLangPath = resource_path('lang/');
        $langFileName = 'persian-validation';
        $langNamespace = 'sbpValidation';

        // publish language file to resources/lang/{AppLocale}/persian-validation.php
        $this->publishes([ $vendorLangPath => $resourceLangPath ]);

        if (count(glob($resourceLangPath . "*/{$langFileName}.php")) !== 0)
            $langLoaderPath = $resourceLangPath;

        $this->loadTranslationsFrom($langLoaderPath, $langNamespace);

        foreach($this->validatorsMap as $name => $method)
        {
            Validator::extend($name, PersianValidators::class."@validate{$method}",
                              __("{$langNamespace}::{$langFileName}.{$name}"));
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
