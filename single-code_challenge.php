<?php
/**
 * Template Name: Single Challenge
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
$user = wp_get_current_user();
get_header();

global $wpdb;
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <?php

        // Start the loop.
        while ( have_posts() ) : the_post();
        // Include the single post content template.
        get_template_part( 'template-parts/content', 'single' );
        // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() || get_comments_number() ) {
            comments_template();
        }

        $challenge_id = (int) get_the_ID();

        $results = $wpdb->get_results( "SELECT * FROM wp_jsc_challenge_user WHERE user_id = $user->ID AND challenge_id = $challenge_id");
        ?>
            <strong>Challenge ID:</strong><?php the_ID();?>
            <strong>User ID:</strong><?php echo $user->ID;?>
            <strong>Content:</strong><?php the_content();?>
            <?php
            if ( empty($results) ) { ?>
                <br>
                <div id="formArea">
                    <form id="theForm">
                        <input type="hidden" name="challenge_id" value="<?php echo $challenge_id; ?>">
                        <!-- this puts the action the_ajax_hook into the serialized form -->
                        <input name="action" type="hidden" value="the_ajax_hook" />&nbsp;
                        <input id="submit_button" value="Solve Challenge" type="button" onClick="submit_me(<?php echo $user->ID;?>, <?php echo $challenge_id;?>);" />
                    </form>
                </div>

            <?php
            } else {
            ?>
                <div id="formArea">
                    <br><span class="challengeIsSolved" id="solveChallenge">Challenge is Solved!</span>
                    <form style="display:inline-block;" id="theForm">
                        <input type="hidden" name="challenge_id" value="<?php echo $challenge_id; ?>">
                        <!-- this puts the action the_ajax_hook into the serialized form -->
                        <input name="action" type="hidden" value="reset_challenge" />&nbsp;
                        <input id="reset_button" value = "Reset Challenge?" type="button" onClick="resetChallenge(<?php echo $user->ID;?>, <?php echo $challenge_id;?>);" />
                    </form>
                </div>

        <?php
        }

        // End of the loop.
        endwhile;
        ?>

    </main><!-- .site-main -->

    <?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
