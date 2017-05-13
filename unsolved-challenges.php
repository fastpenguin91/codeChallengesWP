<?php
    /**
    * Template Name: Unsolved Challenges
    */

    get_header(); ?>
    <div id="primary">
        <div id="content" role="main">
        <?php
        $num_of_posts = wp_count_posts('code_challenge');
        global $wpdb;


        $user = wp_get_current_user();

        $solved_id_array = $wpdb->get_results( "SELECT challenge_id FROM wp_jsc_challenge_user WHERE user_id = $user->ID");

        $solved_ids = array();

        foreach($solved_id_array as $elem) {
            array_push($solved_ids, $elem->challenge_id);
        }

        //die(var_dump($solved_ids));

        
        // This WILL work
        //$exclude_ids = array( 1, 2, 3 );
        //$query = new WP_Query( array( 'post__not_in' => $exclude_ids ) );

        //array('post__not_in' => $solved_ids)

        $myposts = array( 'post_type' => 'code_challenge', 'post__not_in' => $solved_ids );
        //$mypost = array( 'post_type' => 'code_challenge', );
        //$loop = new WP_Query( $mypost );
        $loop = new WP_Query( $myposts );
        ?>
        <h2>You've solved <?php echo $num_of_solved_challenges; ?> of <?php echo $num_of_posts->publish; ?> challenges</h2>
        <?php while ( $loop->have_posts() ) : $loop->the_post();?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
     
                    <!-- Display featured image in right-aligned floating div -->
                    <div style="float: right; margin: 10px">
                        <?php the_post_thumbnail( array( 100, 100 ) ); ?>
                    </div>
     
                    <!-- Display Title and Author Name -->
                    <div class="code_challenge_list_item">
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2><br />
                        <?php echo esc_html( get_post_meta( get_the_ID(), 'movie_director', true ) ); ?>
                        <br />
                        <?php the_content(); ?>
     
                        <!-- Display yellow stars based on rating -->
                        <strong>Difficulty Level: </strong>
                        <?php
                        $nb_stars = intval( get_post_meta( get_the_ID(), 'movie_rating', true ) );
                    
                        ?>
                    </div>
                </header>
     
                <!-- Display movie review contents -->
                <div class="entry-content"><?php the_content(); ?></div>
            </article>
     
        <?php endwhile; ?>
        </div>
    </div>
    <?php wp_reset_query(); ?>
    <?php get_footer(); ?>