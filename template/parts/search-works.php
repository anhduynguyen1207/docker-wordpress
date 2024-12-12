<?php
	get_header(); 
	global $wp_query;
 	$search_query = get_search_query();
	$cat = $_GET['cat'];//選択カテゴリーを取得
?>
<main>
<!-- サブページタイトルここから -->
	<section id="area-sub-header">
		<div class="box-ttl-bg-left"></div>
		<div class="box-ttl-bg-right"></div>
		<div class="box-sub-ttl">
			<h1>カテゴリ：<?php
					$length = count($cat);
					$no = 0;
					foreach($cat as $val) {
						echo get_the_category_by_ID($val);
						if(++$no !== $length){
							echo '、';
						}
					}
				?>
				<br>キーワード：<?php echo $search_query; ?><br>の施工事例検索結</h1>
			<p style="color: #D2C07E; font-weight: bold; letter-spacing: 0.1rem;">Works Search Results</p>
		</div>
	</section>
<!-- サブページタイトルここまで -->
	<section class="area-works-search">
		<?php
			//スペースでキーワードを区切る
			$search_query = explode(" ", $search_query);
			$args = array(
				'posts_per_page' => -1,
				'orderby' => 'post_date',
				'order' => 'DESC',
				'post_type' => 'works',
				'post_status' => 'publish',
			);
			if(!empty($cat)) {//カテゴリーが選択されていた場合
				$args = $args + array(
					'tax_query' => array(
					array(
						'taxonomy' => 'works-cat',
						'field'    => 'term_id',
						'terms'    => $cat,
					)
				),
				);
			}
			if(!$search_query[0] == '') {//キーワードが空でない場合
				if ( count($search_query) > 1 ) { //キーワードが１組より多い場合
					$custom = array(
						'meta_query' => array( 'relation' => 'OR' )//OR検索にする
					);
					foreach ( $search_query as $single_query ) {//キーワード分繰り返す
						$search_arr = array( 'key' => 'keyword', 'value' => $single_query, 'compare' => 'LIKE' );//keyにkeywordフィールド、valueにキーワード、compareはLIKE
						array_push($custom['meta_query'], $search_arr);//配列を入れていく
					}
					$args = array_merge($args, $custom);
				} else {//キーワードが１組の場合
					$custom = array( 'meta_key' => 'keyword', 'meta_value' => $search_query[0], 'meta_compare' => 'LIKE' );
					$args = array_merge($args, $custom);
				}
			}
			$the_query = new WP_Query($args);
			if( $the_query->have_posts() ):
		?>
			<ul class="list-most-works">
				<?php while( $the_query->have_posts() ): $the_query->the_post();?>
					<li>
						<a href="<?php the_permalink(); ?>">
							<div class="object-fit-img"><?php the_post_thumbnail(); ?></div>
							<p><?php the_title(); ?></p>
						</a>
					</li>
				<?php endwhile; ?>
			</ul>
		<?php else: ?>
			<div class="post" style="text-align: center;">
    	    	<p class="post_title">お探しの施工事例は見つかりませんでした。</p>
    	    	<p>キーワード・カテゴリーを変えて、再度検索をお願いいたします。</p>
    	    </div>
    	<?php endif; wp_reset_query(); ?>
	</section>
</main>
<?php get_footer(); ?>