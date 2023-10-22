<?php

class ControllerExtensionCtmenu extends Controller
{

    public function index($data)
    {
        $lang_id = (int)$this->config->get('config_language_id');
        $menu_id = isset($data['id']) ? (int)$data['id'] : 0;
        if (isset($data['tpl'])) {
            $tpl = __DIR__ . "/ctmenu_tpl/{$data['tpl']}.php";
            if (!file_exists($tpl)) {
                $tpl = __DIR__ . "/ctmenu_tpl/base.php";
            }
        } else {
            $tpl = __DIR__ . "/ctmenu_tpl/base.php";
        }
        $this->load->model("extension/ctmenu");
        $tpl_md5 = md5($tpl);
        $data_ctmenu = $this->cache->get("ctmenu_{$menu_id}_{$lang_id}_{$tpl_md5}");

        if (!$data_ctmenu) {
            $menu_data = $this->model_extension_ctmenu->getTreeItems($menu_id);
            if (!$menu_data) {
                return null;
            }
            $ctmenu_tree = $this->model_extension_ctmenu->getMapTree($menu_data);
            $data_ctmenu = $this->model_extension_ctmenu->treeToHtml($ctmenu_tree, $tpl);
            $this->cache->set("ctmenu_{$menu_id}_{$lang_id}_{$tpl_md5}", $data_ctmenu);
        }
        return $data_ctmenu;
    }

    private function dump($data)
    {
        echo "<pre>" . print_r($data, 1) . "</pre>";
    }

}
