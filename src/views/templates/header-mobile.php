<?php

use trk\theme\Module;
use trk\uikit\helpers\HtmlHelper;
use trk\uikit\helpers\ArrayHelper;

$config = Module::getConfig('logo');
$mobile = Module::getConfig('mobile');
$attrs_image = [];

// Logo Text
$logo = $config['text'];

// Image Fallback
if ($config['image_mobile']) {
    $config['image'] = $config['image_mobile'];
    $config['image_width'] = $config['image_mobile_width'];
    $config['image_height'] = $config['image_mobile_height'];
}

// Image
if ($config['image']) {
    $attrs_image['class'] = 'uk-responsive-height';
    $attrs_image['alt'] = $config['text'];

    $ext = HtmlHelper::isImage($config['image']);

    if ($ext == 'gif') {
        $attrs_image['uk-gif'] = true;
    }

    if ($ext == 'svg') {
        $logo = HtmlHelper::image($config['image'], array_merge($attrs_image, ['width' => $config['image_mobile_width'], 'height' => $config['image_mobile_height']]));
    } else {
        $logo = HtmlHelper::image([$config['image'], 'thumbnail' => [$config['image_mobile_width'], $config['image_mobile_height']], 'srcset' => true], $attrs_image);
    }

}

if (!$logo) {
    unset($mobile['logo']);
}

if (!Module::sidebar('mobile')) {
    unset($mobile['toggle']);
}

$mobile['search'] = false; // TODO

?>

<nav class="uk-navbar-container" data-uk-navbar>

    <?php if ($mobile['logo'] == 'left' || $mobile['toggle'] == 'left' || $mobile['search'] == 'left') : ?>
    <div class="uk-navbar-left">

        <?php if ($mobile['logo'] == 'left') : ?>
        <a class="uk-navbar-item uk-logo<?= $mobile['logo_padding_remove'] ? ' uk-padding-remove-left' : '' ?>" href="<?= Module::getConfig('appUrl') ?>">
            <?= $logo ?>
        </a>
        <?php endif ?>

        <?php if ($mobile['toggle'] == 'left') : ?>
        <a class="uk-navbar-toggle" href="#avb-mobile" data-uk-toggle<?= ($mobile['animation'] == 'dropdown') ? '="animation: true"' : '' ?>>
            <div data-uk-navbar-toggle-icon></div>
            <?php if ($mobile['toggle_text']) : ?>
                <span class="uk-margin-small-left"><?= Module::t('Menu') ?></span>
            <?php endif ?>
        </a>
        <?php endif ?>

        <?php if ($mobile['search'] == 'left') : ?>
        <a class="uk-navbar-item"><?= Module::t('Search') ?></a>
        <?php endif ?>

    </div>
    <?php endif ?>

    <?php if ($mobile['logo'] == 'center') : ?>
    <div class="uk-navbar-center">
        <a class="uk-navbar-item uk-logo" href="<?= Module::getConfig('appUrl') ?>">
            <?= $logo ?>
        </a>
    </div>
    <?php endif ?>

    <?php if ($mobile['logo'] == 'right' || $mobile['toggle'] == 'right' || $mobile['search'] == 'right') : ?>
    <div class="uk-navbar-right">

        <?php if ($mobile['search'] == 'right') : ?>
        <a class="uk-navbar-item"><?= Module::t('Search') ?></a>
        <?php endif ?>

        <?php if ($mobile['toggle'] == 'right') : ?>
        <a class="uk-navbar-toggle" href="#avb-mobile" data-uk-toggle<?= $mobile['animation'] == 'dropdown' ? '="animation: true"' : '' ?>>
            <?php if ($mobile['toggle_text']) : ?>
                <span class="uk-margin-small-right"><?= Module::t('Menu') ?></span>
            <?php endif ?>
            <div data-uk-navbar-toggle-icon></div>
        </a>
        <?php endif ?>

        <?php if ($mobile['logo'] == 'right') : ?>
        <a class="uk-navbar-item uk-logo<?= $mobile['logo_padding_remove'] ? ' uk-padding-remove-right' : '' ?>" href="<?= Module::getConfig('appUrl') ?>">
            <?= $logo ?>
        </a>
        <?php endif ?>

    </div>
    <?php endif ?>

</nav>

<?php if (Module::sidebar('mobile')) :

    $attrs_menu = [];
    $attrs_menu['class'][] = $mobile['animation'] == 'offcanvas' ? 'uk-offcanvas-bar' : '';
    $attrs_menu['class'][] = $mobile['animation'] == 'modal' ? 'uk-modal-dialog uk-modal-body' : '';
    $attrs_menu['class'][] = $mobile['animation'] == 'dropdown' ? 'uk-background-default uk-padding' : '';
    $attrs_menu['class'][] = $mobile['menu_center'] ? 'uk-text-center' : '';
    $attrs_menu['class'][] = $mobile['animation'] != 'dropdown' && $mobile['menu_center_vertical'] ? 'uk-flex' : '';

    $mobile['offcanvas_overlay'] = true;

    ?>

    <?php if ($mobile['animation'] == 'offcanvas') : ?>
    <?php
    $mobile['offcanvas'][] = $mobile['offcanvas_mode'];
    ?>
    <div id="avb-mobile" data-uk-offcanvas<?= ArrayHelper::attrs($mobile['offcanvas'] ?: []) ?>>
        <div<?= ArrayHelper::attrs($attrs_menu) ?>>

            <button class="uk-offcanvas-close" type="button" data-uk-close></button>

            <?php if ($mobile['menu_center_vertical']) : ?>
            <div class="uk-margin-auto-vertical uk-width-1-1">
                <?php endif ?>

                <?php echo Module::sidebar("mobile:grid-stack") ?>

                <?php if ($mobile['menu_center_vertical']) : ?>
            </div>
        <?php endif ?>

        </div>
    </div>
<?php endif ?>
    <?php if ($mobile['animation'] == 'modal') : ?>
        <div id="avb-mobile" class="uk-modal-full" data-uk-modal>
            <div<?= ArrayHelper::attrs($attrs_menu) ?> data-uk-height-viewport>
                <button class="uk-modal-close-full" type="button" data-uk-close></button>
                <?php if ($mobile['menu_center_vertical']) : ?>
                    <div class="uk-margin-auto-vertical uk-width-1-1">
                <?php endif ?>
                    <?php echo Module::sidebar("mobile:grid-stack") ?>
                <?php if ($mobile['menu_center_vertical']) : ?>
                    </div>
                <?php endif ?>
            </div>
        </div>
    <?php endif ?>
    <?php if ($mobile['animation'] == 'dropdown') : ?>
        <div class="uk-position-relative uk-position-z-index">
            <div id="avb-mobile" class="<?= $mobile['dropdown'] == 'slide' ? 'uk-position-top' : '' ?>" hidden>
                <div<?= ArrayHelper::attrs($attrs_menu) ?>>
                    <?php echo Module::sidebar("mobile:grid-stack") ?>
                </div>
            </div>
        </div>
    <?php endif ?>
<?php endif ?>
