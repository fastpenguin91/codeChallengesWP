<?php
    /**
    * Template Name: Archive Challenge
    */

    get_header(); ?>
    <div id="primary">
        <div id="content" role="main">
        <?php
        $mypost = array( 'post_type' => 'code_challenge', );
        $loop = new WP_Query( $mypost );
        ?>
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
     
                        <!-- Display yellow stars based on rating -->
                        <strong>Difficulty Level: <?php echo die(var_dump( the_post() ) ); ?> </strong>
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