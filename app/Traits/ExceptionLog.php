<?php

namespace App\Traits;

use App\Models\ErrorLog;

trait ExceptionLog
{
    public function exceptionHandle($exception, $function)
    {
        $exceptionArr = [
            'function' => $function,
            'filename' => $exception->getFile(),
            'line' => $exception->getLine(),
            'exception' => $exception->getMessage(),
        ];
        ErrorLog::create($exceptionArr);

        return true;
    }

    public function errorMessages($validator)
    {
        $ValidatorError = $validator->errors()->getMessages();
        foreach ($ValidatorError as $v_e_k => $v_e_v) {
            for ($i=0; $i < count($v_e_v); $i++) { 
                $validateData[$v_e_k] = $v_e_v[$i];
            }
        }
        return $validateData;
    }
}
