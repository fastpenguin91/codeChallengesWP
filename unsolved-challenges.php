<?php
/**
 * Template Name: Unsolved Challenges
 */

get_header();
?>

<div id="primary">
    <div id="content" role="main">
        <?php
        global $wpdb;

        $user = wp_get_current_user();
        $solved_id_array = $wpdb->get_results( "SELECT challenge_id FROM wp_jsc_challenge_user WHERE user_id = $user->ID");
        $solved_ids = array();
        foreach($solved_id_array as $elem) {
            array_push($solved_ids, $elem->challenge_id);
        }

        $myposts = array( 'post_type' => 'code_challenge', 'post__not_in' => $solved_ids );
        $loop = new WP_Query( $myposts );
        ?>
        
        <?php while ( $loop->have_posts() ) : $loop->the_post();?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <!-- Display Title and Author Name -->
                    <div class="code_challenge_list_item">
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2><br />
                        <br />
                    </div>
                </header>
            </article>
        <?php endwhile; ?>
    </div>
</div>
<?php wp_reset_query(); ?>
<?php get_footer(); ?>
