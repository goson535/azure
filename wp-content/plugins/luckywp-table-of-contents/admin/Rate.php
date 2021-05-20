<?php

namespace luckywp\tableOfContents\admin;

use luckywp\tableOfContents\core\base\BaseObject;
use luckywp\tableOfContents\core\Core;

class Rate extends BaseObject
{

    const LINK = 'https://wordpress.org/support/plugin/luckywp-table-of-contents/reviews/?rate=5#new-post';

    private $_isShow;

    /**
     * @return bool
     */
    public function isShow()
    {
        if ($this->_isShow === null) {
            if (current_user_can('manage_options')) {
                $time = Core::$plugin->options->get('rate_time');
                if ($time === false) {
                    Core::$plugin->options->set('rate_time', time() + DAY_IN_SECONDS);
                    $this->_isShow = false;
                } else {
                    $this->_isShow = time() > $time;
                }
            } else {
                $this->_isShow = false;
            }
        }
        return $this->_isShow;
    }

    public function rate()
    {
        Core::$plugin->options->set('rate_time', time() + YEAR_IN_SECONDS * 5);
    }

    public function hide()
    {
        Core::$plugin->options->set('rate_time', time() + YEAR_IN_SECONDS * 5);
    }

    public function showLater()
    {
        Core::$plugin->options->set('rate_time', time() + WEEK_IN_SECONDS);
    }
}
