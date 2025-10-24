<?php

/**
 * Plugin Name: Contact Link Settings
 * Author: Nhien
 * Description: Add link social media
 */

if (!defined('ABSPATH')) exit;

add_action('admin_menu', 'contact_link_menu');
function contact_link_menu()
{
    add_menu_page(
        'Contact Link Settings',
        'Liên Hệ',
        'manage_options',
        'contact-link-settings',
        'contact_link_settings_page',
        'dashicons-admin-links',
        90
    );
}

function contact_link_settings_page()
{
    $links = get_option('contact_links', []); ?>
    <div class="wrap">
        <h1>Liên Hệ Qua</h1>
        <p>Chỉnh sửa đường dẫn liên hệ như là Messenger, Zalo, Facebook, Hotline…</p>
        <form method="post">
            <?php wp_nonce_field('save_contact_links', 'contact_nonce'); ?>

            <table id="form_links" class="form-table" style="max-width:900px;">
                <tr>
                    <th><span>Messenger</span></th>
                    <td><input type="text" name="contact_links[messenger]" value="<?php echo esc_attr($links['messenger'] ?? ''); ?>" class="regular-text" placeholder="https://m.me/username"></td>
                </tr>
                <tr>
                    <th><span>Hotline</span></th>
                    <td><input type="text" name="contact_links[hotline]" value="<?php echo esc_attr($links['hotline'] ?? ''); ?>" class="regular-text" placeholder="0123456789"></td>
                </tr>
                <tr>
                    <th><span>Tiktok</span></th>
                    <td><input type="text" name="contact_links[tiktok]" value="<?php echo esc_attr($links['tiktok'] ?? ''); ?>" class="regular-text" placeholder="https://www.tiktok.com/@username"></td>
                </tr>
                <tr>
                    <th><span>Liên hệ</span></th>
                    <td><input type="text" name="contact_links[contact]" value="<?php echo esc_attr($links['contact'] ?? ''); ?>" class="regular-text" placeholder="https://example.com/contact"></td>
                </tr>
                <tr>
                    <th><span>Zalo</span></th>
                    <td><input type="text" name="contact_links[zalo]" value="<?php echo esc_attr($links['zalo'] ?? ''); ?>" class="regular-text" placeholder="https://zalo.me/0123456789"></td>
                </tr>
                <tr>
                    <th><span>Facebook</span></th>
                    <td><input type="text" name="contact_links[facebook]" value="<?php echo esc_attr($links['facebook'] ?? ''); ?>" class="regular-text" placeholder="https://facebook.com/username"></td>
                </tr>
                <tr>
                    <th><span>Bản đồ</span></th>
                    <td><input type="text" name="contact_links[map]" value="<?php echo esc_attr($links['map'] ?? ''); ?>" class="regular-text" placeholder="https://google.com/maps/place/..."></td>
                </tr>
            </table>
            <?php submit_button('Lưu thay đổi'); ?>
        </form>
    </div>
<?php }

add_action('admin_init', function () {
    if (isset($_POST['contact_nonce']) && wp_verify_nonce($_POST['contact_nonce'], 'save_contact_links')) {
        if (!empty($_POST['contact_links']) && is_array($_POST['contact_links'])) {
            $clean = array_map('sanitize_text_field', $_POST['contact_links']);
            update_option('contact_links', $clean);
        }
    }
});

add_action('plus_section', 'Add link Social Media',);
