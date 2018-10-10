<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GSuitAdminTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {

        $arr_f_name = ['lee','kim','park','choi','kang','jung','lim'];
        $arr_g_name = ['Jennifer','Kyle','Elica','Sunny','Charles','Eugine','Elynne','Jason','Carrie','Elsa','Justin','Elizabeth','Kate','Angela'];

        $f_name = shuffle($arr_f_name);
        $f_name = $arr_f_name[$f_name];
        $g_name = shuffle($arr_g_name);
        $g_name = $arr_g_name[$g_name];
        $name = $f_name.$g_name;

        $this->post('/api/insertGoogleUser',[
            'familyName'=> $f_name,
            'givenName'=> $g_name,
            'fullName'=> $name,
            'password'=> 'password',
            'primaryEmail'=> $name.'@devluna.co.kr'
        ])->assertJson([
            'resCode' => '0000'
        ]);

    }
}
