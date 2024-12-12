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

		// Add required meta tags in the head
		add_action('wp_head', 'theme_wp_head', 0);

		// Enqueue scripts and styles for the frontend
		add_action('wp_enqueue_scripts', 'theme_styles', 1000);

		// Enqueue scripts for the frontend
		add_action('wp_enqueue_scripts', 'theme_scripts', 1000);
		add_action('wp_footer', 'theme_wp_footer');

		// Add pagination
		add_action('theme_pagination', 'theme_pagination_template', 1500);
	}
}

//-------------------------------------------------------
//-- Head, body and footer
//-------------------------------------------------------
// Hàm set title và description cho tất cả các page để SEO (tìm kiếm trên google)
if (!function_exists('theme_wp_head')) {
	/**
	 * Add meta tags to the header for the frontend
	 * Hooks: add_action('wp_head', 'theme_wp_head', 0);
	 */
	function theme_wp_head()
	{
		global $title;
		$keywords = "";
		$description = "クリーン警備保障は石川県加賀地区、福井県を中心にお客様の安全を保障する交通誘導専門の警備会社です";
		$site_name = "";
		if (is_single()) $title = "新着情報詳細 ";
?>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="format-detection" content="telephone=no">
		<link rel="profile" href="//gmpg.org/xfn/11">
		<?php if (is_front_page()) { ?>
			<title>クリーン警備保障　石川県小松市・金沢市・富山県の交通誘導・会場誘導</title>
		<?php } else { ?>
			<title><?= $title ?>| クリーン警備保障＿石川県小松市・金沢市・富山県の交通誘導・会場誘導</title>
		<?php } ?>
		<link rel="icon" href="<?= THEME_IMAGE ?>favicon.ico">
		<meta name="keywords" content="<?= $keywords ?>">
		<meta name="description" content="<?= $description ?>">
		<meta property="og:type" content="website">
		<meta property="og:title" content="<?= $title ?>">
		<meta property="og:url" content="<?= site_url() ?>">
		<meta property="og:site_name" content="<?= $site_name ?>">
		<meta property="og:image" content="<?= THEME_IMAGE ?>ogp.jpg">
		<meta property="og:description" content="<?= $description ?>">
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<?php
	}
}

if (!function_exists('theme_wp_footer')) {
	/**
	 * Add script to the footer for the frontend
	 * Hooks: add_action('wp_footer', 'theme_wp_footer');
	 */
	function theme_wp_footer()
	{
		wp_register_script('handle-name', THEME_SCRIPT . 'common.js', 'all');
		wp_enqueue_script('handle-name');
	}
}

