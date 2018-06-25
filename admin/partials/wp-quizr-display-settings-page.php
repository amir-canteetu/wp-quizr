

<div class="wrap">

    <h2>WP Quizr Plugin Social Settings</h2>

    <p>Set the social networks in which you'd like users to share quiz results</p>

    <form method="post" action="options.php">

<?php settings_fields('wp_quizr_settings_group'); ?>

<?php $wp_quizr_options = get_option('wp_quizr_options'); ?>

        <table class="form-table">

            <tr valign="top">
                <th scope="row">Facebook App ID</th>
                    <td><input type="number" name="wp_quizr_options[option_fb_id]" value="<?php echo !empty($wp_quizr_options['option_fb_id']) ? esc_attr($wp_quizr_options['option_fb_id']) : ''; ?>" />
                    <p> Don't have a Facebook ID? Go to <a href="//developers.facebook.com/docs/apps/register/">Facebook</a>, where you can create a developer account and a Facebook App.</p>    
                </td>
               
            </tr>
            <tr valign="top">
                <th scope="row">Twitter Handle</th>
                <td><input type="text" name="wp_quizr_options[option_twtr_handle]" value="<?php echo !empty($wp_quizr_options['option_twtr_handle']) ? esc_attr($wp_quizr_options['option_twtr_handle']) : ''; ?>" />
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row">Quiz Table Width (%)</th>
                <td><input type="number" name="wp_quizr_options[option_table_width]" value="<?php echo !empty($wp_quizr_options['option_table_width']) ? esc_attr($wp_quizr_options['option_table_width']) : ''; ?>" placeholder="100" />
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row">Randomize Quiz Answer Choices?</th>
                <td><input type="checkbox" name="wp_quizr_options[random]" value="1"<?php echo ($wp_quizr_options['random'] == 1)? 'checked="checked"': ''; ?>/></td>
            </tr> 
            
            <tr valign="top">
                <th scope="row">Custom CSS Styles</th>
                <td><textarea rows="4" cols="50" name="wp_quizr_options[option_custom_css]"><?php echo !empty($wp_quizr_options['option_custom_css']) ? esc_attr($wp_quizr_options['option_custom_css']) : ''; ?> </textarea>
                <p>Write your custom css here. Use !important if needed; otherwise leave it empty.</p>
                </td>
            </tr>
        </table>

        <p class="submit">
            <input type="submit" class="button-primary" value="Save Changes" />
        </p>

    </form>
    
    <p>If you like WP Quizr, please leave a <a target="_blank" href="https://wordpress.org/plugins/wp-quizr/">rating</a>. A huge thank you in advance!</p>

</div>

              

