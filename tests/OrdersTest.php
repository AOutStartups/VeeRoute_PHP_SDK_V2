<?php
/**
 * Created by PhpStorm.
 * User: panda-dev
 * Date: 18.07.15
 * Time: 14:59
 */

class OrdersTest extends TestCase {

    public function testSave() {

        $data = array(
            'orders'=>array(
                'order'=>array(
                    array(
                        'orderReference'=>'Order #1_test_from_api',
                        'areaOfControl'=>'Центральное депо',
                        'date'=>'18.03.2015',
                        'location'=>array(
                            'name'=>'Тверская, 7',
                            'address'=>'Тверская, 7',
                            'latitude'=>55.757899,
                            'longitude'=>37.610791
                        ),
                        'dropWindows'=> array(
                            'dropWindow'=>array(
                                'start'=>'18.03.2015 12:00',
                                'end'=>'18.03.2015 15:00'
                            )
                        ),
                        'durationDrop'=>'00:15'
                    ),
                    array(
                        'orderReference'=>'Order #2_test_from_api',
                        'areaOfControl'=>'Центральное депо',
                        'date'=>'18.03.2015',
                        'location'=>array(
                            'name'=>'Театр им. Станиславского',
                            'address'=>'Тверская улица, 23'
                        ),
                        'dropWindows'=> array(
                            'dropWindow'=>array(
                                'start'=>'18.03.2015 19:00',
                                'end'=>'18.03.2015 23:00'
                            )
                        ),
                        'durationDrop'=>'00:15'
                    )
                )
            )
        );




        $orders = new \VeeRoute\Distribution_api\Orders\Save($this->config);
        $response = $orders->make($data);


        $this->assertTrue(isset($response->orders), "We can create/update orders");
    }

}
 