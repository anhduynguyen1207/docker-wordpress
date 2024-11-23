<?php

/**
 * Theme functions: init, enqueue scripts and styles, include required files and widgets
 */

if (!defined('THEME_DIR')) {
    define('THEME_DIR', trailingslashit(get_template_directory()));
}
if (!defined('THEME_URL')) {
    define('THEME_URL', trailingslashit(get_template_directory_uri()));
}

if (!defined('THEME_STYLE')) {
    define('THEME_STYLE', THEME_URL . 'assets/css/');
}

if (!defined('THEME_SCRIPT')) {
    define('THEME_SCRIPT', THEME_URL . 'assets/js/');
}

if (!defined('THEME_IMAGE')) {
    global $folder_img;
    if ($folder_img != '') {
        define('THEME_IMAGE', THEME_URL . 'assets/images/' . $folder_img . '/');
    } else {
        define('THEME_IMAGE', THEME_URL . 'assets/images/');
    }
}

//-------------------------------------------------------
//-- Theme init
//-------------------------------------------------------

if (!function_exists('theme_setup')) {
    add_action('after_setup_theme', 'theme_setup');
    /**
     * A general theme setup: add a theme supports, navigation menus, hooks for other actions and filters.
     */
    function theme_setup()
    {
        // Add post thumbnail
        add_theme_support('post-thumbnails');

        // // Add required meta tags in the head
        // add_action('wp_head', 'theme_wp_head', 0);

        // // Enqueue scripts and styles for the frontend
        // add_action('wp_enqueue_scripts', 'theme_styles', 1000);

        // // Enqueue scripts for the frontend
        // add_action('wp_enqueue_scripts', 'theme_scripts', 1000);
        add_action('wp_footer', 'theme_wp_footer');

        // // Add pagination
        // add_action('theme_pagination', 'theme_pagination_template', 1500);
    }
}

if (!function_exists('theme_wp_footer')) {
    /**
     * Add script to the footer for the frontend
     * Hooks: add_action('wp_footer', 'theme_wp_footer');
     */
    function theme_wp_footer()
    {
        wp_enqueue_script('handle-name', THEME_SCRIPT . 'common.js', 'all');
    }
}

if (!function_exists('theme_scripts')) {
    /**
     * Theme style: scripts
     * Hooks: add_action('wp_enqueue_scripts', 'theme_scripts', 1000);
     */
    function theme_scripts()
    {
        wp_enqueue_script('commons', THEME_SCRIPT . 'common.js', 'all');
    }
}

//　記事一覧画面にサムネイル画像を出す
add_theme_support('post-thumbnails');

// the_excerpt();で表示される「…」の表記を変える
function new_excerpt_more($post)
{
    return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');

// the_excerpt();の抜粋の文字数を変更する
function new_excerpt_mblength($length)
{
    return 120;
}
add_filter('excerpt_mblength', 'new_excerpt_mblength');

// 文字制限
function text_cut($str, $int)
{
    return mb_substr($str, 0, $int) . '...';
}

// Stop to read emoji
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// Stop to Update of WordPress
// add_filter("pre_site_transient_update_core", "__return_null");
// add_filter("pre_site_transient_update_themes", "__return_null");

// Stop to Update of Plugin
// add_filter("pre_site_transient_update_plugins", "__return_null");

// caution_update_wordpress
add_action('wp_dashboard_setup', 'caution_dashboard_widgets');
function caution_dashboard_widgets()
{
    global $wp_meta_boxes;
    wp_add_dashboard_widget('custom_help_widget', 'お願いと注意事項', 'dashboard_caution');
}
function dashboard_caution()
{
    $html = '<div class="box-dashboard-caution"><span style="color: red; font-weight:bold; text-decoration:underline">お客様自身でのWordPressの更新・プラグイン（Plugin）の更新は行わないでください。</span><br><br>お客様自身でこれらを更新し、不具合が出た場合は有償対応となりますので、ご注意下さい。弊社では、<a href="' . get_template_directory_uri() . '/common/other/conservation_information.pdf" target="_blank" rel="noopener">保守・管理プラン</a>もご用意しておりますので、WordPressの管理・更新をご希望のお客様はご検討をお願いいたします。</div>';
    echo $html;
}

// caution_no_index
$current_user = wp_get_current_user();
if ($current_user->get('ID')  == '1') {
    add_action('wp_dashboard_setup', 'caution_dashboard_no_index');
}
function caution_dashboard_no_index()
{
    wp_add_dashboard_widget('before_caution', '本番化時の確認事項', 'dashboard_caution_no_index');
}
function dashboard_caution_no_index()
{
    $html = '<div class="box-dashboard-caution"><span style="color: red; font-weight:botext-decoration:underline">「設定」→「表示設定」→「検索エンジンでの表示」のno_index設定を外す</span></div>';
    echo $html;
}

// ヘッダーの余分な記述を削除
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'wp_generator');

