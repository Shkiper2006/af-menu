<?php
if (!defined('ABSPATH')) {
    exit;
}

function af_frame_menu_add_admin_page() {
    add_options_page(
        'A-Frame Menu',
        'A-Frame Menu',
        'manage_options',
        'af-frame-menu',
        'af_frame_menu_render_admin_page'
    );
}
add_action('admin_menu', 'af_frame_menu_add_admin_page');

function af_frame_menu_render_admin_page() {
    if (!current_user_can('manage_options')) {
        return;
    }

    if (isset($_POST['af_frame_menu_save'])) {
        check_admin_referer('af_frame_menu_save_items', 'af_frame_menu_nonce');

        $items = isset($_POST['af_frame_menu_items']) ? af_frame_menu_sanitize_items($_POST['af_frame_menu_items']) : af_frame_menu_default_items();
        update_option('af_frame_menu_items', $items);

        add_settings_error(
            'af_frame_menu_messages',
            'af_frame_menu_saved',
            'Настройки меню сохранены.',
            'updated'
        );
    }

    $items = af_frame_menu_get_items();
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <?php settings_errors('af_frame_menu_messages'); ?>
        <form method="post" action="">
            <?php wp_nonce_field('af_frame_menu_save_items', 'af_frame_menu_nonce'); ?>
            <table class="widefat striped" id="af-frame-menu-items-table">
                <thead>
                    <tr>
                        <th><?php echo esc_html__('Текст пункта', 'af-frame-menu'); ?></th>
                        <th><?php echo esc_html__('URL', 'af-frame-menu'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $index => $item) : ?>
                        <tr>
                            <td>
                                <input class="regular-text" type="text" name="af_frame_menu_items[<?php echo esc_attr($index); ?>][text]" value="<?php echo esc_attr($item['text']); ?>">
                            </td>
                            <td>
                                <input class="regular-text" type="url" name="af_frame_menu_items[<?php echo esc_attr($index); ?>][url]" value="<?php echo esc_url($item['url']); ?>">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php for ($index = count($items); $index < count($items) + 2; $index++) : ?>
                        <tr>
                            <td>
                                <input class="regular-text" type="text" name="af_frame_menu_items[<?php echo esc_attr($index); ?>][text]" value="">
                            </td>
                            <td>
                                <input class="regular-text" type="url" name="af_frame_menu_items[<?php echo esc_attr($index); ?>][url]" value="">
                            </td>
                        </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
            <p class="description"><?php echo esc_html__('Заполните дополнительные пустые строки, чтобы добавить новые пункты.', 'af-frame-menu'); ?></p>
            <?php submit_button('Сохранить меню', 'primary', 'af_frame_menu_save'); ?>
        </form>
    </div>
    <?php
}
