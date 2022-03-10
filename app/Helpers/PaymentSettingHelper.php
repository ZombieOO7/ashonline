<?php

namespace App\Helpers;

use App\Models\PaymentSetting;
use App\Models\Stage;
use App\Models\SubjectPaperCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PaymentSettingHelper extends BaseHelper
{

    protected $paymentSetting;
    public function __construct(PaymentSetting $paymentSetting)
    {
        $this->paymentSetting = $paymentSetting;
        parent::__construct();
    }

    /**
     * ------------------------------------------------------
     * | Payment Setting store                              |
     * |                                                    |
     * | @param Request $request,$uuid                      |
     * |-----------------------------------------------------
     */
    public function store(Request $request, $uuid = null)
    {
        if ($request->has('id') && $request->id != '') {
            $paymentSetting = $this->paymentSetting::findOrFail($request->id);
        } else {
            $request->request->remove('id');
            $paymentSetting = new PaymentSetting();
        }
        $paymentSetting->fill($request->all())->save();
        // $env_update = $this->changeEnv([
        //     'STRIPE_KEY'=>$paymentSetting->stripe_key,
        //     'STRIPE_SECRET'=>$paymentSetting->stripe_secret,
        //     'STRIPE_CURRENCY'=>$paymentSetting->stripe_currency,
        //     'STRIPR_MODE'=>$paymentSetting->stripe_mode,
        //     'PAYPAL_CLIENT_ID'=>$paymentSetting->paypal_client_id,
        //     'PAYPAL_MODE'=>$paymentSetting->paypal_mode,
        //     'PAYPAL_SANDBOX_API_USERNAME'=>$paymentSetting->paypal_sandbox_api_username,
        //     'PAYPAL_SANDBOX_API_PASSWORD'=>$paymentSetting->paypal_sandbox_api_password,
        //     'PAYPAL_SANDBOX_API_SECRET'=>$paymentSetting->paypal_sandbox_api_secret,
        //     'PAYPAL_CURRENCY'=>$paymentSetting->paypal_currency,
        //     'PAYPAL_SANDBOX_API_CERTIFICATE'=>$paymentSetting->paypal_sandbox_api_certificate,
        // ]);
        // if ($env_update) {
        //     \Artisan::call('config:clear');
        // }

        return $paymentSetting;
    }

    /**
     * ------------------------------------------------------
     * | get Payment setting detail                         |
     * |                                                    |
     * | @param $id                                         |
     * |-----------------------------------------------------
     */
    public function paymentDetail()
    {
        return $this->paymentSetting::first();
    }

    /**
     * ------------------------------------------------------
     * | get update env payment setting                     |
     * |                                                    |
     * | @param Array                                       |
     * |-----------------------------------------------------
     */
    protected function changeEnv($data = array())
    {
        if (count($data) > 0) {

            // Read .env-file
            $env = file_get_contents(base_path() . '/.env');

            // Split string on every " " and write into array
            $env = preg_split('/\s+/', $env);

            // Loop through given data
            foreach ((array) $data as $key => $value) {

                // Loop through .env-data
                foreach ($env as $env_key => $env_value) {

                    // Turn the value into an array and stop after the first split
                    // So it's not possible to split e.g. the App-Key by accident
                    $entry = explode("=", $env_value, 2);

                    // Check, if new key fits the actual .env-key
                    if ($entry[0] == $key) {
                        // If yes, overwrite it with the new one
                        $env[$env_key] = $key . "=" . $value;
                    } else {
                        // If not, keep the old one
                        $env[$env_key] = $env_value;
                    }
                }
            }

            // Turn the array back to an String
            $env = implode("\n", $env);

            // And overwrite the .env with the new data
            file_put_contents(base_path() . '/.env', $env);
            return true;
        } else {
            return false;
        }
    }

}
