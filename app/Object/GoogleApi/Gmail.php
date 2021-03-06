<?php
namespace App\Object\GoogleApi;

use App\Models\GoogleApi\GmailParam;
use Exception;
use Google_Service_Gmail;
use Google_Service_Gmail_Message;
use Swift_Attachment;
use Swift_Message;
use App\Object\CommonConst as CODE;

/**
 * Class Gmail
 * @package App\Object\GoogleApi
 */
class Gmail
{
    private $resCode    = CODE::PROC_RETURN_DEFAULT;
    private $resMessage = CODE::PROC_RETURN_DEFAULT_MSG;

    private $userId = 'me';//인증 gmail 계정으로 세팅되는 특수 고정값
    private $service;

    /**
     * client 생성
     * @return bool
     */
    private function getMailClient()
    {
        try {
            $gmailClient = new GoogleClient();
            $client = $gmailClient->getClient(CODE::GOOGLE_API_GMAIL);
            $service = new Google_Service_Gmail($client);
            $this->service = $service->users_messages;
            return true;
        } catch (Exception $e) {
            echo 'getMailClient: ' . $e->getMessage();
            return false;
        }
    }

    /**
     * Gmail 전송
     * @param GmailParam $gmailParam
     * @return array
     */
    public function sendMessage(GmailParam $gmailParam)
    {

        try {
            $client = $this->getMailClient();
            if($client){
                $req_message = $this->setRequest($gmailParam);
                $google_message = $this->setMessage($req_message);

                $results = $this->service->send($this->userId, $google_message);
                if($results){
                    $message_id = $results->id;
                    $message_title = $this->getMessageTitle($message_id);

                    $this->resCode     = CODE::PROC_RETURN_SUCCEED;
                    $this->resMessage  = $message_title;
                }else{
                    $this->resCode     = CODE::PROC_RETURN_FAILED;
                    $this->resMessage  = CODE::PROC_RETURN_FAILED_MSG;
                }
            }else{
                $this->resCode     = CODE::CLIENT_CREATE_FAILED;
                $this->resMessage  = CODE::CLIENT_CREATE_FAILED_MSG;
            }

        } catch (Exception $e) {
            echo 'sendMessage: ' . $e->getMessage();
            $this->resCode     = CODE::PROC_RETURN_ERROR;
            $this->resMessage  = CODE::PROC_RETURN_ERROR_MSG.' : '.$e->getMessage();
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
            $req_message->setSubject($gmailParam->getMailSubject());
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
            echo 'setRequest: ' . $e->getMessage();
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
            echo 'setMessage: ' . $e->getMessage();
            throw new Exception('setMessage() error');
        }

    }

    /**
     * 전송한 메일의 제목을 가져옴
     * @param $message_id
     * @return mixed
     * @throws Exception
     */
    private function getMessageTitle($message_id)
    {
        try {
            $result_message = $this->service->get($this->userId, $message_id);
            $headers = collect($result_message->getPayload()->getHeaders());
            $message_title = $headers[CODE::MESSAGE_HEADER_TITLE]->value;

            return $message_title;
        } catch (Exception $e) {
            echo 'getMessageTitle: ' . $e->getMessage();
            throw new Exception('getMessageTitle() error');
        }
    }


}
