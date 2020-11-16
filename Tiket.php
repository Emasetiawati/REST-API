<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Tiket extends REST_Controller
{

    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->database();
    }

    //Menampilkan data kontak
    function index_get()
    {
        $id = $this->get('id');
        if ($id == '') {
            $kontak = $this->db->get('pemesanan')->result();
        } else {
            $this->db->where('id', $id);
            $kontak = $this->db->get('pemesanan')->result();
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
            'id_member'            => $this->post('id_member'),
            'tujuan'        => $this->post('tujuan')
        );
        $insert = $this->db->insert('pemesanan', $data);
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
            'id'            => $this->put('id'),
            'nama_pemesan'  => $this->put('nama_pemesan'),
            'tujuan'        => $this->put('tujuan')
        );
        $this->db->where('id', $id);
        $update = $this->db->update('pemesanan', $data);
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
        $id = $this->delete('id');
        $this->db->where('id', $id);
        $delete = $this->db->delete('pemesanan');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
}
