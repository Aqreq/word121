<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @package ImageStore Pro
 * @since 1.0.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">

    <?php if (have_comments()) : ?>
        <h2 class="comments-title">
            <?php
            $imagestore_comment_count = get_comments_number();
            if ('1' === $imagestore_comment_count) {
                printf(
                    esc_html__('One thought on &ldquo;%1$s&rdquo;', 'imagestore-pro'),
                    '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            } else {
                printf(
                    esc_html(_nx('%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $imagestore_comment_count, 'comments title', 'imagestore-pro')),
                    number_format_i18n($imagestore_comment_count),
                    '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            }
            ?>
        </h2>

        <?php the_comments_navigation(); ?>

        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'style'      => 'ol',
                'short_ping' => true,
                'callback'   => 'imagestore_comment_callback',
            ));
            ?>
        </ol>

        <?php the_comments_navigation(); ?>

        <?php if (!comments_open()) : ?>
            <p class="no-comments"><?php esc_html_e('Comments are closed.', 'imagestore-pro'); ?></p>
        <?php endif; ?>

    <?php endif; ?>

    <?php
    comment_form(array(
        'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
        'title_reply_after'  => '</h2>',
        'class_form'         => 'comment-form card',
        'class_submit'       => 'submit btn btn-primary',
    ));
    ?>

</div>

<?php
/**
 * Custom comment callback function
 */
function imagestore_comment_callback($comment, $args, $depth) {
    if ('pingback' == $comment->comment_type || 'trackback' == $comment->comment_type) : ?>
        
        <li id="comment-<?php comment_ID(); ?>" <?php comment_class('pingback'); ?>>
            <div class="comment-body">
                <?php esc_html_e('Pingback:', 'imagestore-pro'); ?> <?php comment_author_link(); ?> <?php edit_comment_link(__('Edit', 'imagestore-pro'), '<span class="edit-link">', '</span>'); ?>
            </div>
        </li>
        
    <?php else : ?>
        
        <li id="comment-<?php comment_ID(); ?>" <?php comment_class(empty($args['has_children']) ? '' : 'parent'); ?>>
            <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
                
                <footer class="comment-meta">
                    <div class="comment-author vcard">
                        <?php if (0 != $args['avatar_size']) echo get_avatar($comment, $args['avatar_size']); ?>
                        <?php
                        printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>', 'imagestore-pro'), get_comment_author_link());
                        ?>
                    </div>

                    <div class="comment-metadata">
                        <a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
                            <time datetime="<?php comment_time('c'); ?>">
                                <?php printf(esc_html__('%1$s at %2$s', 'imagestore-pro'), get_comment_date(), get_comment_time()); ?>
                            </time>
                        </a>
                        <?php edit_comment_link(__('Edit', 'imagestore-pro'), '<span class="edit-link">', '</span>'); ?>
                    </div>

                    <?php if ('0' == $comment->comment_approved) : ?>
                        <p class="comment-awaiting-moderation"><?php esc_html_e('Your comment is awaiting moderation.', 'imagestore-pro'); ?></p>
                    <?php endif; ?>
                </footer>

                <div class="comment-content">
                    <?php comment_text(); ?>
                </div>

                <?php
                comment_reply_link(array_merge($args, array(
                    'add_below' => 'div-comment',
                    'depth'     => $depth,
                    'max_depth' => $args['max_depth'],
                    'before'    => '<div class="reply">',
                    'after'     => '</div>',
                )));
                ?>

            </article>
        </li>
        
    <?php
    endif;
}
?>