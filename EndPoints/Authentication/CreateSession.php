<?php
/**
 * Created by PhpStorm.
 * User: panda-dev
 * Date: 18.07.15
 * Time: 16:22
 */

namespace VeeRoute\Authentication;

use VeeRoute\VeeRouteException;

/**
 * Class CreateSession
 * @package VeeRoute\Authentication
 * @description http://account.veeroute.com/knowledge/dev/200523451/201163272/203390591
 */
class CreateSession extends \VeeRoute\Builder\Url {

    /**
     * @return array
     * @throws VeeRouteException
     */
    protected  function getRequestParams() {
        if(!isset($this->account) || !isset($this->user) || !isset($this->password)) {
            throw new VeeRouteException('you have missed param for authentication: accountID or username or password');
        }

        $params = array(
            'accountID'=>$this->account,
            'user'=>$this->user,
            'password'=>$this->password
        );


        return $params;
    }

    /**
     * @param $content
     * @return string
     * @throws VeeRouteException
     */
    protected function output($content) {

        if(isset($content->error)) {
            throw new VeeRouteException("Wrong auth data, error log: ".json_encode($content->error));
        }

        $this->access_token = (string) $content->authResponse->sessionID;



        return $this->access_token;
    }

} 