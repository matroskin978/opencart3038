<?php

class ModelExtensionCtmenu extends Model
{

    public function getTreeItems($menu_id)
    {
        $language_id = (int)$this->config->get('config_language_id');
        $query = $this->db->query("SELECT m.id, m.parent_id, md.title, md.link FROM ctmenu_link m
LEFT JOIN ctmenu_link_description md ON m.id = md.menu_link_id
WHERE m.menu_id = {$menu_id} and md.language_id = {$language_id}");
        $menu = [];
        foreach ($query->rows as $row) {
            $menu[$row['id']] = $row;
        }

        return $menu;
    }

    public function getMapTree($dataset)
    {
        $tree = [];

        foreach ($dataset as $id => &$node) {
            if (!$node['parent_id']) {
                $tree[$id] = &$node;
            } else {
                $dataset[$node['parent_id']]['children'][$id] = &$node;
            }
        }

        return $tree;
    }

    public function treeToHtml($tree, $tpl, $dropdown_classes=""){
        $str = '';
        foreach ($tree as $item) {
            $str .= $this->treeToTemplate($item, $tpl, $dropdown_classes);
        }
        return $str;
    }

    public function treeToTemplate($item, $tpl, $dropdown_classes=""){
        ob_start();
        require $tpl;
        return ob_get_clean();
    }

}
