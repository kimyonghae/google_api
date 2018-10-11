<?php
namespace App\Object;

class CommonConst
{
    /*return code*/
    const PROC_RETURN_DEFAULT = '9999';
    const PROC_RETURN_SUCCEED = '0000';
    const PROC_RETURN_FAILED  = '1001';
    const PROC_RETURN_ERROR   = '1002';

    /*return message*/
    const PROC_RETURN_DEFAULT_MSG = '처리할 수 없습니다';
    const PROC_RETURN_SUCCEED_MSG = '처리 성공';
    const PROC_RETURN_FAILED_MSG  = '처리 안됨';
    const PROC_RETURN_ERROR_MSG   = '처리중 에러';

    /*google api return index code*/
    const MESSAGE_HEADER_TITLE = 3;
}
