<?php
namespace App\Object\GoogleApi;

use App\Models\GoogleApi\GoogleUsersParam;
use Exception;
use Google_Service_Directory;
use Google_Service_Directory_User;
use Google_Service_Directory_UserName;
use Illuminate\Support\Facades\Log;

/**
 * Class GSuiteAdmin
 * @package App\Object\GoogleApi
 */
class GSuiteAdmin
{
    private $resCode ='0000';
    private $resMessage = '등록 완료';

    private $service;

    /**
     * GSuiteAdmin constructor.
     * @param GSuiteAdminClient $GSuiteAdminClient
     */
    public function __construct(GSuiteAdminClient $GSuiteAdminClient)
    {
        $client = $GSuiteAdminClient->getClient();
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
                $this->resCode = '0000';
                $this->resMessage = '등록 완료';
            } else {
                $this->resCode = '1001';
                $this->resMessage = '등록 안됨';
            }
        } catch (Exception $e) {
            echo 'An error occurred: ' . $e->getMessage();
            $this->resCode = '1002';
            $this->resMessage  = '등록중 에러 : '.$e->getMessage();
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
            echo 'An error occurred: ' . $e->getMessage();
            throw new Exception('setUserInfo() error');
        }

    }


}