/*----------------------------------------------------*/
/* date.php用
/*----------------------------------------------------*/
function change_posts_per_page($query)
{
    if (is_admin() || ! $query->is_main_query()) {
        return;
    }
    if ($query->is_date()) {
        $query->set('posts_per_page', '12');
        return;
    }
}
add_action('pre_get_posts', 'change_posts_per_page');

//カスタム投稿の検索機能追加
add_filter('template_include', 'custom_search_template');
function custom_search_template($template)
{
    if (is_search()) {
        $post_types = get_query_var('post_type');
        foreach ((array) $post_types as $post_type)
            $templates[] = "search-{$post_type}.php";
        $templates[] = 'search.php';
        $template = get_query_template('search', $templates);
    }
    return $template;
}

add_filter('post_type_link', 'myposttype_permalink', 1, 3);
function myposttype_permalink($post_link, $id = 0, $leavename)
{
    global $wp_rewrite;
    $post = &get_post($id);
    if (is_wp_error($post))
        return $post;
    $newlink = $wp_rewrite->get_extra_permastruct($post->post_type);
    $newlink = str_replace('%' . $post->post_type . '_id%', $post->ID, $newlink);
    $newlink = home_url(user_trailingslashit($newlink));
    return $newlink;
}

// come out block editor
function allowed_block_editor($allowed_block_types, $post)
{
    if ($post->post_type === 'post') {
        $allowed_block_types = [
            'core/paragraph',   //段落    
            'core/heading', //見出し
            'core/image',   //画像
        ];
    }
    return $allowed_block_types;
}
add_filter('allowed_block_types', 'allowed_block_editor', 10, 2);

/*----------------------------------------------------*/
/* 【管理画面】編集者の権限拡大
/*----------------------------------------------------*/
function add_theme_editor()
{
    $role = get_role('editor');
    $role->add_cap('list_users');
    $role->add_cap('edit_users');
    $role->add_cap('create_users');
    $role->add_cap('delete_users');
    $role->remove_cap('edit_pages');
}
add_action('admin_init', 'add_theme_editor');

/* ログイン画面に任意のロゴ設置
*************************************************************************************/
function custom_login_logo()
{
    echo '<style type="text/css">.login h1 a { width: 250px !important; height: 100px !important; background: url(' . get_template_directory_uri() . '/img/about/logo-about-01.png) no-repeat center center !important; margin-bottom: 30px !important; background-size: 100% auto !important;}</style>';
}
add_action('login_enqueue_scripts', 'custom_login_logo');

/* 【MW MW Form】お問い合わせエラーメッセージをカスタマイズ
*************************************************************************************/
function my_validation_rule_49($Validation, $data, $Data)
{
    $Validation->set_rule('name', 'noEmpty', array('message' => '※お名前を入力してください。'));
    $Validation->set_rule('p-postal-code', 'noEmpty', array('message' => '※郵便番号を入力してください。'));
    $Validation->set_rule('p-postal-code', 'zip', array('message' => '※郵便番号の形式ではありません。'));
    $Validation->set_rule('p-region', 'noEmpty', array('message' => '※ご住所を入力してください。'));
    $Validation->set_rule('mail', 'noEmpty', array('message' => '※メールアドレスを入力してください。'));
    $Validation->set_rule('mail', 'mail', array('message' => '※メールアドレスの形式ではありません。'));
    $Validation->set_rule('tel', 'noEmpty', array('message' => '※電話番号を入力してください。'));
    $Validation->set_rule('tel', 'tel', array('message' => '※電話番号の形式ではありません。'));
    $Validation->set_rule('comment', 'noEmpty', array('message' => '※お問い合わせ内容を入力してください。'));
    $Validation->set_rule('checkbox', 'required', array('message' => '※『個人情報保護方針を確認の上、同意します。』にチェックを入れてください。'));
    return $Validation;
}
add_filter('mwform_validation_mw-wp-form-49', 'my_validation_rule_49', 10, 3);

/* 投稿 alt設定
*************************************************************************************/
// the_content(本文出力時)にフックさせる処理内容
function customize_img_attribute($content)
{
    $re_content = $content;
    $re_content = str_replace('alt=""', 'alt="ブログ画像"', $re_content);
    $re_content = preg_replace('/(<img[^>]*)width="\d+"\s+height="\d+"\s/', '$1', $re_content);
    $re_content = preg_replace('/(<img[^>]*)(class="[^"]*"\s)/', '$1', $re_content);
    return $re_content;
}

//get_image_tag(画像挿入時)にフックさせる処理内容
function remove_image_attribute($html)
{
    $re_html = $html;
    $re_html = str_replace('alt=""', 'alt="ブログ画像"', $re_html);
    $re_html = preg_replace('/(width|height)="\d*"\s/', '', $re_html);
    $re_html = preg_replace('/class="([^"]*)"\s/', '', $re_html);
    return $re_html;
}

