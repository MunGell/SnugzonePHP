<?php

namespace Snugzone;

use Carbon\Carbon;

class ApiClient extends AbstractClient
{
    /**
     * @var String
     */
    const ENDPOINT_URL = 'http://www.prepago-admin.biz/prepago_app';

    /**
     * @var String
     */
    const CLIENT_ID = 'SnugzonePHP';

    /**
     * @var String
     */
    private $email;

    /**
     * @var String
     */
    private $username;

    /**
     * @var String
     */
    private $token;

    /**
     * @var String
     */
    private $customerId;

    public function login(String $email, String $username, String $token)
    {
        $url = self::ENDPOINT_URL . $this->buildUrl([
                'login',
                $email,
                $username,
                $token,
                self::CLIENT_ID,
            ]);

        $request = $this->getMessageFactory()->createRequest('GET', $url);
        $response = $this->getHttpClient()->sendRequest($request);
        $json = $this->decodeJson($response->getBody());

        if (!is_null($json) && $response->getStatusCode() === 200 && empty($json->error)) {
            $this->email = $email;
            $this->username = $username;
            $this->token = $token;
            $this->customerId = $json->customer_id;

            return true;
        } else {
            return false;
        }
    }

    /**
     * @return \StdClass
     */
    public function getInformation()
    {
        $url = self::ENDPOINT_URL . $this->buildUrl([
                'get_prepay_information',
                $this->customerId,
                $this->email,
                $this->username,
                $this->token,
            ]);

        $request = $this->getMessageFactory()->createRequest('GET', $url);
        $response = $this->getHttpClient()->sendRequest($request);

        return $this->decodeJson($response->getBody());
    }

    /**
     * @param \Carbon\Carbon $startDate
     * @param \Carbon\Carbon $endDate
     *
     * @return \StdClass
     */
    public function getStatistics(Carbon $startDate, Carbon $endDate)
    {
        $url = self::ENDPOINT_URL . $this->buildUrl([
                'customer_graph_data',
                $this->customerId,
                $this->email,
                $this->username,
                $this->token,
                $startDate->toDateString(),
                $endDate->toDateString(),
            ]);

        $request = $this->getMessageFactory()->createRequest('GET', $url);
        $response = $this->getHttpClient()->sendRequest($request);

        return $this->decodeJson($response->getBody());
    }

    public function getRemoteControl()
    {
        $url = self::ENDPOINT_URL . $this->buildUrl([
                'get_rc_information',
                $this->customerId,
                $this->email,
                $this->username,
                $this->token,
            ]);

        $request = $this->getMessageFactory()->createRequest('GET', $url);
        $response = $this->getHttpClient()->sendRequest($request);

        return $this->decodeJson($response->getBody());
    }

    public function setRemoteControl($data)
    {
        $url = self::ENDPOINT_URL . $this->buildUrl([
                'set_rc_information',
                $this->customerId,
                $this->email,
                $this->username,
                $this->token,
                json_encode($data),
            ]);

        $request = $this->getMessageFactory()->createRequest('GET', $url);
        $response = $this->getHttpClient()->sendRequest($request);

        return $this->decodeJson($response->getBody());
    }
}
