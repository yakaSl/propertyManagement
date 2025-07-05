<?php

use App\Models\Custom;
use App\Models\LoggedHistory;
use App\Models\Subscription;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Property;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

if (!function_exists('settingsKeys')) {
    function settingsKeys()
    {
        return $settingsKeys = [
            "app_name" => "",
            "theme_color" => "color1",
            "color_type" => "default",
            "own_color" => "",
            "own_color_code" => "",
            "sidebar_mode" => "light",
            "layout_direction" => "ltrmode",
            "layout_mode" => "lightmode",
            "company_logo" => "logo.png",
            "company_favicon" => "favicon.png",
            "landing_logo" => "landing_logo.png",
            "meta_seo_title" => "",
            "meta_seo_keyword" => "",
            "meta_seo_description" => "",
            "meta_seo_image" => "",
            "company_date_format" => "M j, Y",
            "company_time_format" => "g:i A",
            "company_name" => "",
            "company_phone" => "",
            "company_address" => "",
            "company_email" => "",
            "company_email_from_name" => "",
            "google_recaptcha" => "off",
            "recaptcha_key" => "",
            "recaptcha_secret" => "",
            "landing_page" => "on",
            "register_page" => "on",
            'SERVER_DRIVER' => "",
            'SERVER_HOST' => "",
            'SERVER_PORT' => "",
            'SERVER_USERNAME' => "",
            'SERVER_PASSWORD' => "",
            'SERVER_ENCRYPTION' => "",
            'FROM_EMAIL' => "",
            'FROM_NAME' => "",
            "invoice_number_prefix" => "#INV-000",
            "expense_number_prefix" => "#EXP-000",
            'CURRENCY' => "USD",
            'CURRENCY_SYMBOL' => "$",
            'STRIPE_PAYMENT' => "off",
            'STRIPE_KEY' => "",
            'STRIPE_SECRET' => "",
            "paypal_payment" => "off",
            "paypal_mode" => "",
            "paypal_client_id" => "",
            "paypal_secret_key" => "",
            "bank_transfer_payment" => "off",
            "bank_name" => "",
            "bank_holder_name" => "",
            "bank_account_number" => "",
            "bank_ifsc_code" => "",
            "bank_other_details" => "",
            "timezone" => "",
        ];
    }
}

if (!function_exists('settings')) {
    function settings()
    {
        $settingData = DB::table('settings');
        if (\Auth::check()) {
            $userId = parentId();
            $settingData = $settingData->where('parent_id', $userId);
        } else {
            $settingData = $settingData->where('parent_id',1);
        }
        $settingData = $settingData->get();
        $details = settingsKeys();

        foreach ($settingData as $row) {
            $details[$row->name] = $row->value;
        }

        config(
            [
                'captcha.secret' => $details['recaptcha_secret'],
                'captcha.sitekey' => $details['recaptcha_key'],
                'options' => [
                    'timeout' => 30,
                ],
            ]
        );

        return $details;
    }
}

if (!function_exists('subscriptionPaymentSettings')) {
    function subscriptionPaymentSettings()
    {
        $settingData = DB::table('settings')->where('type', 'payment')->where('parent_id', '=', 1)->get();
        $result = [
            'CURRENCY' => "USD",
            'CURRENCY_SYMBOL' => "$",
            'STRIPE_PAYMENT' => "off",
            'STRIPE_KEY' => "",
            'STRIPE_SECRET' => "",
            "paypal_payment" => "off",
            "paypal_mode" => "",
            "paypal_client_id" => "",
            "paypal_secret_key" => "",
            "bank_transfer_payment" => "off",
            "bank_name" => "",
            "bank_holder_name" => "",
            "bank_account_number" => "",
            "bank_ifsc_code" => "",
            "bank_other_details" => "",
        ];

        foreach ($settingData as $setting) {
            $result[$setting->name] = $setting->value;
        }

        return $result;
    }
}