//the_contentとget_image_tagのadd_filter
add_filter('the_content', 'customize_img_attribute');
add_filter('get_image_tag', 'remove_image_attribute');
add_filter('wp_calculate_image_srcset_meta', '__return_null');

/* メディア画像 アップロード時に自動でリサイズ
*************************************************************************************/
function otocon_resize_at_upload($file)
{
    if ($file['type'] == 'image/jpeg' or $file['type'] == 'image/gif' or $file['type'] == 'image/png') {
        $w = 1500;
        $h = 0;
        $image = wp_get_image_editor($file['file']);

        if (! is_wp_error($image)) {
            $size = getimagesize($file['file']);

            if ($size[0] > $w || $size[1] > $h) {
                $image->resize($w, $h, false);
                $final_image = $image->save($file['file']);
            }
        }
    }
    return $file;
}
add_action('wp_handle_upload', 'otocon_resize_at_upload');

/* ACF
*************************************************************************************/
/* カスタム投稿タイプ（実績紹介）でカテゴリー未選択時に自動で振り分ける
*************************************************************************************/
add_action('publish_works', 'add_defaultcategory_automatically');

function add_defaultcategory_automatically($post_ID)
{
    global $wpdb;
    $curTerm = wp_get_object_terms($post_ID, 'works-cat');
    if (0 == count($curTerm)) {
        $defaultTerm = array(6);
        wp_set_object_terms($post_ID, $defaultTerm, 'works-cat');
    }
}
add_filter('post_type_link', 'custom_term_link_works', 1, 3);

/* カスタム投稿タイプ（products）でカテゴリー未選択時に自動で振り分ける　※追加する場合の記述
*************************************************************************************/
//add_action('publish_products', 'add_defaultcategory_automatically_2');
//
//function add_defaultcategory_automatically_2($post_ID) {
//    global $wpdb;
//    $curTerm = wp_get_object_terms($post_ID, 'products-cat');
//    if (0 == count($curTerm)) {
//        $defaultTerm= array(13);
//        wp_set_object_terms($post_ID, $defaultTerm, 'products-cat');
//    }
//}
//add_filter( 'post_type_link', 'custom_term_link_products' , 1, 3 );


/* カスタム投稿タイプ（実績紹介）を定義
*************************************************************************************/
add_action('init', 'register_cpt_works');

function register_cpt_works()
{
    $labels = array(
        'name' => __('実績紹介', 'works'),
        'singular_name' => __('実績紹介', 'works'),
        'add_new' => __('実績紹介を追加', 'works'),
        'add_new_item' => __('新しい実績紹介を追加', 'works'),
        'edit_item' => __('実績紹介を編集', 'works'),
        'new_item' => __('新しい実績紹介', 'works'),
        'view_item' => __('実績紹介を見る', 'works'),
        'search_items' => __('実績紹介検索', 'works'),
        'not_found' => __('実績紹介が見つかりません', 'works'),
        'not_found_in_trash' => __('ゴミ箱に実績紹介はありません', 'works'),
        'parent_item_colon' => __('親実績紹介', 'works'),
        'menu_name' => __('実績紹介', 'works'),
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'description' => '実績紹介',
        'supports' => array('title', 'excerpt', 'thumbnail', 'custom-fields'),
        'public' => true,
        'show_ui' => true,
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );
    register_taxonomy(
        'works-cat',
        'works',
        array(
            'label' =>  '実績紹介カテゴリー',
            'labels' => array(
                'popular_items' => 'よく使う実績紹介カテゴリー',
                'edit_item' => '実績紹介カテゴリーを編集',
                'add_new_item' => '新規実績紹介カテゴリーを追加',
                'search_items' =>  '実績紹介カテゴリーを検索',
            ),
            'public' => true,
            'hierarchical' => true,
            'rewrite' => array('slug' => 'works-cat')
        )
    );
    register_post_type('works', $args);
}

// カスタム投稿タイプ（実績紹介）のパーマリンクを記事IDにする
add_action('init', 'myposttype_rewrite_works');

function myposttype_rewrite_works()
{
    global $wp_rewrite;

    $queryarg = 'post_type=works&p=';
    $wp_rewrite->add_rewrite_tag('%works_id%', '([^/]+)', $queryarg);
    $wp_rewrite->add_permastruct('works', 'works/%works-cat%/%works_id%.html', false);
}

// 実績紹介の詳細ページをカテゴリーを含むURLにする
function custom_term_link_works($post_link, $id = 0)
{
    $post = get_post($id);
    if (is_wp_error($post) || 'works' != $post->post_type || empty($post->ID)) {
        return $post_link;
    }
    $terms = get_the_terms($post->ID, 'works-cat');
    if (is_wp_error($terms) || !$terms) {
        $term_slug = 'uncategorised';
    } else {
        $term_obj = array_pop($terms);
        $term_slug = $term_obj->slug;
    }
    return home_url(user_trailingslashit("works/$term_slug/$post->ID.html"));
}
