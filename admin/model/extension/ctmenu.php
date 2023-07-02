<?php

class ModelExtensionCtmenu extends Model
{

    public function install()
    {
        // menus table
        $this->db->query("
                CREATE TABLE IF NOT EXISTS `ctmenu` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	PRIMARY KEY (`id`) USING BTREE
) COLLATE='utf8mb4_unicode_ci'
ENGINE=InnoDB;
            ");

        // menu table
        $this->db->query("
                CREATE TABLE IF NOT EXISTS `ctmenu_link` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`menu_id` INT(10) UNSIGNED NOT NULL,
	`parent_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`) USING BTREE
) COLLATE='utf8mb4_unicode_ci'
ENGINE=InnoDB;
            ");

        // menu_description table
        $this->db->query("
                CREATE TABLE IF NOT EXISTS `ctmenu_link_description` (
  `menu_link_id` INT(10) UNSIGNED NOT NULL,
	`language_id` INT(10) UNSIGNED NOT NULL,
	`title` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`link` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	PRIMARY KEY (`menu_link_id`, `language_id`) USING BTREE
) COLLATE='utf8mb4_unicode_ci'
ENGINE=InnoDB;
            ");
    }

    public function getMenuList()
    {
        $query = $this->db->query("SELECT * FROM `ctmenu`");
        return $query->rows;
    }

    public function getMenu($menu_id)
    {
        $query = $this->db->query("SELECT * FROM ctmenu WHERE id = " . (int)$menu_id);
        return $query->row;
    }

    public function addMenu($data)
    {
        $this->db->query("INSERT INTO `ctmenu` SET `title` = '" . $this->db->escape($data['title']) . "' ");
        return $this->db->getLastId();
    }

    public function editMenu($menu_id, $data)
    {
        $this->db->query("UPDATE `ctmenu` SET title = '" . $this->db->escape($data['title']) . "' WHERE id = " . (int)$menu_id);
    }

    public function deleteMenu($menu_id)
    {
        $query = $this->db->query("SELECT COUNT(*) AS cnt FROM `ctmenu_link` WHERE menu_id = " . (int)$menu_id);
        if (!$query->row['cnt']) {
            $query = $this->db->query("DELETE FROM `ctmenu` WHERE id = " . (int)$menu_id);
            return true;
        }
        return false;
    }

    public function getTreeItems($menu_id)
    {
        $menu_id = (int)$menu_id;
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

}
