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