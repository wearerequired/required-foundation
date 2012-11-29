<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to required_comment() which is
 * located in the functions.php file.
 *
 * @package required+ Foundation
 * @since required+ Foundation 0.3.0
 */
?>	<!-- START: comments.php -->
	<div id="comments">
	<?php if ( post_password_required() ) : ?>
		<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'requiredfoundation' ); ?></p>
	</div><!-- #comments -->
	<?php
			/* Stop the rest of comments.php from being processed,
			 * but don't kill the script entirely -- we still have
			 * to fully load the template.
			 */
			return;
		endif;
	?>

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
		<h2 id="comments-title">
			<?php
				printf( _n( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'requiredfoundation' ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
		</h2>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-above">
			<h1 class="assistive-text"><?php _e( 'Comment navigation', 'requiredfoundation' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'requiredfoundation' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'requiredfoundation' ) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>

		<ol class="commentlist">
			<?php
				/* Loop through and list the comments. Tell wp_list_comments()
				 * to use required_comment() to format the comments.
				 * If you want to overload this in a child theme then you can
				 * define required_comment() and that will be used instead.
				 * See required_comment() in required/functions.php for more.
				 */
				wp_list_comments( array( 'callback' => 'required_comment' ) );
			?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below">
			<h1 class="assistive-text"><?php _e( 'Comment navigation', 'requiredfoundation' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'requiredfoundation' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'requiredfoundation' ) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>

	<?php
		/* If there are no comments and comments are closed, let's leave a little note, shall we?
		 * But we don't want the note on pages or post types that do not support comments.
		 */
		elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="nocomments"><?php _e( 'Comments are closed.', 'requiredfoundation' ); ?></p>
	<?php endif; ?>

	<?php if ( comments_open() ) : ?>
<section id="respond">
	<h3><?php comment_form_title( __('Leave a Reply', 'requiredfoundation' ), __('Leave a Reply to %s', 'requiredfoundation' ) ); ?></h3>
	<p class="cancel-comment-reply"><?php cancel_comment_reply_link(); ?></p>
	<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
	<p><?php printf( __('You must be <a href="%s">logged in</a> to post a comment.', 'requiredfoundation' ), wp_login_url( get_permalink() ) ); ?></p>
	<?php else : ?>
	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
		<?php if ( is_user_logged_in() ) : ?>
		<p><?php printf(__('Logged in as <a href="%s/wp-admin/profile.php">%s</a>.', 'requiredfoundation' ), get_option('siteurl'), $user_identity); ?> <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php __('Log out of this account', 'requiredfoundation' ); ?>"><?php _e('Log out &raquo;', 'requiredfoundation' ); ?></a></p>
		<?php else : ?>
		<p>
			<label for="author"><?php _e('Name', 'requiredfoundation' ); if ($req) _e(' (required)', 'requiredfoundation' ); ?></label>
			<input type="text" class="input-text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?>>
		</p>
		<p>
			<label for="email"><?php _e('Email (will not be published)', 'requiredfoundation' ); if ($req) _e(' (required)', 'requiredfoundation' ); ?></label>
			<input type="email" class="input-text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?>>
		</p>
		<p>
			<label for="url"><?php _e('Website', 'requiredfoundation' ); ?></label>
			<input type="url" class="input-text" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" tabindex="3">
		</p>
		<?php endif; ?>
		<p>
			<label for="comment"><?php _e('Comment', 'requiredfoundation' ); ?></label>
			<textarea name="comment" id="comment" tabindex="4"></textarea>
		</p>
		<p id="allowed_tags" class="small"><?php _e('You can use these tags: ', 'requiredfoundation' ); ?><code><?php echo allowed_tags(); ?></code></p>
		<p><input name="submit" class="<?php echo esc_attr( apply_filters( 'req_comment_button_classes', 'button' ) ); ?>" type="submit" id="submit" tabindex="5" value="<?php _e('Submit Comment', 'requiredfoundation' ); ?>"></p>
		<?php comment_id_fields(); ?>
		<?php do_action('comment_form', $post->ID); ?>
	</form>
	<?php endif; // If registration required and not logged in ?>
</section>
<?php endif; // if you delete this the sky will fall on your head ?>

</div><!-- #comments -->
<!-- END: comments.php -->
