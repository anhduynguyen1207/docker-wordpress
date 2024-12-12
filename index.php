<!-- Code khong hien Uncategorized theo ID =1 -->
<?php if (have_posts()) {
    $paged = get_query_var('paged') ? get_query_var('paged') : 1;
    $args = array(
        'post_status' => 'publish',
        'posts_per_page' => 4,
        'paged' => $paged,
        'tax_query' => array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'category',
                'field'    => 'id',
                'terms'    => array(1), // ID of the "Uncategorized" category
                'operator' => 'NOT IN',
            ),
            array(
                'taxonomy' => 'category',
                'field'    => 'id',
                'terms'    => array(1), // Make sure it is not the only category
                'operator' => 'EXISTS',
            ),
        ),
    );
    $archivePost = new WP_Query($args);

    if ($archivePost->have_posts()) {
        while ($archivePost->have_posts()) {
            $archivePost->the_post();
?>
            <li class="isAnimFadeOutImg">
                <a href="<?php the_permalink() ?>" class="btn_link">
                    <p class="text_time f-medium"><?php the_time("Y.m.d") ?></p>
                    <p class="text_title is-relative f-medium"><?php the_title() ?></p>
                </a>
            </li><?php
                }
            }
        } else { ?>
    <div class="archiveNone">投稿がありません。</div>
<?php } ?>