//-------------------------------------------------------
//-- Theme styles and scripts, images
//-------------------------------------------------------
// Hàm set style cho tất cả các page là liệt kê page nào xài scss của page đó
if (!function_exists('theme_styles')) {
	/**
	 * Theme style: styles
	 * Hooks: add_action('wp_enqueue_scripts', 'theme_styles', 1000);
	 */
	function theme_styles()
	{
		wp_enqueue_style('destyle', THEME_STYLE . 'destyle.css', 'all');

		wp_enqueue_style('theme-style', THEME_URL . 'style.css', array(), null);

		wp_enqueue_style('themes', THEME_STYLE . 'theme.css', 'all');
		wp_enqueue_style('commons', THEME_STYLE . 'common.css', 'all');
		wp_enqueue_style('header', THEME_STYLE . 'header.css', 'all');
		wp_enqueue_style('footer', THEME_STYLE . 'footer.css', 'all');
		wp_enqueue_style('participle', THEME_STYLE . 'participle.css', 'all');

		// styles for top page
		if (is_front_page()) {
			wp_enqueue_style('top', THEME_STYLE . 'top.css', 'all');
		}

		if (is_page('sample')) {
			wp_enqueue_style('sample', THEME_STYLE . 'sample.css', 'all');
		}
		if (is_404()) {
			wp_enqueue_style('404', THEME_STYLE . '404.css', 'all');
		}
		if (is_page('message')) {
			wp_enqueue_style('message', THEME_STYLE . 'message.css', 'all');
		}
		if (is_page('company')) {
			wp_enqueue_style('company', THEME_STYLE . 'company.css', 'all');
		}
		if (is_page('requirement')) {
			wp_enqueue_style('requirement', THEME_STYLE . 'requirement.css', 'all');
		}
		if (is_page('business')) {
			wp_enqueue_style('business', THEME_STYLE . 'business.css', 'all');
		}
		if (is_page('real-voice') || is_page('voice1') || is_page('voice2')) {
			wp_enqueue_style('real-voice', THEME_STYLE . 'real-voice.css', 'all');
		}
		if (is_page('info') || is_archive('work') || is_single()) {
			wp_enqueue_style('info', THEME_STYLE . 'information.css', 'all');
		}
		if (is_page('policy')) {
			wp_enqueue_style('policy', THEME_STYLE . 'policy.css', 'all');
		}
		if (is_page('contact') || is_page('contact/confirm')) {
			wp_enqueue_style('contact', THEME_STYLE . 'contact.css', 'all');
		}
		if (is_page('entry') || is_page('entry/confirm')) {
			wp_enqueue_style('entry', THEME_STYLE . 'entry.css', 'all');
		}
		if (is_page('contact/confirm') || is_page('entry/confirm')) {
			wp_enqueue_style('confirm', THEME_STYLE . 'confirm.css', 'all');
		}
		if (is_page('contact/confirm/thanks') || is_page('entry/confirm/thanks')) {
			wp_enqueue_style('thanks', THEME_STYLE . 'thanks.css', 'all');
		}
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

//-------------------------------------------------------
//-- Theme pagination
//-------------------------------------------------------
// Hàm phân trang 
if (!function_exists('theme_pagination_template')) {
	/**
	 * Theme pagination template
	 * Hooks: add_action('theme_pagination', 'theme_pagination_template', 1500);
	 */
	function theme_pagination_template($pages = '', $range = 1)
	{
		global $paged;
		if (empty($paged)) $paged = 1;
		if ($paged == 1) {
			$range = $range + 1;
		}
		$settings = array(
			'count' => $range,
			// 'dot_text' => '&hellip;',
		);
		$current = $paged;
		$total = $pages;
		// Offset for next link
		if ($current < $total)
			$settings['count']--;

		if ($current + 2 < $total) {
			$settings['count'] = $settings['count'] - 2;
		}
		if (empty($paged)) $paged = 1;

		if (1 != $pages) {
			if ($paged > 1) {
				echo "<a href='" . get_pagenum_link($paged - 1) . "' class='prevBtn'>
				<svg class='icon' xmlns='http://www.w3.org/2000/svg' width='22' height='22' viewBox='0 0 20 20'><path fill='black' d='m4 10l9 9l1.4-1.5L7 10l7.4-7.5L13 1z'/></svg></a>";
			} else {
				echo "<div href='' class='prevBtn disableBtn'>
				<svg class='icon' xmlns='http://www.w3.org/2000/svg' width='22' height='22' viewBox='0 0 20 20'><path fill='black' d='m4 10l9 9l1.4-1.5L7 10l7.4-7.5L13 1z'/></svg></div>";
			}
			// Previous Dot
			// if ($current > 3) {
			// 	echo '<div class="pagination_item pagination-omission">';
			// 	echo '<div class="pagination_link pagination_dot">' . $settings['dot_text'] . '</div>';
			// 	echo '</div>';
			// }


			// Prev Pages
			for ($i = $current - 2; $i < $current; $i++) {
				if ($i <= $total && $i > 0) {
					echo '<a href="' . get_pagenum_link($i) . '" class="inactive">' . $i . '</a>';
				}
			}

			// Current
			echo '<span class="current">' . $current . '</span>';

			// Next Pages
			for ($i = 1; $i < $range - 3; $i++) {
				$page = $current + $i;
				if ($page <= $total) {
					echo '<a href="' . get_pagenum_link($page) . '" class="inactive">' . $page . '</a>';
				}
			}

			if ($current < $total) {
				// Next
				// if ($current + 2 < $total && ($total > 8)) {
				// 	echo '<div class="pagination_item pagination-omission">';
				// 	echo '<div class="pagination_link pagination_dot">' . $settings['dot_text'] . '</div>';
				// 	echo '</div>';
				// }
				echo "<a href='" . get_pagenum_link($paged + 1) . "' class='nextBtn'>
        	<svg class='icon' xmlns='http://www.w3.org/2000/svg' width='22' height='22' viewBox='0 0 20 20'>
								<path fill='black' d='M7 1L5.6 2.5L13 10l-7.4 7.5L7 19l9-9z' />
							</svg></a>";
			} else {
				echo "<div class='nextBtn disableBtn'>
        	<svg class='icon' xmlns='http://www.w3.org/2000/svg' width='22' height='22' viewBox='0 0 20 20'>
								<path fill='black' d='M7 1L5.6 2.5L13 10l-7.4 7.5L7 19l9-9z' />
							</svg></div>";
			}
		}
	}
}
// Khi muốn set cho 1 biến nào đó gobal để những trang khác có thể xài
function set_global_valiables()
{
	global $date_v1, $name_jp_v1, $name_en_v1, $slogan_v1;
	$date_v1 = '入社9年目 40代　';
	$name_jp_v1 = '';
	$name_en_v1 = '';
	$slogan_v1 = 'たくさんのチャレンジや経験を積ませていただいています。';

	global $date_v2, $name_jp_v2, $name_en_v2, $slogan_v2;
	$date_v2 = '入社11年目 30代';
	$name_jp_v2 = '';
	$name_en_v2 = '';
	$slogan_v2 = 'この会社の将来、自分の未来があると信じています。';
}
add_action('after_setup_theme', 'set_global_valiables');
// Hàm set breadcrumb cho các trang 
function breadcrumb()
{
	$home = '<li><a href="' . get_bloginfo('url') . '" >TOP</a></li>';
	$infor = '<li><a href="/info" >新着情報</a></li>';
	$voice1 = '<li><a href="/real-voice" >社員の声</a></li><li>VOICE1</li>';
	$voice2 = '<li><a href="/real-voice" >社員の声</a></li><li>VOICE2</li>';
	$contactConfirm = '<li><a href="/contact" >お問い合わせ</a></li><li>お問い合わせ確認</li>';
	$contactThanks = '<li><a href="/contact" >お問い合わせ</a></li><li>お問い合わせ確認</li><li>お問い合わせ完了</li>';
	$entryConfirm = '<li><a href="/entry" >社員の声</a></li><li>採用応募フォーム確認</li>';
	$entryThanks = '<li><a href="/entry" >社員の声</a></li><li>採用応募フォーム確認</li><li>採用応募フォーム完了</li>';
	echo '<ul class="pankuzu">';
	if (is_front_page()) {
		// トップページの場合は表示させない
	}
	// カテゴリページ
	else if (is_category()) {
		$cat = get_queried_object();
		$cat_id = $cat->parent;
		$cat_list = array();
		while ($cat_id != 0) {
			$cat = get_category($cat_id);
			$cat_link = get_category_link($cat_id);
			array_unshift($cat_list, '<li><a href="' . $cat_link . '">' . $cat->name . '</a></li>');
			$cat_id = $cat->parent;
		}
		echo $home;
		foreach ($cat_list as $value) {
			echo $value;
		}
		the_archive_title('<li>', '</li>');
	}
	// アーカイブ・タグページ
	else if (is_archive()) {
		echo $home;
		the_archive_title('<li>', '</li>');
	}
	// 投稿ページ
	else if (is_single()) {
		echo $home;
		echo $infor;
		the_title('<li class="title_single">', '</li>');
	}
	// 固定ページ
	else if (is_page()) {
		if (is_page('voice1')) {
			echo $home;
			echo $voice1;
		} elseif (is_page('voice2')) {
			echo $home;
			echo $voice2;
		} elseif (is_page('voice2')) {
			echo $home;
			echo $voice2;
		} elseif (is_page('contact/confirm')) {
			echo $home;
			echo $contactConfirm;
		} elseif (is_page('contact/confirm/thanks')) {
			echo $home;
			echo $contactThanks;
		} elseif (is_page('entry/confirm')) {
			echo $home;
			echo $entryConfirm;
		} elseif (is_page('entry/confirm/thanks')) {
			echo $home;
			echo $entryThanks;
		} else {
			echo $home;
			the_title('<li>', '</li>');
		}
	}
	// 404ページの場合
	else if (is_404()) {
		echo $home;
		echo '<li>ページが見つかりません</li>';
	}
	echo "</ul>";
}
// アーカイブのタイトルを削除
add_filter('get_the_archive_title', function ($title) {
	if (is_category()) {
		$title = single_cat_title('', false);
	} elseif (is_tag()) {
		$title = single_tag_title('', false);
	} elseif (is_month()) {
		$title = single_month_title('', false);
	} elseif (is_post_type_archive()) {
		$title = post_type_archive_title('', false);
	}
	return $title;
});

add_action('init', 'unregister_tags');
// Hàm ẩn cattegory và post_tag trong admin,  ví dụ ở dưới đây là ẩn category và post_tag cho post_type == 'post' 
// nếu muốn ẩn các post_type khác thì điền vào
function unregister_tags()
{
	unregister_taxonomy_for_object_type('category', 'post');
	unregister_taxonomy_for_object_type('post_tag', 'post');
}

// Hàm phân trang cho các archive page trong WP
if (!function_exists('wpse_modify_category_query')) {
	function wpse_modify_category_query($query)
	{
		if (!is_admin() && $query->is_main_query()) {
			if ($query->is_archive()) {
				$query->set('posts_per_page', 1);
			}
		}
	}
}
add_action('pre_get_posts', 'wpse_modify_category_query');

// Tạo post_type cơ bản trong WP
function create_post_type()
{
	register_post_type('recruit', [
		'labels' => [
			'name'          => '採用', // 管理画面上で表示する投稿タイプ名
			'singular_name' => 'Recruit',    // カスタム投稿の識別名
		],
		'public'        => true,  // 投稿タイプをpublicにするか
		'has_archive'   => false, // アーカイブ機能ON/OFF
		'menu_position' => 9,     // 管理画面上での配置場所
		'rewrite' => array('slug' => 'recruit'), //スラッグ名
		'supports' => array('title'),
		// 'hierarchical' => true
	]);

	register_post_type('faq', [
		'labels' => [
			'name'          => 'よくある質問',
			'singular_name' => 'FAQ',
		],
		'public'        => true,
		'supports' => array('title', 'editor'),
		'has_archive'   => false,
		'menu_position' => 9,
		'rewrite' => array('slug' => 'faq'),
	]);
}
add_action('init', 'create_post_type');

// Viết cấu query cho WP
// Ví dụ cho câu ở dưới đây có nghĩa là lấy ra năm của post_type == 'post'  nó phải pusblish và add nó vào array $results.
function posts_by_year()
{
	// get posts from WP
	global $wpdb;
	$reuslts = array();
	$years = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT YEAR(post_date) FROM {$wpdb->posts} WHERE post_status = 'publish' AND post_type ='post'  GROUP BY YEAR(post_date) DESC"
		)
	);

	foreach ($years as $year) {
		array_push($reuslts, $year->{'YEAR(post_date)'});
	}
	return $reuslts;
}

