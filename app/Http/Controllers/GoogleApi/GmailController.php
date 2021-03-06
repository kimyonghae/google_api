<?php
namespace App\Http\Controllers\GoogleApi;

use App\Models\GoogleApi\GmailParam;
use App\Object\CommonConst as CODE;
use App\Object\GoogleApi\Gmail;
use Exception;

class GmailController
{
    private $resCode    = CODE::PROC_RETURN_DEFAULT;
    private $resMessage = CODE::PROC_RETURN_DEFAULT_MSG;

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

            if( isset($_FILES['mailAttach']) ){
                $target_path = $_FILES['mailAttach']['tmp_name'];
                $file_name = basename($_FILES['mailAttach']['name']);
                $gmailParam->setMailAttachPath($target_path);
                $gmailParam->setMailAttachFileName($file_name);
            }

            //mail send by Gmail
            $gmail = new Gmail();
            $results = $gmail->sendMessage($gmailParam);

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
