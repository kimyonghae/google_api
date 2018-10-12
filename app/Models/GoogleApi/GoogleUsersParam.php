<?php
namespace App\Models\GoogleApi;

class GoogleUsersParam
{
    private $family_name;
    private $given_name;
    private $full_name;
    private $hash_function = 'SHA-1'; //hash() 에서는 SHA1, google api 에서는 SHA-1 표기로 사용됨.
    private $password;
    private $primary_email;

    /**
     * @return mixed
     */
    public function getFamilyName()
    {
        return $this->family_name;
    }

    /**
     * @return mixed
     */
    public function getGivenName()
    {
        return $this->given_name;
    }

    /**
     * @return mixed
     */
    public function getFullName()
    {
        return $this->full_name;
    }

    /**
     * @return string
     */
    public function getHashFunction()
    {
        return $this->hash_function;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getPrimaryEmail()
    {
        return $this->primary_email;
    }

    /**
     * @param mixed $family_name
     */
    public function setFamilyName($family_name)
    {
        $this->family_name = $family_name;
    }

    /**
     * @param mixed $given_name
     */
    public function setGivenName($given_name)
    {
        $this->given_name = $given_name;
    }

    /**
     * @param mixed $full_name
     */
    public function setFullName($full_name)
    {
        $this->full_name = $full_name;
    }

    /**
     * @param string $hash_function
     */
    public function setHashFunction($hash_function)
    {
        $this->hash_function = $hash_function;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password = 'password')
    {
        $this->password = hash('SHA1', $password);
    }

    /**
     * @param mixed $primary_email
     */
    public function setPrimaryEmail($primary_email)
    {
        $this->primary_email = $primary_email;
    }


}
