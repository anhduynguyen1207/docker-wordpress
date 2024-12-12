<?php get_header(); ?>

<div class="newsWrap">
    <div class="only-single">
        <main>
            <?php while( have_posts() ): the_post(); ?>
            <article>
                <div class="single__contents--head">
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
                    <h1 class="head--ttl"><?php the_title(); ?></h1>
                </div>
                <div class="single__contents--body"><?php the_content(); ?></div>     
            </article>
            <?php endwhile; ?>
            <a href="<?php echo esc_url( home_url('/news') ); ?>" class="link-news">お知らせ一覧へ</a>
            <div class="snsShere">
                <p class="snsShere__ttl">SNS share :</p>
                <ul class="snsShere__list">
                    <li>
                        <a href="https://twitter.com/share?url=<?php echo esc_url( home_url('/') ); ?>&text=“<?php bloginfo('name'); ?>" target="_blank" rel="noopener noreferrer">
                            <img src="<?php echo get_template_directory_uri(); ?>/img/news/btn-sns-tw.png" alt="Twitter 共有ボタン">
                        </a>
                    </li>
                    <li>
                        <a href="http://www.facebook.com/share.php?u=<?php echo esc_url( home_url('/') ); ?>" target="_blank" rel="noopener noreferrer">
                            <img src="<?php echo get_template_directory_uri(); ?>/img/news/btn-sns-fb.png" alt="Facebook 共有ボタン">
                        </a>
                    </li>
                </ul>
            </div>
            <?php
            $prevpost = get_adjacent_post(false, '', false);
            $nextpost = get_adjacent_post(false, '', true);
            if ($prevpost || $nextpost) :
            ?>
            <div class="single__pagination">
                <div class="single__pagination--prev">
                    <?php if ($prevpost) : ?>
                    <a href="<?php echo get_permalink($prevpost->ID); ?>">
                        <span class="single__pagination--prevTxt omission"><?php echo esc_attr($prevpost->post_title); ?></span>
                    </a>
                    <?php endif; ?>
                </div>     

                <div class="single__pagination--next">
                    <?php if ($nextpost) : ?>
                    <a href="<?php echo get_permalink($nextpost->ID); ?>">
                        <span class="single__pagination--nextTxt omission"><?php echo esc_attr($nextpost->post_title); ?></span>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
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