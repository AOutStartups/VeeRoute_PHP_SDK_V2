<?php
/**
 * Created by PhpStorm.
 * User: panda-dev
 * Date: 18.07.15
 * Time: 14:57
 */

namespace VeeRoute\Builder;


use Curl\Curl;

class Requester  {

    protected $path = null;
    protected $type = null;

    protected $protocol = "http";
    protected $host = "trial.veeroute.com";
    protected $account = null;
    protected $user = null;
    protected $password = null;

    protected $auth_require = true;
    protected $headers = null;
    protected $access_token = null;

    public function __construct($config=null) {

        if(isset($config)) {
            $this->setConfig($config);
        }


        if($this->auth_require == true) {
            $this->access_token = $this->auth();
        }

        $this->setPath();

    }

    public function make($content=null) {

        $params = $this->getRequestParams($content);
        $data = $this->getRequestData($content);

        $request = new Curl();

        if(isset($this->headers)) {
            $request->setOpt(CURLOPT_HTTPHEADER, $this->headers);
        }

        if(isset($params)) {
            $params = "?".http_build_query($params);
        } else {
            $params = "";
        }

        $url = $this->path.$params;


        $response = $request->post($url, $data);

        return $this->output($response);
    }

    protected function output($response) {
        return $response;
    }


    protected function auth() {
        $config = clone $this;
        $config->auth_require = false;
        $auth = new \VeeRoute\Authentication\CreateSession($config);
        $this->access_token = $auth->make();

        return $this->access_token;
    }


    protected function getRequestParams($content) {
        return null;
    }

    protected function getRequestData($content=array()) {
        $content_for_xml_convert = array();

        if($this->auth_require == true) {
            $auth_part = array('sessionID'=>$this->access_token);
            $content = array_merge($content, $auth_part);
        }

        $content_for_xml_convert = array('apiRequest'=>$content);

        $xml = \Verdant\Array2XML::createXML($content_for_xml_convert);

        return $xml->saveXML();
    }



    protected function setConfig($config) {

        foreach ($config as $name => $value) {

            $this->$name = $value;

        }

    }

    protected function setPath() {
        $type = \VeeRoute\Config::$api_type;
        $version = \VeeRoute\Config::$api_version;

        $method_array = $this->getPathMethod(get_class($this));

        $this->path = $this->protocol."://".join('/', array($this->host, $type, $version))."/".join('/',$method_array);

        return $this;
    }


    private function getPathMethod($class_path) {
        $class_path_for_url = array();
        $class_path = explode('\\', $class_path);

        for($i=0; $i < count($class_path); $i++) {

            if(!preg_match('/VeeRoute/', $class_path[$i])) {


                //replace _ to - (for distribution_api namespace)
                //action - first lower letter
                //add to $class_path_for_url array
                array_push($class_path_for_url, str_replace("_","-", lcfirst($class_path[$i])));

            }

        }

        return $class_path_for_url;
    }

} 