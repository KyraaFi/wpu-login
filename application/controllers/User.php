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

            //cek jika gambar yang akan diu pload
            $upload_image = $_FILES['image']['name'];

            if ($upload_image) {
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size']      ='2048';
                $config['upload_path']  ='./assets/img/profile/';
                $this->load->library('upload', $config);

                if($this->upload->do_upload('image')) {

                    $old_image = $user['user']['image'];
                    if($old_image != 'default.jpg') {
                        unlink(FCPATH . 'assets/imag/profile/' . $old_image);
                    }

                    $new_image = $this->upload->display_errors('file_name');
                    $this->db->set('image', $new_image);

                } else {
                    echo $this->upload->display_errors();
                }
            }

            $this->db->set('name', $name);
            $this->db->where('email', $email);
            $this->db->update('user');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> You profile  has been updated! </div>');
            redirect('user');

        }
    }
}

public function changePassword()
{
    $data['title'] = 'Change Password';
    $data['user'] = $this->db->get_where('user', [
        'email' => $this->session->userdata('email')
    ])->row_array();

    // VALIDASI YANG BENAR
    $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
    $this->form_validation->set_rules('new_password1', 'New Password', 'required|trim|min_length[3]|matches[new_password2]');
    $this->form_validation->set_rules('new_password2', 'Repeat Password', 'required|trim|min_length[3]|matches[new_password1]');

    if ($this->form_validation->run() == false) {

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/changepassword', $data);
        $this->load->view('templates/footer');

    } else {

        $current_password = $this->input->post('current_password');
        $new_password = $this->input->post('new_password1');

        if (!password_verify($current_password, $data['user']['password'])) {

            $this->session->set_flashdata('message', 
                '<div class="alert alert-danger" role="alert">
                    Wrong current password!
                </div>'
            );
            redirect('user/changepassword');

        } else {

            if ($current_password == $new_password) {
                $this->session->set_flashdata('message', 
                    '<div class="alert alert-danger" role="alert">
                        New password cannot be same as current password!
                    </div>'
                );
                redirect('user/changepassword');
            } else {

                $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

                $this->db->set('password', $password_hash);
                $this->db->where('email', $this->session->userdata('email'));
                $this->db->update('user');

                $this->session->set_flashdata('message', 
                    '<div class="alert alert-success" role="alert">
                        Password changed!
                    </div>'
                );
                redirect('user/changepassword');
            }
        }
    }
}

}
