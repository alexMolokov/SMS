<?php
/**
 * Created by PhpStorm.
 * User: Анастасия
 * Date: 10.01.2019
 * Time: 15:36
 */

namespace Kibernika\SMS\Provider\PlayMobile;


class Error
{
       const INTERNAL_SERVER_ERROR = 100;
       const SYNTAX_ERROR = 101;
       const ACCOUNT_LOCK = 102;
       const EMPTY_CHANNEL = 103;
       const INVALID_PRIORITY = 104;
       const TOO_MUCH_IDS = 105;
       const EMPTY_RECIPIENT = 202;
       const EMPTY_EMAIL_ADDRESS = 204;
       const EMPTY_MESSAGE_ID = 205;
       const INVALID_VARIABLES = 206;
       const INVALID_LOCALTIME = 301;
       const INVALID_START_DATETIME = 302;
       const INVALID_END_DATETIME = 303;
       const INVALID_ALLOWED_STARTTIME = 304;
       const INVALID_ALLOWED_ENDTIME = 305;
       const INVALID_SEND_EVENLY = 306;
       const EMPTY_ORIGINATOR = 401;
       const EMPTY_APPLICATION = 402;
       const EMPTY_TTL = 403;
       const EMPTY_CONTENT = 404;
       const CONTENT_ERROR = 405;
       const INVALID_CONTENT = 406;
       const INVALID_TTL = 407;
       const INVALID_ATTACHED_FILES = 408;
       const INVALID_RETRY_ATTEMPTS = 410;
       const INVALID_RETRY_TIMEOUT = 411;
       
       
       public static function getErrorMessage($error) {
           $messages = [
                self::INTERNAL_SERVER_ERROR => "Internal server error", // Внутренняя ошибка сервера
               self:: SYNTAX_ERROR => "Syntax error", //Синтаксическая ошибка
               self:: ACCOUNT_LOCK => "Account lock", //Account lock
               self:: EMPTY_CHANNEL => "Empty channel", //Не задан канал для отправки сообщений
               self:: INVALID_PRIORITY => "Invalid priority", // Указано некорректное значение параметра priority
               self:: TOO_MUCH_IDS => "Too much IDs", // Передано слишком много идентификаторов сообщений
               self:: EMPTY_RECIPIENT => "Empty recipient", // Адрес получателя не задан (кроме канала  email)
               self:: EMPTY_EMAIL_ADDRESS => "Empty email address", // Адрес электронной почты получателя не задан (для канала email)
               self:: EMPTY_MESSAGE_ID => "Empty message-id", // Идентификатор сообщения не задан
               self:: INVALID_VARIABLES => "Invalid variables", // Указано некорректное значение параметра variables
               self:: INVALID_LOCALTIME => "Invalid localtime", // Указано некорректное значение параметра localtime
               self:: INVALID_START_DATETIME => "Invalid start-datetime", // Указано некорректное значение параметра start-datetime
               self:: INVALID_END_DATETIME => "Invalid end-datetime", // Указано некорректное значение параметра end-datetime
               self:: INVALID_ALLOWED_STARTTIME => "Invalid allowed-starttime", // Указано некорректное значение параметра allowed-starttime
               self:: INVALID_ALLOWED_ENDTIME => "Invalid allowed-endtime", // Указано некорректное значение параметра allowed-endtime
               self:: INVALID_SEND_EVENLY => "Invalid send-evenly", // Указано некорректное значение параметра send-evenly
               self:: EMPTY_ORIGINATOR => "Empty originator", // Адрес отправителя не указан
               self:: EMPTY_APPLICATION => "Empty application", // Приложение не указано
               self:: EMPTY_TTL => "Empty ttl", //Значение ttl не указано (если задано  несколько каналов отправки)
               self:: EMPTY_CONTENT => "Empty content", // Содержимое сообщения не указано
               self:: CONTENT_ERROR => "Content error", // Неправильный формат содержимого контента
               self:: INVALID_CONTENT => "Invalid content", // Недопустимое значение контента для указанного канала
               self:: INVALID_TTL => "Invalid ttl", // Неправильно указано значение времени ожидания доставки
               self:: INVALID_ATTACHED_FILES => "Invalid attached files", //  Прикрепленные файлы имеют слишком большой объем
               self:: INVALID_RETRY_ATTEMPTS => "Invalid retry-attempts", // Неправильно указано значение количества попыток дозвона
               self:: INVALID_RETRY_TIMEOUT => "Invalid retry-timeout" // Неправильно указано значение времени повторного дозвона
           ];

           return (isset($messages[$error]))? $messages[$error]: "Message for error code {$error} not found";
       }
}

