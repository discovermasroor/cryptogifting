<?php

function endsWith($haystack, $needle)
{
    $length = strlen($needle);
    if (!$length) {
        return true;
    }
    return substr($haystack, -$length) === $needle;
}


/**
 * @throws Exception
 */
function validatePartnerParams($partner_params)
{
    if ($partner_params == null) {
        throw new Exception("Please ensure that you send through partner params");
    }
    if (!array_key_exists("user_id", $partner_params)
        || !array_key_exists("job_id", $partner_params)
        || !array_key_exists("job_type", $partner_params)) {
        throw new Exception("Partner Parameter Arguments may not be null or empty");
    }
    if (gettype($partner_params["job_id"]) !== "string") {
        throw new Exception("Please ensure job_id is a string");
    }
    if (gettype($partner_params["user_id"]) !== "string") {
        throw new Exception("Please ensure user_id is a string");
    }
    if (gettype($partner_params["job_type"]) !== "integer") {
        throw new Exception("Please ensure job_type is a integer");
    }
}


/**
 * @throws Exception
 */
function validateIdParams($id_params)
{
    if ($id_params == null) {
        throw new Exception("Please ensure that you send through partner params");
    }
    if (key_exists("entered", $id_params) && strtolower("{$id_params['entered']}") === "true") {
        foreach (["country", "id_type", "id_number"] as $key) {
            $message = "Please make sure that $key is included in the id_info and has a value";
            if (!array_key_exists($key, $id_params)) {
                throw new Exception($message);
            }
            if ($id_params[$key] === null) {
                throw new Exception($message);
            }
        }
    }
}

/**
 * @throws Exception
 */
function validateImageParams($image_details)
{
    if ($image_details === null) {
        throw new Exception('Please ensure that you send through image details');
    }
    if (gettype($image_details) !== "array") {
        throw new Exception('Image details needs to be an array');
    }
    $has_selfie = false;
    foreach ($image_details as $item) {
        if (gettype($item) !== "array"
            || !array_key_exists("image_type_id", $item)
            || !array_key_exists("image", $item)) {
            throw new Exception("Image details content must to be an array with 'image_type_id' and 'image' has keys");
        }
        if ($item["image_type_id"] === 0 || $item["image_type_id"] === 2) {
            $has_selfie = true;
        }
    }
    if (!$has_selfie) {
        throw new Exception('You need to send through at least one selfie image');
    }
}

/**
 * @throws Exception
 */
function validateOptions($options)
{
    foreach (array_keys($options) as $key) {
        if ($key !== "optional_callback" && gettype($options[$key]) !== "boolean") {
            throw new Exception("$key need to be a boolean");
        }
        if ($key === "optional_callback" && gettype($options[$key]) !== "string") {
            throw new Exception("$key need to be a string");
        }
    }
    if (!strlen(array_value_by_key("optional_callback", $options)) && !array_value_by_key("return_job_status", $options)) {
        throw new Exception("Please choose to either get your response via the callback or job status query");
    }
}

function array_value_by_key($key, $array)
{
    if (key_exists($key, $array)) {
        return $array[$key];
    } else {
        return null;
    }
}
