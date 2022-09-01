<?php

namespace App\Utils;

class ResponseUtil
{
    /**
     * @param  string  $message
     * @param  mixed  $data
     *
     * @return array
     */
    public static function makeResponse($message, $data)
    {
        return [
            'status' => true,
            'data'    => $data,
            'message' => $message,
        ];
    }

    /**
     * @param  string  $message
     * @param  array  $data
     *
     * @return array
     */
    public static function makeError($message, array $data = [])
    {
        $res = [
            'status' => false,
            'message' => $message,
        ];

        if (! empty($data)) {
            $res['data'] = $data;
        }

        return $res;
    }
}
