<?php get_header();
$cat = get_category($cat);
$cat_name = $cat->name;
$cat_id = $cat->term_id;
?>

<div class="newsWrap">
    <div class="area-index">
        <main>
            <?php
                $paged = get_query_var('paged') ? get_query_var('paged'): 1;
                $args = array(
                    'cat' => $cat_id,
                    'posts_per_page' => 3,
                    'paged' => $paged,
                    'orderby' => 'post_date',
                    'order' => 'DESC',
                    'post_type' => 'post',
                    'post_status' => 'publish'
                );
                $the_query = new WP_Query($args);
                if ( $the_query->have_posts() ): while ( $the_query->have_posts() ): $the_query->the_post();
            ?>
            <article>
                <a href="<?php the_permalink(); ?>" class="article__contents">
                    <div class="article__contents--thumb object-fit-img">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <?php
                            $post_title = get_the_title();
                            the_post_thumbnail('post-thumbnail',array('alt' => $post_title.'の画像'));
                        ?>
                    <?php else: ?>
                        <img src="<?php echo get_template_directory_uri() ?>/img/common/thumb.jpg" alt="<?php the_title(); ?>の画像">
                    <?php endif; ?>
                    </div>
                    <div class="article__contents--head">
                        <div class="head--txt">
                            <p class="head--txt--date"><?php the_time('Y.m.d'); ?></p>
                            <div class="head--txt--cat cat-parent">
                                <?php 
                                $category = get_the_category(); 
                                if ($category): foreach($category as $cat):
                                ?>     
                                <p class="cat-child omission"><?php  echo $cat->cat_name ?></p>
                                <?php endforeach; endif; ?>
                            </div>
                        </div>
                        <h1 class="head--ttl omission"><?php the_title(); ?></h1>
                    </div>
                </a>    
            </article>

            <?php endwhile; ?>
            <div class="pagination">
            <?php
                $GLOBALS['wp_query']->max_num_pages = $the_query->max_num_pages;
                the_posts_pagination(array(
                    'mid_size' => 1,
                    'prev_text' => '<',
                    'next_text' => '>',
                ));
                wp_reset_postdata();
            ?>
            </div>
            <?php else: ?>
            <div class="post">
                <p class="post_title">現在準備中です。</p>
                <p>公開まで今しばらくお待ちください。</p>
            </div>
            <?php endif; wp_reset_query(); ?>
        </main>
        <aside>
            <div class="aside__contents aside__cat">
                <h2 class="aside__ttl">CATEGORY</h2>
                <ul class="aside__cat--list">
                    <li class="cat-item"><a href="<?php echo esc_url( home_url('/news') ); ?>">All</a></li>
                <?php wp_list_categories( 'title_li=' ); ?>
                </ul>
            </div>
            <div class="aside__contents aside__archives">
                <h2 class="aside__ttl">ARCHIVES</h2>
                <ul class="aside__archives--list">
                    <?php
                    $year_prev = null;
                    $months = $wpdb->get_results("SELECT DISTINCT MONTH( post_date ) AS month ,
                        YEAR( post_date ) AS year,
                        COUNT( id ) as post_count FROM $wpdb->posts
                        WHERE post_status = 'publish' and post_date <= now( )
                        and post_type = 'post'
                        GROUP BY month , year
                        ORDER BY post_date DESC");
                        $count = 1;
                        foreach ($months as $month) :
                            $year_current = $month->year;
                            if ($year_current != $year_prev) {
                                if ($year_prev != null) {
                                    echo '</ul></li>';
                                }
                                ?>
                                <li class="arc-item<?php if ($count == 1) echo ' active'; ?>">
                                    <h3 class="archive-year"><?php echo $month->year; ?>年</h3>
                                    <ul class="archive-month">
                            <?php }?>
                            <li>
                                <?php
                                // URLの構築
                                $year = $month->year;
                                $month_num = date("m", mktime(0, 0, 0, $month->month, 1, $year));
                                $month_name = date("n", mktime(0, 0, 0, $month->month, 1, $year)).'月';
                                $url = esc_url(home_url("/date/$year/$month_num"));
                                $count = $month->post_count;

                                // リンクの表示
                                echo "<a href='$url'>{$month_name}（{$count}）</a>";
                                ?>
                            </li>
                            <?php
                            $year_prev = $year_current;
                            $count++;
                        endforeach;
                        ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </aside>
    </div>
</div>

<?php get_footer(); ?>