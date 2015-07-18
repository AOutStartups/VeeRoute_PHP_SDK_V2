<?php
/**
 * Created by PhpStorm.
 * User: panda-dev
 * Date: 18.07.15
 * Time: 14:59
 */

class RequesterTest extends PHPUnit_Framework_TestCase {


    public function testQwqe() {

        $data = array(
            'parent'=>array(
                'child'=>array(
                    1,2,3,4,5,6
                )
            )
        );

        $config = array(
            'account'=>'demo150',
            'user'=>'demo150',
            'password'=>'97xUth97xUth'
        );

        $orders = new \VeeRoute\Orders\Save($config);
        $response = $orders->make($data);
        return $response;

    }

}
 