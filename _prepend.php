<?php
/**
 * @brief Grayscale, a theme for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Themes
 *
 * @copyright Philippe aka amalgame
 * @copyright GPL-2.0-only
 */

namespace themes\grayscale;

if (!defined('DC_RC_PATH')) {
    return;
}
// public part below

if (!defined('DC_CONTEXT_ADMIN')) {
    return;
}
// admin part below

# Behaviors
$GLOBALS['core']->addBehavior('adminPageHTMLHead', [__NAMESPACE__ . '\tplGrayscaleThemeAdmin', 'adminPageHTMLHead']);
$GLOBALS['core']->addBehavior('adminPopupMedia', [__NAMESPACE__ . '\tplGrayscaleThemeAdmin', 'adminPopupMedia']);
$GLOBALS['core']->addBehavior('adminPageHTTPHeaderCSP', [__NAMESPACE__ . '\tplGrayscaleThemeAdmin','adminPageHTTPHeaderCSP']);

class tplGrayscaleThemeAdmin
{
    public static function adminPageHTMLHead()
    {
        $core = $GLOBALS['core'];

        if ($core->blog->settings->system->theme != 'grayscale') {
            return;
        }
        if (preg_match('#^http(s)?://#', $core->blog->settings->system->themes_url)) {
            $theme_url = \http::concatURL($core->blog->settings->system->themes_url, '/' . $core->blog->settings->system->theme);
        } else {
            $theme_url = \http::concatURL($core->blog->url, $core->blog->settings->system->themes_url . '/' . $core->blog->settings->system->theme);
        }

        echo '<script src="' . $theme_url . '/js/admin.js' . '"></script>' . "\n" .
        '<script src="https://use.fontawesome.com/releases/v5.15.3/js/all.js" crossorigin="anonymous"></script>' . "\n" .
       '<link rel="stylesheet" media="screen" href="' . $theme_url . '/css/admin.css' . '" />' . "\n";

        $core->auth->user_prefs->addWorkspace('accessibility');
        if (!$core->auth->user_prefs->accessibility->nodragdrop) {
            echo
            \dcPage::jsLoad('js/jquery/jquery-ui.custom.js') .
            \dcPage::jsLoad('js/jquery/jquery.ui.touch-punch.js');
        }
    }

    public static function adminPopupMedia($editor = '')
    {
        $core = $GLOBALS['core'];

        if (empty($editor) || $editor != 'admin.blog.theme') {
            return;
        }
        if (preg_match('#^http(s)?://#', $core->blog->settings->system->themes_url)) {
            $theme_url = \http::concatURL($core->blog->settings->system->themes_url, '/' . $core->blog->settings->system->theme);
        } else {
            $theme_url = \http::concatURL($core->blog->url, $core->blog->settings->system->themes_url . '/' . $core->blog->settings->system->theme);
        }

        return '<script src="' . $theme_url . '/js/popup_media.js' . '"></script>';
    }

    public static function adminPageHTTPHeaderCSP($csp)
    {
        global $core;
        if ($core->blog->settings->system->theme != 'grayscale') {
            return;
        }

        if (isset($csp['script-src'])) {
            $csp['script-src'] .= ' use.fontawesome.com';
        } else {
            $csp['script-src'] = 'use.fontawesome.com';
        }
    }
}
