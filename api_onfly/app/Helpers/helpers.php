<?php

if (! function_exists('collection')) {
    function collection($data, $code = null, $message = null)
    {
        $code = $code ?? 200;
        $collection = new \stdClass();
        $collection->data = $data;
        $collection->message = $message ?? "";
        return response()->json($collection, $code);
    }
}