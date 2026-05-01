<?php
/**
 * Default page template — generic content pages (privacy, terms, etc.).
 *
 * @package NYAS
 */

get_header();

while ( have_posts() ) : the_post();
	?>
	<section style="padding:72px 0 32px">
		<div class="container-narrow">
			<?php nyas_breadcrumb( array(
				array( 'Home', home_url( '/' ) ),
				array( get_the_title() ),
			) ); ?>
			<h1 class="display-xl"><?php the_title(); ?></h1>
		</div>
	</section>

	<section style="padding:32px 0 96px">
		<div class="container-narrow post-prose">
			<?php the_content(); ?>
			<?php wp_link_pages(); ?>
		</div>
	</section>

	<?php
	if ( comments_open() || get_comments_number() ) :
		?>
		<section style="padding:48px 0;background:var(--brand-paper);border-top:1px solid var(--border)">
			<div class="container-narrow">
				<?php comments_template(); ?>
			</div>
		</section>
		<?php
	endif;
endwhile;

get_footer();