if (!function_exists('invoicePaymentSettings')) {
    function invoicePaymentSettings($id)
    {
        $settingData = DB::table('settings')->where('type', 'payment')->where('parent_id', $id)->get();
        $result = [
            'CURRENCY' => "USD",
            'CURRENCY_SYMBOL' => "$",
            'STRIPE_PAYMENT' => "off",
            'STRIPE_KEY' => "",
            'STRIPE_SECRET' => "",
            "paypal_payment" => "off",
            "paypal_mode" => "",
            "paypal_client_id" => "",
            "paypal_secret_key" => "",
            "bank_transfer_payment" => "off",
            "bank_name" => "",
            "bank_holder_name" => "",
            "bank_account_number" => "",
            "bank_ifsc_code" => "",
            "bank_other_details" => "",
        ];

        foreach ($settingData as $row) {
            $result[$row->name] = $row->value;
        }
        return $result;
    }
}

if (!function_exists('emailSettings')) {
    function emailSettings($id)
    {
        $settingData = DB::table('settings')->where('type', 'smtp')->where('parent_id', $id)->get();
        $result = [
            'FROM_EMAIL' => "",
            'FROM_NAME' => "",
            'SERVER_DRIVER' => "",
            'SERVER_HOST' => "",
            'SERVER_PORT' => "",
            'SERVER_USERNAME' => "",
            'SERVER_PASSWORD' => "",
            'SERVER_ENCRYPTION' => "",
        ];

        foreach ($settingData as $setting) {
            $result[$setting->name] = $setting->value;
        }

        return $result;
    }
}

if (!function_exists('getSettingsValByName')) {
    function getSettingsValByName($key)
    {
        $setting = settings();
        if (!isset($setting[$key]) || empty($setting[$key])) {
            $setting[$key] = '';
        }

        return $setting[$key];
    }
}

