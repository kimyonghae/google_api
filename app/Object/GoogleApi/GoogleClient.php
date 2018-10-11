<?php
namespace App\Object\GoogleApi;

use App\Object\CommonConst as CODE;
use Google_Client;
use Google_Service_Directory;
use Google_Service_Gmail;
use Exception;

class GoogleClient
{
    private $client_id;
    private $project_id;
    private $client_secret;
    private $scope;
    private $token;

    /**
     * @param $apiFlag
     * @return Google_Client
     * @throws Exception
     */
    public function getClient($apiFlag)
    {

        try
        {
            if(CODE::GOOGLE_API_GMAIL == $apiFlag){
                //gmail
                $this->scope = Google_Service_Gmail::MAIL_GOOGLE_COM;
                $this->client_id = config('app.gmail_client_id');
                $this->project_id = config('app.gmail_project_id');
                $this->client_secret = config('app.gmail_client_secret');
                $this->token = config('app.gmail_token');
            }else if(CODE::GOOGLE_API_GSUITEADMIN == $apiFlag){
                //gsuiteadmin
                $this->scope = Google_Service_Directory::ADMIN_DIRECTORY_USER;
                $this->client_id = config('app.gsuiteadmin_client_id');
                $this->project_id = config('app.gsuiteadmin_project_id');
                $this->client_secret = config('app.gsuiteadmin_client_secret');
                $this->token = config('app.gsuite_token');
            }

            $client = new Google_Client();
            $client->setApplicationName('Google API PHP');
            $client->setAccessType('offline');
            $client->setScopes($this->scope);
            $client->setAuthConfig($this->getAuthConfig());

            $credentialsPath = $this->token;
            if (file_exists($credentialsPath)) {
                $accessToken = json_decode(file_get_contents($credentialsPath), true);
            } else {
                throw new Exception('not exists token');
            }
            $client->setAccessToken($accessToken);

            // Refresh the token if it's expired.
            if ($client->isAccessTokenExpired()) {
                // save refresh token to some variable
                $refreshTokenSaved = $client->getRefreshToken();
                // update access token
                $client->fetchAccessTokenWithRefreshToken($refreshTokenSaved);
                // pass access token to some variable
                $accessTokenUpdated = $client->getAccessToken();
                // append refresh token
                $accessTokenUpdated['refresh_token'] = $refreshTokenSaved;
                // save to file
                file_put_contents($credentialsPath, json_encode($accessTokenUpdated));
            }
            return $client;
        }
        catch (Exception $e)
        {
            echo 'An error occurred: ' . $e->getMessage();
            throw new Exception('getClient() error');
        }

    }

    /**
     * @return array
     */
    private function getAuthConfig()
    {
        return [
            "installed"=>[
                "client_id" => $this->client_id,
                "project_id" => $this->project_id,
                "auth_uri" => "https=>//accounts.google.com/o/oauth2/auth",
                "token_uri" => "https=>//www.googleapis.com/oauth2/v3/token",
                "auth_provider_x509_cert_url"=>"https=>//www.googleapis.com/oauth2/v1/certs",
                "client_secret"=> $this->client_secret,
                "redirect_uris"=>[
                    "urn:ietf:wg:oauth:2.0:oob",
                    "http=>//localhost"
                ]
            ]
        ];

    }


}
