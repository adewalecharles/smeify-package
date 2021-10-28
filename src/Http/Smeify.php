<?php

namespace AdewaleCharles\Smeify\Http;

use AdewaleCharles\Smeify\Models\Smeify as ModelsSmeify;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;

class Smeify
{
    /**
     * Creates a new token when the previous one has expired
     *
     * @return string $token
     */
    protected static function login(): string
    {
        $smeify = ModelsSmeify::find(1);

        $client = new \GuzzleHttp\Client();

        $response = $client->request('POST', 'https://api.smeify.com/api/v2/auth', [
            'form_params' => [
                'identity' => Config::get('smeify.identity', null),
                'password' => Config::get('smeify.password', null),
                ]
            ]);

        $data = json_decode($response->getBody());
        $token = $data->token;
        $expires = Carbon::parse($data->expires_in);
        $smeify->update([
            'token' => $token,
            'expires' => $expires
        ]);

        return $token;
    }

    /**
     * Function to get all data plans
     *
     * @return json|string
     */
    public static function getDataPlans()
    {
        $smeify = ModelsSmeify::find(1);

        $token = $smeify->token;

        if (Carbon::parse($smeify->expires) <= Carbon::now()) {
            $token = self::login();
        }

        try {

            $client = new \GuzzleHttp\Client();

            $response = $client->request('GET', 'https://api.smeify.com/api/v2/plans/all',
                [
                    'headers' => [
                        'Accept'     => 'application/json',
                        'Authorization' => 'Bearer ' . $token
                    ]
                ]);

            return  json_decode($response->getBody(), true, JSON_THROW_ON_ERROR);

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Function to get all data plans attached to a network using the network
     *
     * @param int $network
     *
     * @return json|string
     */
    public static function getDataPlansByNetworkId(int $network)
    {

        $smeify = ModelsSmeify::find(1);

        $token = $smeify->token;

        if (Carbon::parse($smeify->expires) <= Carbon::now()) {
            $token = self::login();
        }
        try {
            $client = new \GuzzleHttp\Client();

            $response = $client->request(
                'GET',
                'https://api.smeify.com/api/v2/plans/' . $network,
                [
                    'headers' => [
                        'Accept'     => 'application/json',
                        'Authorization' => 'Bearer ' . $token
                    ]
                ]
            );
            return  json_decode($response->getBody(), true, JSON_THROW_ON_ERROR);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Function to initiate a airtime transaction
     *
     * @param array $data
     *
     * @return json|string
     */
    public static function airtime(array $data)
    {
        $smeify = ModelsSmeify::find(1);

        $token = $smeify->token;

        if (Carbon::parse($smeify->expires) <= Carbon::now()) {
            $token = self::login();
        }

        try {
            $client = new \GuzzleHttp\Client();

            $response = $client->request('POST', 'https://api.smeify.com/api/v2/airtime', [
                'headers' => [
                    'Accept'     => 'application/json',
                    'Authorization' => 'Bearer ' . $token
                ],
                'form_params' => [
                    'phones' => $data['phones'],
                    'amount' => $data['amount'],
                    'network' => $data['network'],
                    'type' => $data['type']
                ]
            ]);

            return  json_decode($response->getBody(), true, JSON_THROW_ON_ERROR);

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Function to initiate a data transaction
     *
     * @param array $data
     *
     * @return json|string
     */
    public static function data(array $data)
    {
        $smeify = ModelsSmeify::find(1);

        $token = $smeify->token;

        if (Carbon::parse($smeify->expires) <= Carbon::now()) {
            $token = self::login();
        }

        try {
            $client = new \GuzzleHttp\Client();

            $response = $client->request('POST', 'https://api.smeify.com/api/v2/data', [
                'headers' => [
                    'Accept'     => 'application/json',
                    'Authorization' => 'Bearer ' . $token
                ],
                'form_params' => [
                    'phones' => $data['phones'],
                    'plan' => $data['plan'],
                ]
            ]);

            return json_decode($response->getBody(), true, JSON_THROW_ON_ERROR);

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Function to get all your smeify transactions
     *
     *
     * @return json|string
     */
    public static function getTransactions()
    {
        try {

            $smeify = ModelsSmeify::find(1);

            $token = $smeify->token;

            if (Carbon::parse($smeify->expires) <= Carbon::now()) {
                $token = self::login();
            }

            $client = new \GuzzleHttp\Client();

            $response = $client->request(
                'GET',
                'https://api.smeify.com/api/v2/transactions',
                [
                    'headers' => [
                        'Accept'     => 'application/json',
                        'Authorization' => 'Bearer ' . $token
                    ]
                ]
            );
            return  json_decode($response->getBody(), true, JSON_THROW_ON_ERROR);

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Function to get or verify a single transaction using the reference
     *
     * @param string $reference
     *
     * @return json|string
     */
    public static function veriyTransactionByReference(string $reference)
    {
        try {

            $smeify = ModelsSmeify::find(1);

            $token = $smeify->token;

            if (Carbon::parse($smeify->expires) <= Carbon::now()) {
                $token = self::login();
            }

            $client = new \GuzzleHttp\Client();

            $response = $client->request(
                'GET',
                'https://api.smeify.com/api/v2/transaction/' . $reference,
                [
                    'headers' => [
                        'Accept'     => 'application/json',
                        'Authorization' => 'Bearer ' . $token
                    ]
                ]
            );
            return  json_decode($response->getBody(), true, JSON_THROW_ON_ERROR);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Function to get or verify transactions done in batch using the order_id
     *
     * @param string $orderID
     *
     * @return json|string
     */
    public static function verifyTransactionByOrderId(string $orderId)
    {
        try {

            $smeify = ModelsSmeify::find(1);

            $token = $smeify->token;

            if (Carbon::parse($smeify->expires) <= Carbon::now()) {
                $token = self::login();
            }

            $client = new \GuzzleHttp\Client();

            $response = $client->request(
                'GET',
                'https://api.smeify.com/api/v2/group/transaction/' . $orderId,
                [
                    'headers' => [
                        'Accept'     => 'application/json',
                        'Authorization' => 'Bearer ' . $token
                    ]
                ]
            );
            return  json_decode($response->getBody(), true, JSON_THROW_ON_ERROR);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
