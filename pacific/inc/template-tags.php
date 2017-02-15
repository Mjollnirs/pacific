<?php
/**
 * Template tags
 *
 * These functions are used directly within template files to produce
 * some form of output.
 *
 * @package Pacific
 */

# Prevent direct access to this file
if ( 1 == count( get_included_files() ) ) {
	header( 'HTTP/1.1 403 Forbidden' );
	return;
}

if ( ! function_exists( 'pacific_doctype' ) ) :
	/**
	 * Template tag to output doctype
	 */
	function pacific_doctype() {
		echo "<!DOCTYPE html>\n";
	}
endif;

if ( ! function_exists( 'pacific_entry_meta' ) ) :
	/**
	 * Template tag to output entry metadata
	 *
	 * @param bool $show_sep Whether to show a separator between meta items
	 * @param bool $author_postbox Whether an author box will be used on posts
	 */
	function pacific_entry_meta( $show_sep = true, $author_postbox = false ) {
		if ( true === $author_postbox ) {
			# translators: 1: Date linked to permalink, 2: Author linked to author archive
			printf( esc_html__( '%1$s by %2$s', 'pacific' ),
				'<span class="entry-date"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark"><time class="entry-date published" datetime="' . esc_attr( get_the_date( 'c' ) ) . '" itemprop="datepublished">' . esc_html( get_the_date() ) . '</time></a></span>',
				'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" rel="author" itemprop="url">' . esc_html( get_the_author() ) . '</a></span>'
			);
		} else {
			# translators: 1: Date linked to permalink, 2: Author linked to author archive
			printf( esc_html__( '%1$s by %2$s', 'pacific' ),
				'<span class="entry-date"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark"><time class="entry-date published" datetime="' . esc_attr( get_the_date( 'c' ) ) . '" itemprop="datepublished">' . esc_html( get_the_date() ) . '</time></a></span>',
				'<span class="author vcard" itemscope itemprop="author" itemtype="http://schema.org/Person"><a class="url fn n" itemprop="url" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" rel="author" itemprop="url"><span itemprop="name">' . esc_html( get_the_author() ) . '</span></a></span>'
			);
		}

		if ( true === $show_sep ) {
			echo '<span class="sep">&middot;</span>';
		}

		echo '<span class="comments-link">';
		comments_popup_link( esc_html__( '0 Comments', 'pacific' ), esc_html__( '1 Comment', 'pacific' ), esc_html__( '% Comments', 'pacific' ) );
		echo '</span>';
	}
endif;

if ( ! function_exists( 'the_archive_title' ) ) :
	/**
	 * Shim for `the_archive_title()`.
	 *
	 * Display the archive title based on the queried object.
	 *
	 * @todo Remove this function when WordPress 4.3 is released.
	 *
	 * @param string $before Optional. Content to prepend to the title. Default empty.
	 * @param string $after  Optional. Content to append to the title. Default empty.
	 */
	function the_archive_title( $before = '', $after = '' ) {
		if ( is_category() ) {
			$title = sprintf( __( 'Category: %s', 'pacific' ), single_cat_title( '', false ) );
		} elseif ( is_tag() ) {
			$title = sprintf( __( 'Tag: %s', 'pacific' ), single_tag_title( '', false ) );
		} elseif ( is_author() ) {
			$title = sprintf( __( 'Author: %s', 'pacific' ), '<span class="vcard">' . get_the_author() . '</span>' );
		} elseif ( is_year() ) {
			$title = sprintf( __( 'Year: %s', 'pacific' ), get_the_date( _x( 'Y', 'yearly archives date format', 'pacific' ) ) );
		} elseif ( is_month() ) {
			$title = sprintf( __( 'Month: %s', 'pacific' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'pacific' ) ) );
		} elseif ( is_day() ) {
			$title = sprintf( __( 'Day: %s', 'pacific' ), get_the_date( _x( 'F j, Y', 'daily archives date format', 'pacific' ) ) );
		} elseif ( is_tax( 'post_format' ) ) {
			if ( is_tax( 'post_format', 'post-format-aside' ) ) {
				$title = _x( 'Asides', 'post format archive title', 'pacific' );
			} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
				$title = _x( 'Galleries', 'post format archive title', 'pacific' );
			} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
				$title = _x( 'Images', 'post format archive title', 'pacific' );
			} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
				$title = _x( 'Videos', 'post format archive title', 'pacific' );
			} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
				$title = _x( 'Quotes', 'post format archive title', 'pacific' );
			} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
				$title = _x( 'Links', 'post format archive title', 'pacific' );
			} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
				$title = _x( 'Statuses', 'post format archive title', 'pacific' );
			} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
				$title = _x( 'Audio', 'post format archive title', 'pacific' );
			} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
				$title = _x( 'Chats', 'post format archive title', 'pacific' );
			}
		} elseif ( is_post_type_archive() ) {
			$title = sprintf( __( 'Archives: %s', 'pacific' ), post_type_archive_title( '', false ) );
		} elseif ( is_tax() ) {
			$tax = get_taxonomy( get_queried_object()->taxonomy );
			/* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
			$title = sprintf( __( '%1$s: %2$s', 'pacific' ), $tax->labels->singular_name, single_term_title( '', false ) );
		} else {
			$title = __( 'Archives', 'pacific' );
		}
		/**
		 * Filter the archive title.
		 *
		 * @param string $title Archive title to be displayed.
		 */
		$title = apply_filters( 'get_the_archive_title', $title );
		if ( ! empty( $title ) ) {
			echo wp_kses_post( $before . $title . $after );
		}
	}
