<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Form_validation $form_validation
 * @property CI_Loader $load
 * @property CI_Session $session
 * @property CI_DB_query_builder $db
 */
class User extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('email')) {
            redirect('auth');
        }
        if (!$this->session->userdata('role_id')) {
            redirect('auth');
        }
    }

   public function index()
    {
        $data['title'] = 'My Profile'; // atau judul lain sesuai kebutuhan
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }

    public function deleteSubMenu($id)
{
    $this->db->delete('user_sub_menu', ['id' => $id]);
    $this->session->set_flashdata('message', '<div class="alert alert-success">Submenu berhasil dihapus!</div>');
    redirect('menu/submenu');
}

public function updateSubMenu()
{
    $id = $this->input->post('id');

    $data = [
        'title'     => $this->input->post('title'),
        'menu_id'   => $this->input->post('menu_id'),
        'url'       => $this->input->post('url'),
        'icon'      => $this->input->post('icon'),
        'is_active' => $this->input->post('is_active') ? 1 : 0
    ];

    $this->db->where('id', $id);
    $this->db->update('user_sub_menu', $data);

    $this->session->set_flashdata('message', '<div class="alert alert-success">Submenu berhasil diupdate!</div>');
    redirect('menu/submenu');
}

public function edit()
{
    {
        $data['title'] = 'Edit Profile'; // atau judul lain sesuai kebutuhan
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');

        if($this->form_validation->run() == false) {
                    $this->load->view('templates/header', $data);
                    $this->load->view('templates/sidebar', $data);
                    $this->load->view('templates/topbar', $data);
                    $this->load->view('user/edit', $data);
                    $this->load->view('templates/footer');

        } else {
            $name = $this->input->post('name');
            $email = $this->input->post('email');

            $this->set('name', $name);
            $this->db->where('email', $email);
            $this->db->update('user')

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> You profile  has been updated! </div>');
            redirect('auth');

        }
    }
}

}