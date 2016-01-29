<?php
namespace app\components;

use yii\web\HttpException;

class TemporaryUnavailableException extends HttpException
{
    /**
     * Constructor.
     * @param string $message error message
     * @param integer $code error code
     * @param \Exception $previous The previous exception used for the exception chaining.
     */
    public function __construct($message = 'Сервис временно недоступен. Повторите попытку позже.', $code = 0, \Exception $previous = null)
    {
        parent::__construct(200, $message, $code, $previous);
    }

    /**
     * @return string the user-friendly name of this exception
     */
    public function getName()
    {
        return 'Доступ временно запрещен';
    }
}