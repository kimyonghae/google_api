<?php
namespace App\Object\GoogleApi;

use App\Models\GoogleApi\GmailParam;
use Exception;
use Google_Service_Gmail;
use Google_Service_Gmail_Message;
use Swift_Attachment;
use Swift_Message;

/**
 * Class Gmail
 * @package App\Object\GoogleApi
 */
class Gmail
{
    private $resCode ='0000';
    private $resMessage = '전송 완료';

    private $userId = 'me';//인증 gmail 계정으로 세팅되는 특수 고정값
    private $service;

    /**
     * Gmail constructor.
     * @param GmailClient $gmailClient
     */
    public function __construct(GmailClient $gmailClient)
    {
        $client = $gmailClient->getClient();
        $service = new Google_Service_Gmail($client);
        $this->service =$service->users_messages;
    }

    /**
     * Gmail 전송
     * @param GmailParam $gmailParam
     * @return array
     */
    public function sendMessage(GmailParam $gmailParam)
    {

        try {
            $req_message = $this->setRequest($gmailParam);
            $google_message = $this->setMessage($req_message);

            $results = $this->service->send($this->userId, $google_message);
            if($results){
                $result_message = $this->service->get($this->userId, $results->id);
                $headers = collect($result_message->getPayload()->getHeaders());

                $this->resCode = '0000';
                $this->resMessage  = $headers[3]->value;
            }else{
                $this->resCode = '1001';
                $this->resMessage  = '전송 안됨';
            }

        } catch (Exception $e) {
            echo 'An error occurred: ' . $e->getMessage();
            $this->resCode = '1002';
            $this->resMessage  = '전송중 에러 : '.$e->getMessage();
        }finally{
            return [
                'resCode' => $this->resCode
                ,'resMessage' => $this->resMessage
            ];
        }

    }

    /**
     * 메일 전송 Request 정보 세팅
     * @param GmailParam $gmailParam
     * @return Swift_Message
     * @throws Exception
     * @internal param $requestValues
     */
    private function setRequest(GmailParam $gmailParam)
    {

        try {
            $req_message = new Swift_Message();

            $req_message->setTo($gmailParam->getMailTo(), $gmailParam->getMailToName());
            $req_message->setSubject($gmailParam->getMailSubject(). date('M d, Y h:i:s A'));
            $req_message->setBody($gmailParam->getMailContents(), 'text/html', 'utf-8');
            if( $gmailParam->getMailAttachPath() ) {
                $target_path = config('app.gmail_attach_file_path'). $gmailParam->getMailAttachFileName();
                if(move_uploaded_file($gmailParam->getMailAttachPath(), $target_path)){
                    $gmailParam->setMailAttachPath($target_path);
                    $req_message->attach(Swift_Attachment::fromPath($gmailParam->getMailAttachPath()));
                    //if we don't want to keep the image
                    //unlink($target_path);
                }
            }
            return $req_message;
        } catch (Exception $e) {
            echo 'An error occurred: ' . $e->getMessage();
            throw new Exception('setRequest() error');
        }

    }

    /**
     * 메일 전송 데이터 세팅
     * @param Swift_Message $req_message
     * @return Google_Service_Gmail_Message
     * @throws Exception
     */
    private function setMessage(Swift_Message $req_message)
    {

        try {
            $google_message = new Google_Service_Gmail_Message();
            $mime = rtrim(strtr(base64_encode($req_message), '+/', '-_'), '=');
            $google_message->setRaw($mime);

            return $google_message;
        } catch (Exception $e) {
            echo 'An error occurred: ' . $e->getMessage();
            throw new Exception('setMessage() error');
        }

    }


}
