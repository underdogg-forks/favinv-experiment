<?php

return [
    App\Plugins\Stripe\ServiceProvider::class,
    App\Plugins\Razorpay\ServiceProvider::class,
    App\Providers\AppServiceProvider::class,
    App\Providers\AuthServiceProvider::class,
    App\Providers\EventServiceProvider::class,
    App\Providers\HorizonServiceProvider::class,
    App\Providers\RouteServiceProvider::class,
    App\Providers\CustomValidationProvider::class,
    App\Providers\ImageUploadHelperServiceProvider::class,
    App\Providers\AttachmentHelperServiceProvider::class,
    App\Plugins\Recaptcha\RecaptchaServiceProvider::class,
];
