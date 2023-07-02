<?php

class ControllerExtensionCtmenu extends Controller
{

    private $error = [];

    /**
     * Show all menus
     */
    public function index()
    {
        $this->load->language('extension/ctmenu');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('extension/ctmenu');

        // install method
        $this->model_extension_ctmenu->install();

        // breadcrumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', "user_token={$this->session->data['user_token']}", true)
        );
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/ctmenu', "user_token={$this->session->data['user_token']}", true)
        );

        // button add
        $data['add'] = $this->url->link('extension/ctmenu/add-menu', "user_token={$this->session->data['user_token']}", true);

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        // flash messages
        if (isset($this->session->data['error'])) {
            $data['error_warning'] = $this->session->data['error'];
            unset($this->session->data['error']);
        } else {
            $data['error'] = '';
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        // menus list
        $menu_list = $this->model_extension_ctmenu->getMenuList();
        foreach ($menu_list as $menu_item) {
            $data['ctmenu'][] = [
                'id' => $menu_item['id'],
                'title' => $menu_item['title'],
                'edit' => $this->url->link('extension/ctmenu/edit-menu', "user_token={$this->session->data['user_token']}&menu_id={$menu_item['id']}", true),
                'delete' => $this->url->link('extension/ctmenu/delete-menu', "user_token={$this->session->data['user_token']}&menu_id={$menu_item['id']}", true),
                'view_menu_links' => $this->url->link('extension/ctmenu/view-menu-links', "user_token={$this->session->data['user_token']}&menu_id={$menu_item['id']}", true),
            ];
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        $this->response->setOutput($this->load->view('extension/ctmenu/index', $data));
    }

    /**
     * Add menu
     */
    public function addMenu()
    {
        $this->load->language('extension/ctmenu');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('extension/ctmenu');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateMenuForm()) {
            // save form
            $this->model_extension_ctmenu->addMenu($this->request->post['ctmenu']);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('extension/ctmenu', "user_token={$this->session->data['user_token']}", true));
        }

        $this->getMenuForm();
    }

    /**
     * Edit menu
     */
    public function editMenu()
    {
        $this->load->language('extension/ctmenu');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('extension/ctmenu');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateMenuForm()) {
            // save form
            $this->model_extension_ctmenu->editMenu($this->request->get['menu_id'], $this->request->post['ctmenu']);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('extension/ctmenu', "user_token={$this->session->data['user_token']}", true));
        }

        $this->getMenuForm();
    }

    /**
     * Menu form
     */
    protected function getMenuForm()
    {
        $data['text_form'] = !isset($this->request->get['menu_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['title'])) {
            $data['error_title'] = $this->error['title'];
        } else {
            $data['error_title'] = array();
        }

        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', "user_token={$this->session->data['user_token']}", true)
        );
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/ctmenu', "user_token={$this->session->data['user_token']}", true)
        );

        if (!isset($this->request->get['menu_id'])) {
            $data['action'] = $this->url->link('extension/ctmenu/add-menu', "user_token={$this->session->data['user_token']}", true);
        } else {
            $data['action'] = $this->url->link('extension/ctmenu/edit-menu', "user_token={$this->session->data['user_token']}&menu_id={$this->request->get['menu_id']}", true);
        }

        $data['cancel'] = $this->url->link('extension/ctmenu', "user_token={$this->session->data['user_token']}", true);

        $data['user_token'] = $this->session->data['user_token'];

        $this->load->model('localisation/language');

        $data['languages'] = $this->model_localisation_language->getLanguages();

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        if (isset($this->request->get['menu_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $data['ctmenu_data'] = $this->model_extension_ctmenu->getMenu($this->request->get['menu_id']);
        } elseif (isset($this->request->post['ctmenu'])) {
            $data['ctmenu_data'] = $this->request->post['ctmenu'];
        }

        $this->response->setOutput($this->load->view('extension/ctmenu/menu_form', $data));
    }

    /**
     * Delete menu
     */
    public function deleteMenu()
    {
        if (isset($this->request->get['menu_id']) && $this->validateDelete()) {
            $this->load->model('extension/ctmenu');
            $this->load->language('extension/ctmenu');
            if ($this->model_extension_ctmenu->deleteMenu($this->request->get['menu_id'])) {
                $this->session->data['success'] = $this->language->get('text_success');
            } else {
                $this->session->data['error'] = $this->language->get('error_delete_menu');
            }
            $this->response->redirect($this->url->link('extension/ctmenu', "user_token={$this->session->data['user_token']}", true));
        }

        $this->index();
    }

    /**
     * Show menu links
     */
    public function viewMenuLinks()
    {
        $this->load->language('extension/ctmenu');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('extension/ctmenu');

        // breadcrumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', "user_token={$this->session->data['user_token']}", true)
        );
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/ctmenu', "user_token={$this->session->data['user_token']}", true)
        );

        // button add
        $data['add'] = $this->url->link('extension/ctmenu/add-menu-link', "user_token={$this->session->data['user_token']}&menu_id={$this->request->get['menu_id']}", true);

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        // flash messages
        if (isset($this->session->data['error'])) {
            $data['error_warning'] = $this->session->data['error'];
            unset($this->session->data['error']);
        } else {
            $data['error'] = '';
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        // menus list
        $menu_data = $this->model_extension_ctmenu->getTreeItems($this->request->get['menu_id']);
        $menu_tree = $this->model_extension_ctmenu->getMapTree($menu_data);
        $data['ctmenu'] = $this->treeToHtml($menu_tree);

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        $this->response->setOutput($this->load->view('extension/ctmenu/menu_view_links', $data));
    }

    private function dump($data, $die = true)
    {
        echo "<pre>" . print_r($data, 1) . "</pre>";
        if ($die) {
            die;
        }
    }

    private function treeToHtml($tree, $tpl = 'list', $tab = '', $parent_id = 0){
        $str = '';
        foreach ($tree as $item) {
            $str .= $this->treeToTemplate($item, $tpl, $tab, $parent_id);
        }
        return $str;
    }

    private function treeToTemplate($item, $tpl, $tab, $parent_id){
        ob_start();

        if(!isset($item['children'])){
            $delete_link = $this->url->link('extension/ctmenu/delete-menu-link', "user_token={$this->session->data['user_token']}&menu_link_id={$item['id']}", true);
            $delete = '<a href="' . $delete_link . '" class="delete btn btn-danger"><i class="fa fa-trash-o"></i></a>';
        }
        $edit = $this->url->link('extension/ctmenu/edit-menu-link', "user_token={$this->session->data['user_token']}&menu_link_id={$item['id']}", true);
        ?>

        <?php if($tpl == 'list'): ?>
            <p class="item-p">
                <a class="list-group-item" href="<?= $edit; ?>"><?=$item['title'];?></a>
                <?php if(isset($delete)): ?>
                    <span><?=$delete;?></span>
                <?php endif; ?>
            </p>
            <?php if(isset($item['children'])): ?>
                <div class="list-group">
                    <?= $this->treeToHtml($item['children']); ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <?php if($tpl == 'select'): ?>
            <option
                value="<?= $item['id']; ?>"
                <?php if($item['id'] == $parent_id) echo ' selected'; ?>
                <?php if(isset($_GET['menu_link_id']) && $item['id'] == $_GET['menu_link_id']) echo ' disabled'; ?>>
                <?= $tab . $item['title']; ?>
            </option>
            <?php if(isset($item['children'])): ?>
                <?= $this->treeToHtml($item['children'], 'select', '&nbsp;' . $tab. '-', $parent_id); ?>
            <?php endif; ?>
        <?php endif ?>

        <?php
        return ob_get_clean();
    }

    protected function validateMenuForm()
    {
        if (!$this->user->hasPermission('modify', 'extension/ctmenu')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        $title = trim($this->request->post['ctmenu']['title']);
        if ((utf8_strlen($title) < 1) || (utf8_strlen($title) > 255)) {
            $this->error['title'] = $this->language->get('error_title');
        }

        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->language->get('error_warning');
        }

        return !$this->error;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', 'extension/ctmenu')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }

}

/*
 ctmenu - menus table
==================
id
title


CREATE TABLE IF NOT EXISTS `ctmenu` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	PRIMARY KEY (`id`) USING BTREE
)
COLLATE='utf8mb4_unicode_ci'
ENGINE=InnoDB
;


ctmenu_link - menu table
==================
id
menu_id
parent_id


CREATE TABLE IF NOT EXISTS `ctmenu_link` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`menu_id` INT(10) UNSIGNED NOT NULL,
	`parent_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`) USING BTREE
)
COLLATE='utf8mb4_unicode_ci'
ENGINE=InnoDB
;


ctmenu_link_description - menu_description table
==================
menu_link_id
language_id
title
link


CREATE TABLE IF NOT EXISTS `ctmenu_link_description` (
	`menu_link_id` INT(10) UNSIGNED NOT NULL,
	`language_id` INT(10) UNSIGNED NOT NULL,
	`title` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`link` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	PRIMARY KEY (`menu_link_id`, `language_id`) USING BTREE
)
COLLATE='utf8mb4_unicode_ci'
ENGINE=InnoDB
;



https://opencart-3x.ru/modification-system
 * */