// Thêm cho custom column trong WP admin 
// Dựa vào post type gi có thể thay thế tương ứng với chữ works ở dưới
// Kết hợp với SCF tạo ra fied đó và lấy dữ liệu hiện lên 
add_filter('manage_works_posts_columns', 'set_custom_edit_works_columns');
add_action('manage_works_posts_custom_column', 'custom_works_column', 10, 2);

function set_custom_edit_works_columns($columns)
{
	$columns['my_note'] = '社内向けメモ';
	return $columns;
}

function custom_works_column($column)
{
	if ($column == 'my_note') {
		echo scf::get('memo');
	}
}

// Hàm để thay đổi input type cho custom field
add_action('admin_footer', 'change_type_scripts');
function change_type_scripts()
{

	?>
	<script>
		jQuery(document).ready(function() {
			jQuery('input[name="smart-custom-fields[price][0]"]').prop("type", "number");
			jQuery('input[name="smart-custom-fields[price_2][0]"]').prop("type", "number");
			jQuery('input[name="smart-custom-fields[price_3][0]"]').prop("type", "number");
		});
	</script>
<?php
}

// Hàm xoá editor cơ bản trong WP 
// Ví dụ dưới đây là xoá editor cho post_type == 'estate'
add_action('init', function () {
	remove_post_type_support('estate', 'editor');
}, 99);

