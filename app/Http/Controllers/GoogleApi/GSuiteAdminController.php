<?php
namespace App\Http\Controllers\GoogleApi;

use App\Models\GoogleApi\GoogleUsersParam;
use App\Object\GoogleApi\GSuiteAdmin;
use App\Object\CommonConst as CODE;

class GSuiteAdminController
{
    private $resCode    = CODE::PROC_RETURN_DEFAULT;
    private $resMessage = CODE::PROC_RETURN_DEFAULT_MSG;

    /**
     * 신규 사용자 생성
     */
    public function insertGoogleUser()
    {

        try {
            //request set to param
            $googleUserParam = new GoogleUsersParam();
            $googleUserParam->setFamilyName(request('familyName'));
            $googleUserParam->setGivenName(request('givenName'));
            $googleUserParam->setFullName(request('fullName'));
            $googleUserParam->setPassword(request('password'));
            $googleUserParam->setPrimaryEmail(request('primaryEmail'));

            //user create
            $gsuiteAdmin = new GSuiteAdmin();
            $results = $gsuiteAdmin->insertUser($googleUserParam);

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
