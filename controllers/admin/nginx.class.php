<?php
namespace O10n;

/**
 * Nginx Config Editor Admin Controller
 *
 * @package    optimization
 * @subpackage optimization/controllers/admin
 * @author     Optimization.Team <info@optimization.team>
 */
if (!defined('ABSPATH')) {
    exit;
}

class AdminNginx extends ModuleAdminController implements Module_Admin_Controller_Interface
{
    protected $admin_base = 'tools.php';

    // tab menu
    protected $tabs = array(
        'intro' => array(
            'title' => '<span class="dashicons dashicons-admin-home"></span>',
            'title_attr' => 'Intro'
        ),
        'editor' => array(
            'title' => 'Editor',
            'title_attr' => 'Nginx config Editor'
        )
    );
    /**
     * Load controller
     *
     * @param  Core       $Core Core controller instance.
     * @return Controller Controller instance.
     */
    public static function &load(Core $Core)
    {
        // instantiate controller
        return parent::construct($Core, array(
            'AdminView'
        ));
    }

    /**
     * Setup controller
     */
    protected function setup()
    {
        // settings link on plugin index
        add_filter('plugin_action_links_' . $this->core->modules('nginx')->basename(), array($this, 'settings_link'));

        // meta links on plugin index
        add_filter('plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 2);

        // title on plugin index
        add_action('pre_current_active_plugins', array( $this, 'plugin_title'), 10);

        // admin options page
        add_action('admin_menu', array($this, 'admin_menu'), 50);
    }
    
    /**
     * Admin menu option
     */
    public function admin_menu()
    {
        global $submenu;

        // WPO plugin or more than 1 optimization module, add to optimization menu
        if (defined('O10N_WPO_VERSION') || count($this->core->modules()) > 1) {
            add_submenu_page('o10n', __('Nginx config Editor', 'o10n'), __('Nginx config', 'o10n'), 'manage_options', 'o10n-nginx', array(
                 &$this->AdminView,
                 'display'
             ));

            // change base to admin.php
            $this->admin_base = 'admin.php';
        } else {

        // add menu entry
            add_submenu_page('tools.php', __('Nginx config Editor', 'o10n'), __('Nginx config Editor', 'o10n'), 'manage_options', 'o10n-nginx', array(
                 &$this->AdminView,
                 'display'
             ));
        }
    }

    /**
     * Settings link on plugin overview.
     *
     * @param  array $links Plugin settings links.
     * @return array Modified plugin settings links.
     */
    final public function settings_link($links)
    {
        $settings_link = '<a href="'.esc_url(add_query_arg(array('page' => 'o10n-nginx','tab' => 'editor'), admin_url($this->admin_base))).'">'.__('Editor').'</a>';
        array_unshift($links, $settings_link);

        return $links;
    }

    /**
     * Show row meta on the plugin screen.
     */
    final public function plugin_row_meta($links, $file)
    {
        if ($file == $this->core->modules('nginx')->basename()) {
            $lgcode = strtolower(get_locale());
            if (strpos($lgcode, '_') !== false) {
                $lgparts = explode('_', $lgcode);
                $lgcode = $lgparts[0];
            }
            if ($lgcode === 'en') {
                $lgcode = '';
            }

            $row_meta = array(
                /*'o10n_scores' => '<a href="' . esc_url('https://optimization.team/pro/') . '" target="_blank" title="' . esc_attr(__('View Google PageSpeed Scores Documentation', 'o10n')) . '" style="font-weight:bold;color:black;">' . __('Upgrade to <span class="g100" style="padding:0px 4px;">PRO</span>', 'o10n') . '</a>'*/
            );

            return array_merge($links, $row_meta);
        }

        return (array) $links;
    }

    /**
     * Plugin title modification
     */
    public function plugin_title()
    {
        ?><script>jQuery(function($){var r=$('*[data-plugin="<?php print $this->core->modules('nginx')->basename(); ?>"]');
            $('.plugin-title strong',r).html('<?php print $this->core->modules('nginx')->name(); ?><a href="https://optimization.team" class="g100" style="font-size: 10px;float: right;font-weight: normal;opacity: .2;line-height: 14px;">O10N</span>');
            var d=$('.plugin-description',r).html();$('.plugin-description',r).html(d.replace('Google PageSpeed','<a href="https://developers.google.com/speed/pagespeed/insights/" target="_blank">Google PageSpeed</a>').replace('Google Lighthouse','<a href="https://developers.google.com/web/tools/lighthouse/" target="_blank">Google Lighthouse</a>').replace('ThinkWithGoogle.com','<a href="https://testmysite.thinkwithgoogle.com/" target="_blank">ThinkWithGoogle.com</a>').replace('Excellent','<span style="font-style:italic;color:#079c2d;">Excellent</span>'));
});</script><?php
    }
}
