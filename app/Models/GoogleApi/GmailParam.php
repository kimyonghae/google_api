<?php
namespace App\Models\GoogleApi;

class GmailParam
{
    private $mail_to;
    private $mail_toName;
    private $mail_subject;
    private $mail_contents;

    /**
     * @return mixed
     */
    public function getMailTo()
    {
        return $this->mail_to;
    }

    /**
     * @param mixed $mail_to
     */
    public function setMailTo($mail_to)
    {
        $this->mail_to = $mail_to;
    }

    /**
     * @return mixed
     */
    public function getMailToName()
    {
        return $this->mail_toName;
    }

    /**
     * @param mixed $mail_toName
     */
    public function setMailToName($mail_toName)
    {
        $this->mail_toName = $mail_toName;
    }

    /**
     * @return mixed
     */
    public function getMailSubject()
    {
        return $this->mail_subject;
    }

    /**
     * @param mixed $mail_subject
     */
    public function setMailSubject($mail_subject)
    {
        $this->mail_subject = $mail_subject;
    }

    /**
     * @return mixed
     */
    public function getMailContents()
    {
        return $this->mail_contents;
    }

    /**
     * @param mixed $mail_contents
     */
    public function setMailContents($mail_contents)
    {
        $this->mail_contents = $mail_contents;
    }



}
