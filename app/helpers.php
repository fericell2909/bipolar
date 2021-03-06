<?php

if (!function_exists('calculate_percentage')) {
    function calculate_percentage($total, $percentage)
    {
        $discount = $total * ($percentage / 100);

        return $discount;
    }
}

if (!function_exists('bipolar_get_page_from_slug_in_list')) {
    /**
     * @param \Illuminate\Support\Collection $pagesList
     * @param $slug
     * @return \App\Models\Page|null
     */
    function bipolar_get_page_from_slug_in_list(\Illuminate\Support\Collection $pagesList, $slug)
    {
        return $pagesList->first(function ($page) use ($slug) {
            return $page->slug === $slug;
        });
    }
}

if (!function_exists('bipolar_mail_subject_env_header')) {
    /**
     * @param string $subject
     * @return $string
     */
    function bipolar_mail_subject_env_header(string $subject)
    {
        return config('app.env') !== 'production' ? '[BETA] ' . $subject : $subject;
    }
}

if (!function_exists('bipolar_mail_asset_url')) {
    /**
     * @param string $url
     * @param mixed $message
     * @return $string
     */
    function bipolar_mail_asset_url(string $url, $message)
    {
        return config('app.env') !== 'production' ? "https://www.bipolar.com.pe/{$url}" : $message->embed(public_path() . "/{$url}");
    }
}

if (!function_exists('bipolar_generate_buyer_id')) {
    /**
     * @param int $userId
     * @return string
     */
    function bipolar_generate_buyer_id(int $userId)
    {
        return str_pad((string)$userId, 11, "0", STR_PAD_LEFT);
    }
}