if (!function_exists('settingDateFormat')) {
    function settingDateFormat($settings, $date)
    {
        return date($settings['company_date_format'], strtotime($date));
    }
}
if (!function_exists('settingPriceFormat')) {
    function settingPriceFormat($settings, $price)
    {
        return $settings['CURRENCY_SYMBOL'] . $price;
    }
}
if (!function_exists('settingTimeFormat')) {
    function settingTimeFormat($settings, $time)
    {
        return date($settings['company_time_format'], strtotime($time));
    }
}
if (!function_exists('dateFormat')) {
    function dateFormat($date)
    {
        $settings = settings();

        return date($settings['company_date_format'], strtotime($date));
    }
}
if (!function_exists('timeFormat')) {
    function timeFormat($time)
    {
        $settings = settings();

        return date($settings['company_time_format'], strtotime($time));
    }
}
if (!function_exists('priceFormat')) {
    function priceFormat($price)
    {
        $settings = settings();

        return $settings['CURRENCY_SYMBOL'] . $price;
    }
}
if (!function_exists('parentId')) {
    function parentId()
    {
        if (\Auth::user()->type == 'owner' || \Auth::user()->type == 'super admin') {
            return \Auth::user()->id;
        } else {
            return \Auth::user()->parent_id;
        }
    }
}
if (!function_exists('assignSubscription')) {
    function assignSubscription($id)
    {
        $subscription = Subscription::find($id);
        if ($subscription) {
            \Auth::user()->subscription = $subscription->id;
            if ($subscription->interval == 'Monthly') {
                \Auth::user()->subscription_expire_date = Carbon::now()->addMonths(1)->isoFormat('YYYY-MM-DD');
            } elseif ($subscription->interval == 'Quarterly') {
                \Auth::user()->subscription_expire_date = Carbon::now()->addMonths(3)->isoFormat('YYYY-MM-DD');
            } elseif ($subscription->interval == 'Yearly') {
                \Auth::user()->subscription_expire_date = Carbon::now()->addYears(1)->isoFormat('YYYY-MM-DD');
            } else {
                \Auth::user()->subscription_expire_date = null;
            }
            \Auth::user()->save();

            $users = User::where('parent_id', '=', parentId())->whereNotIn('type', ['super admin', 'owner'])->get();
            $propertys = Property::where('parent_id', '=',parentId())->get();

            if ($subscription->user_limit == 0) {
                foreach ($users as $user) {
                    $user->is_active = 1;
                    $user->save();
                }
            } else {
                $userCount = 0;
                foreach ($users as $user) {
                    $userCount++;
                    if ($userCount <= $subscription->user_limit) {
                        $user->is_active = 1;
                        $user->save();
                    } else {
                        $user->is_active = 0;
                        $user->save();
                    }
                }
            }

            if($subscription->property_limit == 0)
            {
                foreach($propertys as $property)
                {
                    $property->is_active = 1;
                    $property->save();
                }
            }
            else
            {
                $propertyCount = 0;
                foreach($propertys as $property)
                {
                    $propertyCount++;
                    if($propertyCount <= $subscription->property_limit)
                    {
                        $property->is_active = 1;
                        $property->save();
                    }
                    else
                    {
                        $property->is_active = 0;
                        $property->save();
                    }
                }
            }

        } else {
            return [
                'is_success' => false,
                'error' => 'Subscription is deleted.',
            ];
        }
    }
}
if (!function_exists('assignManuallySubscription')) {
    function assignManuallySubscription($id,$userId)
    {
        $owner = User::find($userId);
        $subscription = Subscription::find($id);
        if ($subscription) {
            $owner->subscription = $subscription->id;
            if ($subscription->interval == 'Monthly') {
                $owner->subscription_expire_date = Carbon::now()->addMonths(1)->isoFormat('YYYY-MM-DD');
            } elseif ($subscription->interval == 'Quarterly') {
                $owner->subscription_expire_date = Carbon::now()->addMonths(3)->isoFormat('YYYY-MM-DD');
            } elseif ($subscription->interval == 'Yearly') {
                $owner->subscription_expire_date = Carbon::now()->addYears(1)->isoFormat('YYYY-MM-DD');
            } else {
                $owner->subscription_expire_date = null;
            }
            $owner->save();

            $users = User::where('parent_id', '=', parentId())->whereNotIn('type', ['super admin', 'owner'])->get();
            $propertys = Property::where('parent_id', '=',parentId())->get();

            if ($subscription->user_limit == 0) {
                foreach ($users as $user) {
                    $user->is_active = 1;
                    $user->save();
                }
            } else {
                $userCount = 0;
                foreach ($users as $user) {
                    $userCount++;
                    if ($userCount <= $subscription->user_limit) {
                        $user->is_active = 1;
                        $user->save();
                    } else {
                        $user->is_active = 0;
                        $user->save();
                    }
                }
            }

            if($subscription->property_limit == 0)
            {
                foreach($propertys as $property)
                {
                    $property->is_active = 1;
                    $property->save();
                }
            }
            else
            {
                $propertyCount = 0;
                foreach($propertys as $property)
                {
                    $propertyCount++;
                    if($propertyCount <= $subscription->property_limit)
                    {
                        $property->is_active = 1;
                        $property->save();
                    }
                    else
                    {
                        $property->is_active = 0;
                        $property->save();
                    }
                }
            }

        } else {
            return [
                'is_success' => false,
                'error' => 'Subscription is deleted.',
            ];
        }
    }
}
if (!function_exists('smtpDetail')) {
    function smtpDetail($id)
    {
        $settings = emailSettings($id);

        $smtpDetail = config(
            [
                'mail.mailers.smtp.transport' => $settings['SERVER_DRIVER'],
                'mail.mailers.smtp.host' => $settings['SERVER_HOST'],
                'mail.mailers.smtp.port' => $settings['SERVER_PORT'],
                'mail.mailers.smtp.encryption' => $settings['SERVER_ENCRYPTION'],
                'mail.mailers.smtp.username' => $settings['SERVER_USERNAME'],
                'mail.mailers.smtp.password' => $settings['SERVER_PASSWORD'],
                'mail.from.address' => $settings['FROM_EMAIL'],
                'mail.from.name' => $settings['FROM_NAME'],
            ]
        );

        return $smtpDetail;
    }
}

if (!function_exists('invoicePrefix')) {
    function invoicePrefix()
    {
        $settings = settings();
        return $settings["invoice_number_prefix"];
    }
}
if (!function_exists('expensePrefix')) {
    function expensePrefix()
    {
        $settings = settings();
        return $settings["expense_number_prefix"];
    }
}

