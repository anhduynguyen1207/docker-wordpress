<!doctype html>
<html lang="ja">

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
	<meta name="format-detection" content="telephone=no">
	<meta property="og:locale" content="ja_JP">
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:image" content="">
	<meta property="og:image" content="">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<script src="https://unpkg.com/lenis@1.1.9/dist/lenis.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
	<link rel="stylesheet" href="https://unpkg.com/lenis@1.1.13/dist/lenis.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="<?php echo THEME_STYLE ?>front-page.css" rel="stylesheet" type="text/css">

	<?php if (is_front_page()): ?>
		<title><?php bloginfo('name'); ?></title>
		<meta name="description" content="">
		<meta property="og:title" content="<?php bloginfo('name'); ?>">
		<meta property="og:type" content="website">
		<meta property="og:url" content="<?php echo esc_url(home_url('/')); ?>">
		<meta property="og:description" content="">
		<link href="<?php echo get_template_directory_uri(); ?>/css/front-page.css" rel="stylesheet" type="text/css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css">
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css">
	<?php elseif (is_post_type_archive('works')): ?>
		<title>実績紹介｜<?php bloginfo('name'); ?></title>
		<meta name="description" content="">
		<meta property="og:title" content="実績紹介｜<?php bloginfo('name'); ?>">
		<meta property="og:type" content="article">
		<meta property="og:url" content="<?php echo esc_url(home_url('/works')); ?>">
		<meta property="og:description" content="">
		<link href="<?php echo get_template_directory_uri(); ?>/css/works.css" rel="stylesheet" type="text/css">
	<?php elseif (is_tax('works-cat')): ?>
		<?php
		$term_name = single_term_title('', false);
		$term = get_term_by('name', $term_name, $taxonomy);
		$term_slug = $term->slug;
		$term_link = get_term_link($term_slug, 'works-cat');
		?>
		<title><?php echo $term_name; ?>｜実績紹介｜<?php bloginfo('name'); ?></title>
		<meta name="description" content="">
		<meta property="og:title" content="<?php echo $term_name; ?>｜実績紹介｜<?php bloginfo('name'); ?>">
		<meta property="og:type" content="article">
		<meta property="og:url" content="<?php echo esc_url(home_url('/works')); ?>">
		<meta property="og:description" content="">
		<link href="<?php echo get_template_directory_uri(); ?>/css/works.css" rel="stylesheet" type="text/css">
	<?php elseif (is_singular('works')): ?>
		<title><?php the_title(); ?>｜実績紹介｜<?php bloginfo('name'); ?></title>
		<meta name="description" content="<?php $c_txt = get_field('c_txt');
											$c_txt = preg_replace('/(?:\n|\r|\r\n)/', '', $c_txt);
											echo esc_html(wp_strip_all_tags($c_txt)); ?>">
		<meta property="og:title" content="<?php the_title(); ?>｜実績紹介｜<?php bloginfo('name'); ?>">
		<meta property="og:type" content="article">
		<meta property="og:url" content="<?php the_permalink(); ?>">
		<meta property="og:description" content="<?php $c_txt = get_field('c_txt');
													$c_txt = preg_replace('/(?:\n|\r|\r\n)/', '', $c_txt);
													echo esc_html(wp_strip_all_tags($c_txt)); ?>">
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css">
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css">
		<link href="<?php echo get_template_directory_uri(); ?>/css/works.css" rel="stylesheet" type="text/css">
	<?php elseif (is_page('contact')): ?>
		<title>お問い合わせ｜<?php bloginfo('name'); ?></title>
		<meta name="description" content="">
		<meta property="og:title" content="お問い合わせ｜<?php bloginfo('name'); ?>">
		<meta property="og:type" content="article">
		<meta property="og:url" content="<?php echo esc_url(home_url('/contact')); ?>">
		<meta property="og:description" content="">
		<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/contact.css">
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<?php elseif (is_page('confirm')): ?>
		<title>お問い合わせ内容確認｜<?php bloginfo('name'); ?></title>
		<link href="<?php echo get_template_directory_uri(); ?>/css/contact.css" rel="stylesheet" type="text/css">
		<meta name="robots" content="noindex,nofollow">
	<?php elseif (is_page('thanks')): ?>
		<title>お問い合わせありがとうございました｜<?php bloginfo('name'); ?></title>
		<link href="<?php echo get_template_directory_uri(); ?>/css/contact.css" rel="stylesheet" type="text/css">
		<meta http-equiv="refresh" content=";URL=<?php echo esc_url(home_url('/')); ?>">
		<meta name="robots" content="noindex,nofollow">
	<?php elseif (is_tag()): ?>
		<title><?php single_tag_title(); ?></title>
		<link href="<?php echo get_template_directory_uri(); ?>/css/news.css" rel="stylesheet" type="text/css">
	<?php elseif (is_category()): ?>
		<?php
		$cat = get_category($cat);
		$cat_name = $cat->name;
		$cat_slug = $cat->slug;
		?>
		<title><?php echo $cat_name; ?>｜<?php bloginfo('name'); ?></title>
		<meta name="description" content="<?php echo $cat_name; ?>のカテゴリーに関する記事を掲載しております。">
		<meta property="og:title" content="<?php echo $cat_name; ?>｜<?php bloginfo('name'); ?>">
		<meta property="og:type" content="article">
		<meta property="og:url" content="<?php echo esc_url(home_url('/category/')); ?><?php echo $cat_slug; ?>">
		<meta property="og:description" content="<?php echo $cat_name; ?>のカテゴリーに関する記事を掲載しております。">
		<link href="<?php echo get_template_directory_uri(); ?>/css/news.css" rel="stylesheet" type="text/css">
	<?php elseif (is_date()): ?>
		<title><?php echo get_the_date('Y年n月'); ?>の記事｜<?php bloginfo('name'); ?></title>
		<meta name="description" content="<?php echo get_the_date('Y年n月'); ?>に投稿された記事を掲載しております。">
		<meta property="og:title" content="<?php echo get_the_date('Y年n月'); ?>の記事｜<?php bloginfo('name'); ?>">
		<meta property="og:type" content="article">
		<meta property="og:url" content="<?php echo esc_url(home_url('/date/')); ?>/<?php echo get_the_date('Y/n'); ?>">
		<meta property="og:description" content="<?php echo get_the_date('Y年n月'); ?>に投稿された記事を掲載しております。">
		<link href="<?php echo get_template_directory_uri(); ?>/css/news.css" rel="stylesheet" type="text/css">
	<?php elseif (is_single()): ?>
		<title><?php the_title(); ?>｜<?php bloginfo('name'); ?></title>
		<meta name="description" content="<?php echo mb_substr(preg_replace("(\r\n|\r|\n|^ +)", "", strip_tags(apply_filters('	the_content', $post->post_content))), 0, 100); ?>">
		<meta property="og:title" content="<?php the_title(); ?>｜<?php bloginfo('name'); ?>">
		<meta property="og:type" content="article">
		<meta property="og:url" content="<?php the_permalink(); ?>">
		<meta property="og:description" content="<?php echo mb_substr(preg_replace("(\r\n|\r|\n|^ +)", "", strip_tags(apply_filters('the_content', $post->post_content))), 0, 100); ?>">
		<?php if (has_post_thumbnail()) : ?>
			<?php
			$image_id = get_post_thumbnail_id();
			$image_url = wp_get_attachment_image_src($image_id, 'medium');
			?>
			<meta property="og:image" content="<?php echo $image_url[0]; ?>">
		<?php else: ?>
			<meta property="og:image" content="">
		<?php endif; ?>
		<link href="<?php echo get_template_directory_uri(); ?>/css/news.css" rel="stylesheet" type="text/css">
	<?php elseif (is_404()): ?>
		<title>ページが存在しません｜<?php bloginfo('name'); ?></title>
		<meta http-equiv="refresh" content=";URL=<?php echo esc_url(home_url('/')); ?>">
		<link href="<?php echo get_template_directory_uri(); ?>/css/404.css" rel="stylesheet" type="text/css">
	<?php else: ?>
		<title>お知らせ｜<?php bloginfo('name'); ?></title>
		<meta name="description" content="">
		<meta property="og:title" content="お知らせ｜<?php bloginfo('name'); ?>">
		<meta property="og:type" content="article">
		<meta property="og:url" content="<?php echo esc_url(home_url('/news')); ?>">
		<meta property="og:description" content="">
		<link href="<?php echo get_template_directory_uri(); ?>/css/news.css" rel="stylesheet" type="text/css">
	<?php endif; ?>
	<?php wp_head(); ?>
</head>

<body>
	<?php if (!(is_page('contact/confirm'))): ?>
		<div class="wrapper">
			<?php
			// Header
			get_template_part(apply_filters('theme_filter_get_template_part', "templates/header-default"));
			?>
		<?php endif; ?>