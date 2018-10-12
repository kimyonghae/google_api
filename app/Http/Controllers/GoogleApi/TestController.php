<?php
/**
 * Created by IntelliJ IDEA.
 * User: lunasoftPC35
 * Date: 2018-09-21
 * Time: 오후 12:35
 */

namespace App\Http\Controllers\GoogleApi;


class TestController
{
    public function test()
    {

        $hash = hash('SHA1', 'password');
        echo $hash;
        exit;

        $arr_f_name = ['lee','kim','park','choi','kang','jung','lim'];
        $arr_g_name = ['Jennifer','Kyle','Elica','Sunny','Charles','Eugine','Elynne','Jason','Carrie','Elsa','Justin','Elizabeth','Kate','Angela'];

        $f_name = shuffle($arr_f_name);
        $f_name = $arr_f_name[$f_name];

        $g_name = shuffle($arr_g_name);
        $g_name = $arr_g_name[$g_name];

        $name = $f_name.$g_name;

        echo $f_name;
        echo '<br>';
        echo $g_name;
        echo '<br>';
        echo $name;
        echo '<br>';

    }
}
