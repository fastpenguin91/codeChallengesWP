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

 <script  type='text/javascript'>

 jQuery(document).ready(function(){
    jQuery('#random').click(function() { alert('random clicked!'); //start function when Random button is clicked
        /*jQuery.ajax({
            type: "post",url: "admin-ajax.php",data: { action: 'solve_challenge', _ajax_nonce: '<?php echo $nonce; ?>' },
            beforeSend: function() {jQuery("#loading").fadeIn('fast');}, //fadeIn loading just when link is clicked
            success: function(html){ //so, if data is retrieved, store it in html
        *///    }
        }); //close jQuery.ajax
        return false;
    })
 })

 </script>



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
            //die(var_dump($results));


                ?><strong>Challenge ID:</strong><?php the_ID();
                ?><strong>User ID:</strong><?php  echo $user->ID;

                ?>
                <?php if ( empty($results) ) {
                    ?>
                    <br>


                    






                    <form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
                        <input type="hidden" name="action" value="solve_challenge">
                        <input type="hidden" name="user_id" value="<?php echo $user->ID;?>">
                        <input type="hidden" name="challenge_id" value="<?php echo $challenge_id; ?>">
                        <button style="display: inline-block; margin: 20px; padding: 20px; border-radius: 10px;" id="solveChallenge">Mark as Solved!</button>
                    </form>

                    <!--<br><span style="display: inline-block; margin: 20px; padding: 20px; background: lightgray; border-radius: 10px;" id="solveChallenge">Mark as Solved!</span>-->
                    <?php
                } else {
                    ?>

                    <form action="" method="POST" id="">
                        <!--<input type="hidden" name="action" value="solve_challenge">-->
                        <input type='submit' name='action' id='random' value='Random' />
                    </form>


                    <br><span style="display: inline-block; margin: 20px; padding: 20px; background: lightgreen; border-radius: 10px;" id="solveChallenge">Solved!</span>

                    <br><span style="display: inline-block; margin: 20px; padding: 20px; background: lightblue; border-radius: 10px;" id="solveChallenge">UnSolve?</span> <?php
                }

            // End of the loop.
        endwhile;
        ?>

    </main><!-- .site-main -->

    <?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>