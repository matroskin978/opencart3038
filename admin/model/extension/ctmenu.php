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

}
