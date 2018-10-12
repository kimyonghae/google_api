<?php
namespace App\Object;

class CommonConst
{
    /*api flag*/
    const GOOGLE_API_GMAIL       = '01';
    const GOOGLE_API_GSUITEADMIN = '02';

    /*return code*/
    const PROC_RETURN_DEFAULT = '9999';
    const PROC_RETURN_SUCCEED = '0000';
    const PROC_RETURN_FAILED  = '1001';
    const PROC_RETURN_ERROR   = '1002';
    const CLIENT_CREATE_FAILED = '1003';

    /*return message*/
    const PROC_RETURN_DEFAULT_MSG = '처리할 수 없습니다';
    const PROC_RETURN_SUCCEED_MSG = '처리 성공';
    const PROC_RETURN_FAILED_MSG  = '처리 안됨';
    const PROC_RETURN_ERROR_MSG   = '처리중 에러';
    const CLIENT_CREATE_FAILED_MSG = 'GOOGLE API CLIENT 생성 실패';

    /*google api return index code*/
    const MESSAGE_HEADER_TITLE = 3;
    
}