endif;

if ( ! function_exists( 'the_archive_description' ) ) :
	/**
	 * Shim for `the_archive_description()`.
	 *
	 * Display category, tag, or term description.
	 *
	 * @todo Remove this function when WordPress 4.3 is released.
	 *
	 * @param string $before Optional. Content to prepend to the description. Default empty.
	 * @param string $after  Optional. Content to append to the description. Default empty.
	 */
	function the_archive_description( $before = '', $after = '' ) {
		$description = apply_filters( 'get_the_archive_description', term_description() );
		if ( ! empty( $description ) ) {
			/**
			 * Filter the archive description.
			 *
			 * @see term_description()
			 *
			 * @param string $description Archive description to be displayed.
			 */
			echo wp_kses_post( $before . $description . $after );
		}
	}
endif;

if ( ! function_exists( 'get_the_post_navigation' ) ) :
	/**
	 * Return navigation to next/previous post when applicable.
	 *
	 * @todo Remove this function when WordPress 4.3 is released.
	 *
	 * @param array $args {
	 *     Optional. Default post navigation arguments. Default empty array.
	 *
	 *     @type string $prev_text          Anchor text to display in the previous post link. Default `%title`.
	 *     @type string $next_text          Anchor text to display in the next post link. Default `%title`.
	 *     @type string $screen_reader_text Screen reader text for nav element. Default 'Post navigation'.
	 * }
	 * @return string Markup for post links.
	 */
	function get_the_post_navigation( $args = array() ) {
		$args = wp_parse_args( $args, array(
			'prev_text'          => '%title',
			'next_text'          => '%title',
			'screen_reader_text' => __( 'Post navigation', 'pacific' ),
		) );

		$navigation = '';
		$previous   = get_previous_post_link( '<div class="nav-previous">%link</div>', $args['prev_text'] );
		$next       = get_next_post_link( '<div class="nav-next">%link</div>', $args['next_text'] );

		// Only add markup if there's somewhere to navigate to.
		if ( $previous || $next ) {
			$navigation = _navigation_markup( $previous . $next, 'post-navigation', $args['screen_reader_text'] );
		}

		return $navigation;
	}
endif;

if ( ! function_exists( 'the_post_navigation' ) ) :
	/**
	 * Display navigation to next/previous post when applicable.
	 *
	 * @todo Remove this function when WordPress 4.3 is released.
	 *
	 * @param array $args Optional. See {@see get_the_post_navigation()} for available
	 *                    arguments. Default empty array.
	 */
	function the_post_navigation( $args = array() ) {
		echo balanceTags( get_the_post_navigation( $args ) );
	}
endif;

if ( ! function_exists( 'get_the_posts_pagination' ) ) :
	/**
	 * Return a paginated navigation to next/previous set of posts,
	 * when applicable.
	 *
	 * @todo Remove this function when WordPress 4.3 is released.
	 *
	 * @param array $args {
	 *     Optional. Default pagination arguments, {@see paginate_links()}.
	 *
	 *     @type string $screen_reader_text Screen reader text for navigation element.
	 *                                      Default 'Posts navigation'.
	 * }
	 * @return string Markup for pagination links.
	 */
	function get_the_posts_pagination( $args = array() ) {
		$navigation = '';

		// Don't print empty markup if there's only one page.
		if ( $GLOBALS['wp_query']->max_num_pages > 1 ) {
			$args = wp_parse_args( $args, array(
				'mid_size'           => 1,
				'prev_text'          => __( 'Previous', 'pacific' ),
				'next_text'          => __( 'Next', 'pacific' ),
				'screen_reader_text' => __( 'Posts navigation', 'pacific' ),
			) );

			// Make sure we get a string back. Plain is the next best thing.
			if ( isset( $args['type'] ) && 'array' == $args['type'] ) {
				$args['type'] = 'plain';
			}

			// Set up paginated links.
			$links = paginate_links( $args );

			if ( $links ) {
				$navigation = _navigation_markup( $links, 'pagination', $args['screen_reader_text'] );
			}
		}

		return $navigation;
	}
endif;

