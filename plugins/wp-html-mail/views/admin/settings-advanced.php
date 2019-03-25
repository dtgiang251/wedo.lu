<div class="postbox">
    <h3 class="hndle"><span><?php _e('Advanced features','wp-html-mail'); ?></span></h3>
    <div style="" class="inside">
        <table class="form-table">
            <tbody>
                <?php /*
                <tr valign="top">
                    <th scope="row"><label><?php _e('Import / Export template','wp-html-mail') ?></label></th>
                    <td>
                        <div class="export-toggle">
                            <textarea><?php echo stripslashes(str_replace('\\&quot;','',json_encode($theme_options))); ?></textarea>
                            <p class="description">
                                <?php _e('Copy the settings above and paste into another site or paste other sites settings here.','wp-html-mail'); ?>
                            </p>
                        </div>
                    </td>
                </tr>
                */ ?>
                <tr valign="top">
                    <th scope="row"><label><?php _e('Delete plugin settings','wp-html-mail') ?></label></th>
                    <td>
                        <a href="<?php echo add_query_arg( 'advanced-action', 'delete-design' ); ?>" class="button-secondary" data-haet-confirm="<?php esc_attr_e('Are you sure? This can not be undone!', 'wp-html-mail') ?>"><?php _e('Delete design settings', 'wp-html-mail'); ?></a>
                        <a href="<?php echo add_query_arg( 'advanced-action', 'delete-all' ); ?>" class="button-secondary" data-haet-confirm="<?php esc_attr_e('Are you sure? This can not be undone!', 'wp-html-mail') ?>"><?php _e('Delete ALL settings', 'wp-html-mail'); ?></a>
                        <?php do_action( 'haet_mail_plugin_reset_buttons' ) ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>