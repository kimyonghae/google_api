<?php

namespace Tests\Feature;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GmailTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {

        $file_path = __DIR__.'\메일첨부파일.txt';
        $uploadedFile = new UploadedFile (
            $file_path,
            '테스트첨부파일.txt',
            'txt',
            null,
            null,
            true
        );

        $this->post('/api/sendGoogleMessage',[
            'mailTo'=> 'yhkim@lunasoft.co.kr',
            'mailToName'=> '김 용해',
            'mailSubject'=> '테스트메일입니다.',
            'mailContents'=> '테스트메일의 내용입니다.',
            ['file' => $uploadedFile]
        ])->assertJson([
            'resCode' => '0000'
        ]);

    }
}