// Hàm add img trong taxonomy WP admin
// Ví dụ dưới đây sẽ thêm img cho taxonomy == 'lp_cate' 
// Ở trang edit thì sẽ hiện hình ảnh nếu có 
// Ở trang add thì sẽ thêm input để add hình ảnh và lưu nó lại để edit lấy ra và hiện lên 
// ADD  IMG TAXONOMY

function cptui_register_my_taxes_lp_cate()
{

	/**
	 * Taxonomy: LP Category.
	 */

	$labels = [
		"name" => __("All Categories", "custom-post-type-ui"),
		"singular_name" => __("lp_cate", "custom-post-type-ui"),
	];

	$args = [
		"label" => __("All Categories", "custom-post-type-ui"),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => ['slug' => 'lp_cate', 'with_front' => true,  'hierarchical' => true,],
		"show_admin_column" => true,
		"show_in_rest" => true,
		"rest_base" => "lp_cate",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
	];
	register_taxonomy("lp_cate", ["lp_page"], $args);
}
add_action('init', 'cptui_register_my_taxes_lp_cate');


function my_category_module()
{
	// Add these actions for edit and add
	add_action('edited_lp_cate', 'save_image');
	add_action('create_lp_cate', 'save_image');
	add_action('lp_cate_add_form_fields', 'edit_image_cat');
	add_action('lp_cate_edit_form_fields', 'edit_image_cat');
}
add_action('init', 'my_category_module');