if ( ! function_exists( 'the_posts_pagination' ) ) :
	/**
	 * Display a paginated navigation to next/previous set of posts,
	 * when applicable.
	 *
	 * @todo Remove this function when WordPress 4.3 is released.
	 *
	 * @param array $args Optional. See {@see get_the_posts_pagination()} for available arguments.
	 *                    Default empty array.
	 */
	function the_posts_pagination( $args = array() ) {
		echo balanceTags( get_the_posts_pagination( $args ) );
	}
endif;

if ( ! function_exists( 'pacific_output_404_content' ) ) :
	/**
	 * The default content of a 404 page
	 */
	function pacific_output_404_content() {
		echo balanceTags( '<p>' . __( 'It looks like nothing was found at this location. Maybe try a search?', 'pacific' ) . "</p>\n" );

		get_search_form();
	}
endif;

if ( ! function_exists( 'pacific_footer_wordpress' ) ) :
	/**
	 * Display Footer
	 *
	 * @since 2.0.0
	 */
	function pacific_footer_wordpress() {
		echo '<div><span>Copyright &copy; 2016-' . date("Y") . ',&nbsp;<a href="https://www.mjollnir.cc">Mjollnir</a>. &nbsp;除非另有声明，本网站采用知识共享“<a rel="license" target="_blank" href="https://creativecommons.org/licenses/by-nc-sa/3.0/cn/">署名-非商业性使用-相同方式共享 3.0 中国大陆</a>”许可协议授权。</span><div>';
        echo '<div><span>Host by&nbsp;<a href="http://www.vultr.com/?ref=6870672" target="_blank">Vultr.com</a></span></div>';
	}
endif;

if ( ! function_exists( 'pacific_output_comment_author' ) ) :
	/**
	 * Output the comment author
	 *
	 * @since 2.0.0
	 */
	function pacific_output_comment_author( $comment, $args, $depth ) {
		if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'], null, sprintf( __( 'avatar of %s', 'pacific' ), esc_attr( get_comment_author() ) ), array( 'extra_attr' => 'itemprop="image" ' ) );

		printf( __( '<b class="fn" itemprop="name">%s</b>', 'pacific' ), get_comment_author_link( $comment ) );
	}
endif;

if ( ! function_exists( 'pacific_output_comment_metadata' ) ) :
	/**
	 * Output the comment metadata
	 *
	 * @since 2.0.0
	 */
	function pacific_output_comment_metadata( $comment, $args, $depth ) {
	?>
						<a itemprop="url" href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
							<time itemprop="dateCreated" datetime="<?php comment_time( 'c' ); ?>">
								<?php
									/* translators: 1: comment date, 2: comment time */
									printf( __( '%1$s at %2$s', 'pacific' ), get_comment_date( '', $comment ), get_comment_time() );
								?>
							</time>
						</a>
						<?php edit_comment_link( __( 'Edit', 'pacific' ), '<span class="edit-link">', '</span>' ); ?>
	<?php
	}
endif;

if ( ! function_exists( 'pacific_output_comment' ) ) :
	/**
	 * Output a comment.
	 *
	 * @access protected
	 * @since 2.0.0
	 *
	 * @param object $comment Comment to display.
	 * @param array  $args    An array of arguments.
	 * @param int    $depth   Depth of comment.
	 */
	function pacific_output_comment( $comment, $args, $depth ) {
		global $walker;

		$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
		$gravatars_enabled = get_option( 'show_avatars' );
		$extra_classes = '';

		empty( $args['has_children'] ) ? $extra_classes[] = 'parent' : false;
		get_option( 'show_avatars' ) ? false : $extra_classes[] = 'no-avatar';
?>
		<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $extra_classes, $comment ); ?>>
			<article id="div-comment-<?php comment_ID(); ?>" class="comment-body" itemscope itemtype="https://schema.org/Comment">
				<footer class="comment-meta">
					<?php if ( has_action( 'pacific_comment_author' ) ) : ?>
					<div class="comment-author vcard" itemprop="author" itemscope itemtype="https://schema.org/Person">
						<?php pacific_hook_comment_author( $comment, $args, $depth ); ?>
					</div>
					<?php endif; ?>
					<?php if ( has_action( 'pacific_comment_metadata' ) ) : ?>
					<div class="comment-metadata">
						<?php pacific_hook_comment_metadata( $comment, $args, $depth ); ?>
					</div>
					<?php endif; ?>
					<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php echo apply_filters( 'pacific_moderation_notice', __( 'Your comment is awaiting moderation.', 'pacific' ) ); ?></p>
					<?php endif; ?>
				</footer>
				<div class="comment-content" itemprop="text">
					<?php pacific_hook_comment_before(); ?>
					<?php comment_text(); ?>
					<?php pacific_hook_comment_after(); ?>
				</div>
				<?php
				comment_reply_link( array_merge( (array) $args, array(
					'add_below' => 'div-comment',
					'depth'     => $depth,
					'max_depth' => $args['max_depth'],
					'before'    => '<div class="reply">',
					'after'     => '</div>'
				) ) );
				?>
			</article>
<?php
	}
endif;