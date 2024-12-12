<?php

/**
 * Template name: About
 */
$title = "イシヅカモータースの強み";
$description = "イシヅカモータースの強み";

get_header();
get_template_part(apply_filters('theme_filter_get_template_part', "templates/content-about-en"));
get_template_part("parts/car_contact", "footer");
get_footer();