function edit_image_cat($tag)
{
	$category_images_banner = get_option('category_images_banner');
	$category_image_banner = '';
	$category_images_banner_sp = get_option('category_images_banner_sp');
	$category_image_banner_sp = '';
	$category_images_icon = get_option('category_images_icon');
	$category_image_icon = '';
	if (is_array($category_images_banner) && array_key_exists($tag->term_id, $category_images_banner)) {
		$category_image_banner = $category_images_banner[$tag->term_id];
	}
	if (is_array($category_images_banner_sp) && array_key_exists($tag->term_id, $category_images_banner_sp)) {
		$category_image_banner_sp = $category_images_banner_sp[$tag->term_id];
	}
	if (is_array($category_images_icon) && array_key_exists($tag->term_id, $category_images_icon)) {
		$category_image_icon = $category_images_icon[$tag->term_id];
	}
?>
	<tr>
		<th scope="row" valign="top"><label for="auteur_revue_image">Image Banner For PC</label></th>
		<td>
			<?php
			if ($category_image_banner != "") {

			?>
				<img style="width: 500px; height: 200px;" src="<?php echo $category_image_banner; ?>" alt="" title="" />
			<?php
			}

			?>
			<!-- Add this html here -->
			<input type="text" class="regular-text" id="category_image_banner" name="category_image_banner" value="<?php echo $category_image_banner; ?>">
			<button class="set_category_image_banner button">Set Image Banner PC</button>
		</td>
	</tr>
	<tr>
		<th scope="row" valign="top"><label for="auteur_revue_image">Image Banner For Smart Phone</label></th>
		<td>
			<?php
			if ($category_image_banner_sp != "") {

			?>
				<img style="width: 500px; height: 200px;" src="<?php echo $category_image_banner_sp; ?>" alt="" title="" />
			<?php
			}

			?>
			<!-- Add this html here -->
			<input type="text" class="regular-text" id="category_image_banner_sp" name="category_image_banner_sp" value="<?php echo $category_image_banner_sp; ?>">
			<button class="set_category_image_banner_sp button">Set Image Banner SP</button>
		</td>
	</tr>
	<tr>
		<th scope="row" valign="top"><label for="auteur_revue_image">Image Icon</label></th>
		<td>
			<?php
			if ($category_image_icon != "") {

			?>
				<img style="display: block;" src="<?php echo $category_image_icon; ?>" alt="" title="" />
			<?php
			}

			?>
			<!-- Add this html here -->
			<input type="text" class="regular-text" id="category_image_icon" name="category_image_icon" value="<?php echo $category_image_icon; ?>">
			<button class="set_category_image_icon button">Set Image Icon</button>

		</td>
	</tr>

<?php
}

