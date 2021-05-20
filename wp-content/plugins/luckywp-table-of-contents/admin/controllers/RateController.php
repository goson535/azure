<?php

namespace luckywp\tableOfContents\admin\controllers;

use luckywp\tableOfContents\core\admin\AdminController;
use luckywp\tableOfContents\core\Core;

class RateController extends AdminController
{

    public function init()
    {
        add_action('init', function () {
            if (Core::$plugin->rate->isShow()) {
                add_action('admin_notices', [$this, 'notice']);
            }
        });
        add_action('wp_ajax_lwptoc_rate', [$this, 'ajaxRate']);
        add_action('wp_ajax_lwptoc_rate_show_later', [$this, 'ajaxShowLater']);
        add_action('wp_ajax_lwptoc_rate_hide', [$this, 'ajaxHide']);
        parent::init();
    }

    public function notice()
    {
        $this->render('notice');
    }

    public function ajaxRate()
    {
        Core::$plugin->rate->rate();
    }

    public function ajaxHide()
    {
        Core::$plugin->rate->hide();
    }

    public function ajaxShowLater()
    {
        Core::$plugin->rate->showLater();
    }
}
