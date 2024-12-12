<?php
$term_name = single_term_title( '' , false );
$cat = get_term_by('name', $term_name, $taxonomy );
$term_slug = $cat->slug;
get_header(); ?>

<main class="works">
    <div class="works__cat">
        <ul class="works__catList">
            <li class="works__catItem">
                <a href="<?php echo esc_url( home_url('/works') ).$category->slug ?>">All</a>
            </li>
            <?php
                $categories = get_terms('works-cat', 'orderby=id&order=ASC&parent=0&hide_empty=1');
                foreach($categories as $category) :
            ?>
            <li class="works__catItem"><a href="<?php echo esc_url( home_url('/works-cat/') ).$category->slug ?>" class="<?php if(strpos($category->slug, $term_slug) !== false){ echo 'selected'; } ?>"><?php echo $category->name; ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
	<div class="works__body">
        <?php 
            $paged = get_query_var('paged') ? get_query_var('paged'): 1;
            $args = array(
                'posts_per_page' => 4,
                'paged' => $paged,
                'orderby' => 'post_date',
                'order' => 'DESC',
                'post_type' => 'works',
                'post_status' => 'publish',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'works-cat',
                        'field'    => 'slug',
                        'terms'    => $cat->slug
                    )
                ),
            );
            $the_query = new WP_Query($args); 
        ?>
        <?php if($the_query->have_posts()): ?>
        <ul class="works__body--list">
            <?php while($the_query->have_posts()): $the_query->the_post(); ?>
            <li class="works__body--listItem">
                <article>
                    <a href="<?php the_permalink(); ?>">
                        <div class="listItem--thumb object-fit-img">
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
                                <p class="head--txt--date">更新⽇：<?php the_time('Y.m.d'); ?></p>
                                <div class="head--txt--term term-parent">
                                    <?php 
                                    if ($terms = get_the_terms($post->ID, 'works-cat')):
                                    foreach ( $terms as $term ):
                                    ?>     
                                    <p class="term-child omission"><?php  echo esc_html($term->name); ?></p>
                                    <?php endforeach; endif; ?>
                                </div>
                            </div>
                            <h1 class="head--ttl omission"><?php the_title(); ?></h1>
                        </div>
                        <div class="article__contents--body">
                            <ul class="body--customList">
                                <!-- ↓1 -->
                                <?php 
                                $partner = get_field('works_partner');
                                if($partner):
                                ?>
                                <li><?php echo esc_html(wp_strip_all_tags($partner)); ?></li>
                                <?php endif; ?>
                                <!-- ↓2 -->
                                <?php 
                                $mainText = get_field('works_mainText');
                                if($mainText):
                                ?>
                                <li class="omission"><?php echo esc_html(wp_strip_all_tags($mainText)); ?></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </a>
                </article>
            </li>
            <?php endwhile; ?>
        </ul>
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
    </div>

</main>
<?php get_footer(); ?>