function save_image($term_id)
{
	if (isset($_POST['category_image_banner'])) {
		//load existing category featured option
		$category_images_banner = get_option('category_images_banner');
		//set featured post ID to proper category ID in options array
		$category_images_banner[$term_id] =  $_POST['category_image_banner'];
		//save the option array
		update_option('category_images_banner', $category_images_banner);
	}
	if (isset($_POST['category_image_banner_sp'])) {
		//load existing category featured option
		$category_images_banner_sp = get_option('category_images_banner_sp');
		//set featured post ID to proper category ID in options array
		$category_images_banner_sp[$term_id] =  $_POST['category_image_banner_sp'];
		//save the option array
		update_option('category_images_banner_sp', $category_images_banner_sp);
	}
	if (isset($_POST['category_image_icon'])) {
		//load existing category featured option
		$category_images_icon = get_option('category_images_icon');
		//set featured post ID to proper category ID in options array
		$category_images_icon[$term_id] =  $_POST['category_image_icon'];
		//save the option array
		update_option('category_images_icon', $category_images_icon);
	}
}

// Enquey media elements
add_action('admin_enqueue_scripts', function () {
	if (is_admin())
		wp_enqueue_media();
});

// Add JS using admin_footer or enque thorugh hooks
add_action('admin_footer', 'my_footer_scripts');
function my_footer_scripts()
{

?>
	<script>
		jQuery(document).ready(function() {
			if (jQuery('.set_category_image_banner').length > 0) {
				if (typeof wp !== 'undefined' && wp.media && wp.media.editor) {
					jQuery('.set_category_image_banner').on('click', function(e) {
						e.preventDefault();
						var button = jQuery(this);
						var url_input = jQuery("#category_image_banner");
						wp.media.editor.send.attachment = function(props, attachment) {
							url_input.val(attachment.url);
						};
						wp.media.editor.open(button);
						return false;
					});
				}
			}
			if (jQuery('.set_category_image_banner_sp').length > 0) {
				if (typeof wp !== 'undefined' && wp.media && wp.media.editor) {
					jQuery('.set_category_image_banner_sp').on('click', function(e) {
						e.preventDefault();
						var button = jQuery(this);
						var url_input = jQuery("#category_image_banner_sp");
						wp.media.editor.send.attachment = function(props, attachment) {
							url_input.val(attachment.url);
						};
						wp.media.editor.open(button);
						return false;
					});
				}
			}
			if (jQuery('.set_category_image_icon').length > 0) {
				if (typeof wp !== 'undefined' && wp.media && wp.media.editor) {
					jQuery('.set_category_image_icon').on('click', function(e) {
						e.preventDefault();
						var button = jQuery(this);
						var url_input = jQuery("#category_image_icon");
						wp.media.editor.send.attachment = function(props, attachment) {
							url_input.val(attachment.url);
						};
						wp.media.editor.open(button);
						return false;
					});
				}
			}
			var productDiv = jQuery('.field-product_id');
			if (productDiv.length) {
				var productInput = productDiv.find('input');
				productInput.on('input', function() {
					var inputValue = jQuery(this).val();
					var regex = /^[a-zA-Z0-9-]*$/;
					if (!regex.test(inputValue)) {
						alert('英数字と「-」のみを入力してください。');
						jQuery(this).val(previousValue);
					} else {
						previousValue = inputValue;
					}
				});
			}
		});
	</script>
<?php
}

