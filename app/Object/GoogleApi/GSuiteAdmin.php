<?php
namespace App\Object\GoogleApi;

use App\Models\GoogleApi\GoogleUsersParam;
use App\Object\CommonConst as CODE;
use Exception;
use Google_Service_Directory;
use Google_Service_Directory_User;
use Google_Service_Directory_UserName;

/**
 * Class GSuiteAdmin
 * @package App\Object\GoogleApi
 */
class GSuiteAdmin
{
    private $resCode ='9999';
    private $resMessage = '처리할 수 없습니다.';

    private $service;

    /**
     * GSuiteAdmin constructor.
     * @param GoogleClient $GSuiteAdminClient
     * @internal param $
     */
    public function __construct(GoogleClient $GSuiteAdminClient)
    {
        $client = $GSuiteAdminClient->getClient(CODE::GOOGLE_API_GSUITEADMIN);
        $service = new Google_Service_Directory($client);
        $this->service = $service->users;
    }

    /**
     * 신규 사용자 등록
     * @param GoogleUsersParam $googleUserParam
     * @return array
     */
    public function insertUser(GoogleUsersParam $googleUserParam)
    {

        try {

            $userInfo = $this->setUserInfo($googleUserParam);

            $results = $this->service->insert($userInfo);

            if ($results) {
                $this->resCode    = CODE::PROC_RETURN_SUCCEED;
                $this->resMessage = CODE::PROC_RETURN_SUCCEED_MSG;
            } else {
                $this->resCode    = CODE::PROC_RETURN_FAILED;
                $this->resMessage = CODE::PROC_RETURN_FAILED_MSG;
            }
        } catch (Exception $e) {
            echo 'insertUser: ' . $e->getMessage();
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
     * 신규 사용자 google api 등록 정보 세팅
     * @param GoogleUsersParam $googleUserParam
     * @return Google_Service_Directory_User
     * @throws Exception
     * @internal param GoogleUsersParam $param
     */
    public function setUserInfo(GoogleUsersParam $googleUserParam)
    {

        try {
            $userName = new Google_Service_Directory_UserName();
            $userInfo = new Google_Service_Directory_User();

            $userName->setFamilyName($googleUserParam->getFamilyName());
            $userName->setGivenName($googleUserParam->getGivenName());
            $userName->setFullName($googleUserParam->getFullName());

            $userInfo->setPrimaryEmail($googleUserParam->getPrimaryEmail());
            $userInfo->setName($userName);
            $userInfo->setHashFunction($googleUserParam->getHashFunction());
            $userInfo->setPassword($googleUserParam->getPassword());

            return $userInfo;
        } catch (Exception $e) {
            echo 'setUserInfo: ' . $e->getMessage();
            throw new Exception('setUserInfo() error');
        }

    }


}
