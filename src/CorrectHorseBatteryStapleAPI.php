<?php

namespace GisoStallenberg\CorrectHorseBatteryStapleAPI;

use GisoStallenberg\CorrectHorseBatteryStaple\CorrectHorseBatteryStaple;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Exception\RuntimeException;

class CorrectHorseBatteryStapleAPI {

    /**
     * Constructor
     *
     * @param array $settings
     */
    public function __construct(array $settings) {
        $this->settings = $settings;
    }

    /**
     * Run the API
     */
    public function run() {
        $password = $this->getPasswordFromRequestData();

        try {
            $correctHorseBatteryStaple = new CorrectHorseBatteryStaple();
        } catch (RuntimeException $exception) {
            $this->sendErrorResponse('Service unavailable', Response::HTTP_SERVICE_UNAVAILABLE);
        }

        try {
            $correctHorseBatteryStaple->check($password);
            $this->sendResponse([
                'status' => $correctHorseBatteryStaple->getLastStatus(),
                'message' => $correctHorseBatteryStaple->getLastMessage()
            ]);
        } catch (ProcessFailedException $exception) {
            $this->sendErrorResponse('Internal server error');
        }
    }

    /**
     * Send a response
     *
     * @param array $data
     * @param integer $httpStatus
     */
    private function sendResponse(array $data, $httpStatus = Response::HTTP_OK) {
        $response = new Response(json_encode($data), $httpStatus);
        $response->headers->set('Content-Type', 'application/json');
        $response->send();
    }

    /**
     * Send a error message
     *
     * @param string $message
     * @param integer $httpStatus
     */
    private function sendErrorResponse($message, $httpStatus = Response::HTTP_INTERNAL_SERVER_ERROR) {
        $this->sendResponse([
            'status' => -1,
            'message' => $message
        ], $httpStatus);
    }

    /**
     * Read the password from the post raw data
     *
     * @return string
     */
    private function getPasswordFromRequestData() {
        $request = Request::createFromGlobals();
        if (!in_array($request->getMethod(), $this->settings['security']['request_methods'] ) ) {
            $this->sendErrorResponse('Request method not allowed', Response::HTTP_METHOD_NOT_ALLOWED);
        }

        if ($this->settings['security']['force_secure'] ) {
            $request->setTrustedProxies($this->settings['security']['trusted_proxies']);
            if (!$request->isSecure() ) {
                $this->sendErrorResponse('Only secure connections allowed');
            }
        }

        return $request->getContent();
    }
}