add_action('edited_lp_cate', 'lp_cate_extra_fields_save', 10, 2);
add_action('created_lp_cate', 'lp_cate_extra_fields_save', 10, 2);
function lp_cate_extra_fields_save($term_id)
{

	if (!isset($_POST['category_image_banner'])) return;
	update_term_meta($term_id, "category_image_banner", $_POST['category_image_banner']);

	if (!isset($_POST['category_image_banner_sp'])) return;
	update_term_meta($term_id, "category_image_banner_sp", $_POST['category_image_banner_sp']);

	if (!isset($_POST['category_image_icon'])) return;
	update_term_meta($term_id, "category_image_icon", $_POST['category_image_icon']);
}

function manage_my_category_columns($columns)
{
	// add 'My Column'
	$columns['my_column'] = 'Banner PC';
	$columns['my_column3'] = 'Banner SP';
	$columns['my_column2'] = 'Icon';

	return $columns;
}
add_filter('manage_edit-lp_cate_columns', 'manage_my_category_columns');

function manage_category_custom_fields($deprecated, $column_name, $term_id)
{
	$image_banner_url = get_term_meta($term_id, 'category_image_banner', true);
	$image_banner_sp_url = get_term_meta($term_id, 'category_image_banner_sp', true);
	$image_icon_url = get_term_meta($term_id, 'category_image_icon', true);
	if ($column_name == 'my_column') {
		echo '<img style="width: 120px; height: 60px;" src=' . " $image_banner_url" . ' />';
	}
	if ($column_name == 'my_column3') {
		echo '<img style="width: 120px; height: 60px;" src=' . " $image_banner_sp_url" . ' />';
	}
	if ($column_name == 'my_column2') {
		echo '<img style="width: 60px; height: 60px; display: block;" src=' . " $image_icon_url" . ' />';
	}
}
add_filter('manage_lp_cate_custom_column', 'manage_category_custom_fields', 10, 3);



//Fix category or date or archive panigation go page 2 error 404 not found

add_filter('get_the_archive_title', function ($title) {
	if (is_category()) {
		$title = single_cat_title('', false);
	} elseif (is_tag()) {
		$title = single_tag_title('', false);
	} elseif (is_month()) {
		$title = single_month_title('', false);
	} elseif (is_post_type_archive()) {
		$title = post_type_archive_title('', false);
	}
	return $title;
});

add_action('init', 'unregister_tags');

function unregister_tags()
{
	unregister_taxonomy_for_object_type('category', 'post');
	unregister_taxonomy_for_object_type('post_tag', 'post');
}

if (!function_exists('wpse_modify_category_query')) {
	function wpse_modify_category_query($query)
	{
		if (!is_admin() && $query->is_main_query()) {
			if ($query->is_archive()) {
				$query->set('posts_per_page', 1);
			}
		}
	}
}
add_action('pre_get_posts', 'wpse_modify_category_query');
