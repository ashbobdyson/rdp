<div class="spash-screen real" style="background-image:url(<?= wp_get_attachment_image_src(get_field('splash_screen')['id'], 'xs')[0]?>)"></div>
<div class="spash-screen hidden-loader" style="width: 1px; height: 1px; position: fixed; top: -1px; left: -1px; border: none !important;"></div>
<?= create_srcset_bg(get_field('splash_screen')['id'], 'spash-screen') ?>
<div class="menu-block"></div>
<img style="width: 1px; height: 1px; position: absolute; opacity: 0;" <?= create_srcset(get_field('splash_screen')['id']) ?>/>