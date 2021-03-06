<?php

use trk\theme\Module;
use trk\uikit\helpers\ArrayHelper;

$header = Module::getConfig('header');

$links = Module::getConfig('social_links', [])->splice(0, 5)->filter();

$attrs['class'] = $header['social_style'] ? 'uk-icon-button' : 'uk-icon-link';
$attrs['target'] = $header['social_target'] ? '_blank' : '';

// Grid
$attrs_grid = [];
$attrs_grid['class'][] = 'uk-grid-small uk-flex-inline uk-flex-middle uk-flex-nowrap';
$attrs_grid['uk-grid'] = true;
?>
<?php if (count($links)) : ?>
    <ul<?= ArrayHelper::attrs($attrs_grid) ?>>
        <?php foreach ($links as $link) : ?>
        <li>
            <a<?= ArrayHelper::attrs(['href' => $link], $attrs) ?> uk-icon="<?= htmlspecialchars($link, ENT_COMPAT, 'UTF-8') ?>"></a>
        </li>
        <?php endforeach ?>
    </ul>
<?php endif ?>
