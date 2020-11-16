<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Member extends REST_Controller
{

    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->database();
    }

    //Menampilkan data kontak
    function index_get()
    {
        $id = $this->get('id_member');
        if ($id == '') {
            $kontak = $this->db->get('member')->result();
        } else {
            $this->db->where('id_member', $id);
            $kontak = $this->db->get('member')->result();
        }
        $this->response($kontak, 200);
    }

    //Masukan function selanjutnya disini
    // menampilkan relasi
    function relasi()
    {
        $id = $this->get('id');
        if ($id == '') {
            $kontak = $this->db->get('pemesanan')->result();
        } else {
            $this->db->select('*');
            $this->db->from('pemesanan');
            $this->db->join('member', 'member.id_member = pemesanan.id_member');
            // $query = $this->db->get();
            $this->db->where('id', $id);
            $kontak = $this->db->get()->result();
        }
        $this->response($kontak, 200);
    }
    //Mengirim atau menambah data pemesan baru
    function index_post()
    {
        $data = array(
            'nama'        => $this->post('nama'),
			'alamat'        => $this->post('alamat'),
			'telp'        => $this->post('telp')
        );
        $insert = $this->db->insert('member', $data);
        if ($insert) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    //Masukan function selanjutnya disini
    //Memperbarui data pemesan yang telah ada
    function index_put()
    {
        $id = $this->put('id');
        $data = array(
            'id_member'            => $this->put('id'),
            'nama'        => $this->post('nama'),
			'alamat'        => $this->post('alamat'),
			'telp'        => $this->post('telp')
        );
        $this->db->where('id_member', $id);
        $update = $this->db->update('member', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    //Masukan function selanjutnya disini
    //Menghapus salah satu data kontak
    function index_delete()
    {
        $id = $this->delete('id_member');
        $this->db->where('id_member', $id);
        $delete = $this->db->delete('member');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
}
