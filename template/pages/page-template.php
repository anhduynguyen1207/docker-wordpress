<?php

/**
 * Template name: template
 */
$title = "title";
$description = "description";

get_header();
get_template_part(apply_filters('theme_filter_get_template_part', "templates/content-template"));
get_footer();
