<?php

/**
 * Created by PhpStorm.
 * User: hsbchsbc
 * Date: 2017/12/17
 * Time: 下午9:43
 */
class Users extends REST_Controller
{

    public function index_get()
    {
        $this->load->model('event_model');
        $events = $this->event_model->get_managed_entries();
        $this->response($events, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
    }

    public function index_post()
    {
        // Create a new book
    }

}