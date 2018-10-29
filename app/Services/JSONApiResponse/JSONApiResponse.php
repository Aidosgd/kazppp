<?php

namespace App\Services\JSONApiResponse;


class JSONApiResponse
{
    /**
     * Сообщение для ошибки
     */
    const ERROR = "ERROR";
    /**
     * Сообщение для ошибки 400
     */
    const ERROR_400 = "BAD REQUEST";

    /**
     * Сообщение для ошибки 403
     */
    const ERROR_403 = "UNAUTHORIZED";

    /**
     * Сообщение для ошибки 404
     */
    const ERROR_404 = "NOT FOUND";

    /**
     * Сообщение для ошибки 500
     */
    const ERROR_500 = "INTERNAL SERVER ERROR";

    /**
     * Возвращает ответ в формате json с header 200.
     *
     * @param  array  $data
     * @return response
     */

    public function success($data = [])
    {
        $data = [
            "success" => true,
            "data" => $data
        ];

        return response()->make(
            $data,
            200,
            ['Content-Type' => 'application/json']
        );
    }

    /**
     * Общая ошибка с хедором 200
     *
     * @param string $msg - сообщение
     * @param string $code - код
     *
     * @return response
     */

    public function error($msg = self::ERROR, $code = "")
    {
        $data = [
            "success" => false,
            "data" => [
                "message" => $msg,
                "code" => $code
            ]
        ];

        return response()->make(
            $data,
            200,
            ['Content-Type' => 'application/json']
        );
    }

    /**
     * Ошибка BAD REQUEST с header 400.
     *
     * @param string $msg - сообщение
     * @return response
     */

    public function error400($msg = self::ERROR_400)
    {
        $data = [
            "success" => false,
            "data" => [
                "message" => $msg,
                "code" => 400,
            ]
        ];

        return response()->make(
            $data,
            400,
            ['Content-Type' => 'application/json']
        );
    }

    /**
     * Ошибка UNAUTHORIZED с header 403.
     *
     * @param string $msg - сообщение
     * @return response
     */

    public function error403($msg = self::ERROR_403)
    {
        $data = [
            "success" => false,
            "data" => [
                "message" => $msg,
                "code" => 403,
            ]
        ];

        return response()->make(
            $data,
            403,
            ['Content-Type' => 'application/json']
        );

    }

    /**
     * Ошибка NOT FOUND с header 404.
     *
     * @return response
     */

    public function error404()
    {
        $data = [
            "success" => false,
            "data" => [
                "message" => self::ERROR_404,
                "code" => 404,
            ]
        ];

        return response()->make(
            $data,
            404,
            ['Content-Type' => 'application/json']
        );
    }

    /**
     * Ошибка INTERNAL SERVER ERROR с header 500.
     *
     * @param string $msg - сообщение
     * @return response
     */

    public function error500($msg = self::ERROR_500)
    {
        $data = [
            "success" => false,
            "data" => [
                "message" => $msg,
                "code" => 500,
            ]
        ];

        return response()->make(
            $data,
            500,
            ['Content-Type' => 'application/json']
        );
    }
}