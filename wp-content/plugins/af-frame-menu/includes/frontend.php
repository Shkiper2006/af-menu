<?php
if (!defined('ABSPATH')) {
    exit;
}

function af_frame_menu_enqueue_assets() {
    wp_enqueue_style(
        'af-frame-menu',
        AF_FRAME_MENU_URL . 'assets/css/af-frame-menu.css',
        array(),
        AF_FRAME_MENU_VERSION
    );

    wp_enqueue_script(
        'af-frame-menu',
        AF_FRAME_MENU_URL . 'assets/js/af-frame-menu.js',
        array(),
        AF_FRAME_MENU_VERSION,
        true
    );
}

function af_frame_menu_shortcode() {
    af_frame_menu_enqueue_assets();

    $items = af_frame_menu_get_items();

    ob_start();
    ?>
    <div class="af-frame-menu" data-af-frame-menu>
        <div class="af-frame-menu__house" tabindex="0" aria-label="<?php echo esc_attr__('Меню', 'af-frame-menu'); ?>">
            <div class="af-frame-menu__roof" aria-hidden="true"></div>
            <div class="af-frame-menu__body">
                <div class="af-frame-menu__front">
                    <span class="af-frame-menu__title"><?php echo esc_html__('МЕНЮ', 'af-frame-menu'); ?></span>
                </div>
                <nav class="af-frame-menu__nav" aria-label="<?php echo esc_attr__('A-Frame Menu', 'af-frame-menu'); ?>">
                    <?php foreach ($items as $item) : ?>
                        <?php
                        $text = isset($item['text']) ? $item['text'] : '';
                        $url  = isset($item['url']) ? $item['url'] : '';
                        if ('' === $text || '' === $url) {
                            continue;
                        }
                        ?>
                        <a class="af-frame-menu__link" href="<?php echo esc_url($url); ?>"><?php echo esc_html($text); ?></a>
                    <?php endforeach; ?>
                </nav>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('af_frame_menu', 'af_frame_menu_shortcode');