if (!function_exists('timeCalculation')) {
     function timeCalculation($startDate,$startTime,$endDate,$endTime)
    {
        $startdate= $startDate.' '.$startTime;
        $enddate=$endDate.' '.$endTime;

        $startDateTime = new DateTime($startdate);
        $endDateTime = new DateTime($enddate);

         $interval = $startDateTime->diff($endDateTime);
         $totalHours = $interval->h + $interval->i / 60;

        return number_format($totalHours,2);
    }
}

if (!function_exists('setup')) {
     function setup()
    {
        $setupPath=storage_path() . "/installed";
        return $setupPath;
    }
}

if (!function_exists('userLoggedHistory')) {
     function userLoggedHistory()
    {
        $serverip = $_SERVER['REMOTE_ADDR'];
        $data = @unserialize(file_get_contents('http://ip-api.com/php/' . $serverip));
        if(isset($data['status']) && $data['status'] == 'success')
        {
            $browser = new \WhichBrowser\Parser($_SERVER['HTTP_USER_AGENT']);
            if ($browser->device->type == 'bot')
            {
                return redirect()->intended(RouteServiceProvider::HOME);
            }
            $referrerData = isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER']) : null;
            $data['browser'] = $browser->browser->name ?? null;
            $data['os'] = $browser->os->name ?? null;
            $data['language'] = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? mb_substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) : null;
            $data['device'] = User::getDevice($_SERVER['HTTP_USER_AGENT']);
            $data['referrer_host'] = !empty($referrerData['host']);
            $data['referrer_path'] = !empty($referrerData['path']);
            $result = json_encode($data);
            $details = new LoggedHistory();
            $details->type = Auth::user()->type;
            $details->user_id = Auth::user()->id;
            $details->date = date('Y-m-d H:i:s');
            $details->Details = $result;
            $details->ip = $serverip;
            $details->parent_id = parentId();
            $details->save();
        }
    }
}

if(!function_exists('defaultTenantCreate')){
    function defaultTenantCreate($id)
    {
        // Default Tenant role
        $tenantRoleData= [
            'name' => 'tenant',
            'parent_id' => $id,
        ];
        $systemTenantRole = Role::create($tenantRoleData);
        // Default Tenant permissions
        $systemTenantPermissions = [
            ['name' => 'manage invoice'],
            ['name' => 'show invoice'],
            ['name' => 'manage contact'],
            ['name' => 'create contact'],
            ['name' => 'edit contact'],
            ['name' => 'delete contact'],
            ['name' => 'manage support'],
            ['name' => 'create support'],
            ['name' => 'edit support'],
            ['name' => 'delete support'],
            ['name' => 'reply support'],
            ['name' => 'manage note'],
            ['name' => 'create note'],
            ['name' => 'edit note'],
            ['name' => 'delete note'],
            ['name' => 'create invoice payment'],
            ['name' => 'manage maintenance request'],
            ['name' => 'create maintenance request'],
            ['name' => 'edit maintenance request'],
            ['name' => 'delete maintenance request'],
            ['name' => 'show maintenance request'],
        ];
        $systemTenantRole->givePermissionTo($systemTenantPermissions);
        return $systemTenantRole;
    }
}

if(!function_exists('defaultMaintainerCreate')){
    function defaultMaintainerCreate($id)
    {
        $maintainerRoleData=  [
            'name' => 'maintainer',
            'parent_id' => $id,
        ];
        $systemMaintainerRole = Role::create($maintainerRoleData);
        // Default admin permissions
        $systemMaintainerPermissions = [
            ['name' => 'manage maintenance request'],
            ['name' => 'show maintenance request'],
            ['name' => 'manage contact'],
            ['name' => 'create contact'],
            ['name' => 'edit contact'],
            ['name' => 'delete contact'],
            ['name' => 'manage support'],
            ['name' => 'create support'],
            ['name' => 'edit support'],
            ['name' => 'delete support'],
            ['name' => 'reply support'],
            ['name' => 'manage note'],
            ['name' => 'create note'],
            ['name' => 'edit note'],
            ['name' => 'delete note'],
        ];
        $systemMaintainerRole->givePermissionTo($systemMaintainerPermissions);
        return $systemMaintainerRole;
    }
}
