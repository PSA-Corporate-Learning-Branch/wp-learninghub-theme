<?php
/*
Template Name: Course List Table
*/

get_header(); ?>

<main id="main-content">
    <h1>Course List</h1>
    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>Course Name</th>
                <th>Audience</th>
                <th>Topics</th>
                <th>Delivery Method</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $args = array(
                'post_type'      => 'course',
                'posts_per_page' => -1,
                'orderby'        => 'title',
                'order'          => 'ASC'
            );

            $courses = new WP_Query($args);

            if ($courses->have_posts()) :
                while ($courses->have_posts()) : $courses->the_post();
            ?>
                    <tr>
                        <td><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></td>
                        <td><?php echo get_the_term_list(get_the_ID(), 'audience', '', ', ', ''); ?></td>
                        <td><?php echo get_the_term_list(get_the_ID(), 'topics', '', ', ', ''); ?></td>
                        <td><?php echo get_the_term_list(get_the_ID(), 'delivery-method', '', ', ', ''); ?></td>
                    </tr>
            <?php
                endwhile;
                wp_reset_postdata();
            else :
                echo '<tr><td colspan="4">No courses found.</td></tr>';
            endif;
            ?>
        </tbody>
    </table>
</main>

<?php get_footer(); ?>
