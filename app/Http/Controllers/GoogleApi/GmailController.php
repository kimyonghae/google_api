<?php
namespace App\Http\Controllers\GoogleApi;

use App\Models\GoogleApi\GmailParam;
use App\Object\GoogleApi\Gmail;
use Exception;

class GmailController
{
    private $resCode ='';
    private $resMessage = '';
    private $gmail;

    /**
     * GmailController constructor.
     * @param Gmail $gmail
     */
    public function __construct(Gmail $gmail)
    {
        $this->gmail = $gmail;
    }

    /**
     * Gmail 전송
     * @return array
     */
    public function sendGoogleMessage()
    {
        try {
            //request set to param
            $gmailParam = new GmailParam();
            $gmailParam->setMailTo(request('mailTo'));
            $gmailParam->setMailToName(request('mailToName'));
            $gmailParam->setMailSubject(request('mailSubject'). date('M d, Y h:i:s A'));
            $gmailParam->setMailContents(request('mailContents'));

            //mail send by Gmail
            $results = $this->gmail->sendMessage($gmailParam);

            //mail result
            $this->resCode = $results['resCode'];
            $this->resMessage  = $results['resMessage'];
        } catch (Exception $e) {
            echo 'An error occurred: ' . $e->getMessage();
            $this->resCode = '2001';
            $this->resMessage  = '처리중 에러 : '.$e->getMessage();
        }finally{
            return [
                'resCode' => $this->resCode
               ,'resMessage' => $this->resMessage
            ];
        }

    }


}
