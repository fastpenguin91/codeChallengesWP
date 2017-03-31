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
                    <strong>Challenge ID: <?php the_ID(); ?></strong><br/>
                    <a href="<?php the_permalink(); ?>"><strong>Title: </strong><?php the_title(); ?></a><br />
                    <?php echo esc_html( get_post_meta( get_the_ID(), 'movie_director', true ) ); ?>
                    <br />
                    <strong>The Permalink: <?php the_permalink(); ?></strong><br>
     
                    <!-- Display yellow stars based on rating -->
                    <strong>Difficulty Level: </strong>
                    <?php
                    $nb_stars = intval( get_post_meta( get_the_ID(), 'movie_rating', true ) );
                    
                    ?>
                </header>
     
                <!-- Display movie review contents -->
                <div class="entry-content"><?php the_content(); ?></div>
            </article>
     
        <?php endwhile; ?>
        </div>
    </div>
    <?php wp_reset_query(); ?>
    <?php get_footer(); ?>