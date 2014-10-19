<?php /*
Template Name: Portfolio
*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="initial-scale=1.0">
<title><?php wp_title('Adam'); ?></title>

<link href='http://fonts.googleapis.com/css?family=Alegreya:400italic,700italic,400,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Shadows+Into+Light' rel='stylesheet' type='text/css'>

<link href="<?php echo get_stylesheet_uri(); ?>" rel="stylesheet" type="text/css" />

<script>
	if(window.location.hash) {
		var hash = window.location.hash;
		var hashtourl = hash.substring(2)
		window.location.href = "/"+hashtourl;
	}
</script>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<a class="shift" id="goshowcase">&rarr;</a> <!-- LINK TO A VIEW OF ALL MY WORK -->
<a class="shift" id="gopost">&larr;</a>	<!-- LINK TO A VIEW OF MY LATEST PROJECT -->

<header class="pageHead">
	<h1 class="mainTitle">Adam Portfolio</h1>

	<img src="<?php echo get_template_directory_uri(); ?>
/images/tetris.png" alt="Tetris" />
</header>

<ul id="content">

	<li id="post">

		<div class="content">
            <?php the_post(); $do_not_duplicate = get_the_ID(); ?>
            <!-- Top navigation bar -->
            <div id="hello">
                <nav>
                    <?php wp_nav_menu( array( 'theme_location' => 'portfolio-menu' ) ); ?>
                </nav>
            </div>

            <h1><?php the_title(); ?></h1>
            <h3 class="subtitle">
				Take a look at some of my work
			</h3>
            
			<ul>
				<?php $args = array( 'post_type' => 'portfolio_item', 'posts_per_page' => 10 );
					$loop = new WP_Query( $args );
					while ( $loop->have_posts() ) : $loop->the_post();
				?>
				<li><h2><a rel="<?php the_permalink(); ?>" id="<?php the_id(); ?>" title="<?php echo( basename( get_permalink() ) ); ?>"><?php the_title(); ?></a></h2><div class="projPanel"><?php echo the_content(); ?></div> <span><?php the_time('F j Y') ?></span></li>
				  
				<?php endwhile; wp_reset_postdata(); 
			?>
			</ul>

		</div>

		<div id="footer">
			<?php if ( dynamic_sidebar('footer') ) : else : endif; ?>
			<!-- Top navigation bar -->
            <div id="hello2">
                <nav>
                    <?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?>
                </nav>
            </div>
		</div>

	</li>

	<li id="showcase">

		<div class="content">
            <h3 class="subtitle">
				Take a look at some of my work
			</h3>

			<ul>
				<?php $args = array( 'post_type' => 'portfolio_item', 'posts_per_page' => 9 );
					$loop = new WP_Query( $args );
					while ( $loop->have_posts() ) : $loop->the_post();
				?>
				<li>
					<a rel="<?php the_permalink(); ?>" id="<?php the_id(); ?>" title="<?php echo( basename( get_permalink() ) ); ?>">
						<?php the_post_thumbnail(); ?>
						<h1>
							<?php the_title(); ?>
						</h1>
					</a>
					<span><?php the_time('F j Y') ?></span>
				</li>				  
				<?php endwhile; wp_reset_postdata(); 
			?>
			</ul>

		</div>

	</li>

</ul>



<script>
	$(document).ready(function () {
		// Cached DOM references
		var $goshowcase = $('#goshowcase'),
			$gopost = $('#gopost'),
			$showcase = $('#showcase'),
			$post = $('#post');

		function goshowcase() {
			$goshowcase.fadeOut(300);
			$post.hide('slide', {
				direction: 'left'
			}, 600, function () {
				$showcase.scrollTop(0);
				$showcase.show('slide', {
					direction: 'right'
				}, 600);
				$gopost.fadeIn(300);
			});
		};

		function gopost() {
			$gopost.fadeOut(300);
			$showcase.hide('slide', {
				direction: 'right'
			}, 600, function () {
				$post.scrollTop(0);
				$post.show('slide', {
					direction: 'left'
				}, 600);
				$goshowcase.fadeIn(300);
			});
		};

		function loadpost() {

			var perma = $(this).attr('rel'),
				postid = $(this).attr('id'),
				postitle = $(this).attr('title');

			$(this).parent().parent().addClass('loader');

			$post.load(perma + ' #post', function () {
				$gopost.fadeOut(300);
				$showcase.hide('slide', {
					direction: 'right'
				}, 600, function () {
					$post.scrollTop(0);
					$goshowcase.fadeIn(300);
					$post.show('slide', {
						direction: 'left'
					}, 600, function () {
						$('#' + postid).parent().parent().removeClass('loader');
						window.location.hash = '/' + postitle;
						if (typeof twttr != 'undefined') {
							twttr.widgets.load()
						}
					});
				});
			});
		}

		$goshowcase.on('click',$goshowcase,goshowcase);

		$gopost.on('click',$gopost,gopost);

		$showcase.find('a').on('click',$showcase.find('a'),loadpost);


		/* arrow key navigation */

		$(document).keydown(function(ev) {
			if(ev.which === 39) {
				if ( $post.is(':visible') ) {
					goshowcase();
				}
				return false;
			}

			if(ev.which === 37) {
				if ( $showcase.is(':visible') ) {
					gopost();
				}
				return false;
			}
		});


	});

</script>

<?php wp_footer(); ?>



</body>
</html>