<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Exception as Exception;
use \QCloud_WeApp_SDK\Auth\LoginService as LoginService;
use \QCloud_WeApp_SDK\Constants as Constants;

class Event extends REST_Controller {

    public function __construct()
    {

        parent::__construct();
        $this->load->service('event_service');
    }

    public function index_put() {

        $result = LoginService::check();

        // check failed
        if ($result['code'] !== 0) {
            return;
        }

        $open_id = $result['data']['userInfo']['openId'];
        $nickname = $result['data']['userInfo']['nickName'];



        $this->load->database();
        $this->db->trans_start();

        $this->load->model('event_model');
        $this->event_model->creator_open_id = $open_id;
        $this->event_model->code    = $this->put('code');
        $this->event_model->name    = $this->put('name');
        $this->event_model->venue    = $this->put('venue');
        $this->event_model->closure_type    = $this->put('closure_type');
        $this->event_model->start_time    = $this->put('start_time');
        $this->event_model->end_time    = $this->put('end_time');

        $this->event_model->insert_entry();
        $id = $this->db->insert_id();


        $this->load->model('eventuser_model');
        $this->eventuser_model->user_open_id = $open_id;
        $this->eventuser_model->event_id = $id;
        $this->eventuser_model->nickname = $nickname;
        $this->eventuser_model->insert_entry();

        $this->eventuser_model->role_id = 2;
        $this->eventuser_model->insert_entry();


        $this->db->trans_complete();

        $response = array(
            'code' => 0,
            'message' => 'ok',
            'data' => array(
                'id' => $id,
            ),
        );

        $this->response($response, REST_Controller::HTTP_OK);
    }


    public function index_get() {
        $result = LoginService::check();

        // check failed
        if ($result['code'] !== 0) {
            return;
        }


        $response = array(
            'code' => 0,
            'message' => 'ok',
            'data' => array(
                'userInfo' => $result['data']['userInfo'],
            ),
        );

        $this->response($response, REST_Controller::HTTP_OK);
    }

    public function managing_get() {
        $this->load->model('event_model');
        $response = $this->event_model->get_managing_events();

        $this->response($response, REST_Controller::HTTP_OK);
    }


    public function joining_get() {
        $this->load->model('event_model');
        $response = $this->event_model->get_joining_events();

        $this->response($response, REST_Controller::HTTP_OK);
    }

    public function index_delete()
    {
        $open_id = $this->get_open_id();
        $id = (int) $this->query('id');
        // Validate the id.
        if ($id <= 0)
        {
            // Set the response and exit
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $event = $this->event_model->get( $id );

        if($event)
        {
            $this->event_service->delete($open_id, $id);
        }
        else
        {
            $this->response(NULL, 404);
        }

        $message = array(
            'code' => 0,
            'message' => 'Event deleted',
            'data' => array(
                'id' => $id
            ),
        );
        $this->set_response($message, REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204) being the HTTP response code
    }


    /**
     * Get Open ID
     */
    public function get_open_id() {

        if ($this->config->item('env') === 'local')
        {
            return 'odun00FOoFBjr1RnrpCWRl9vX2tk';
        }
        else {
            $result = LoginService::check();

            // check failed
            if ($result['code'] !== 0) {
                return;
            }

            $open_id = $result['data']['userInfo']['openId'];
            return $open_id;
        }
    }
}
