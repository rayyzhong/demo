<?php

/**
 * Created by PhpStorm.
 * User: hsbchsbc
 * Date: 2017/12/19
 * Time: 上午12:37
 */
class Event_service extends MY_Service
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('event_model');
    }

    private function can_delete($open_id, $event_id)
    {
        $result = $this->event_model->is_admin($open_id, $event_id);
        return $result;
    }

    public function delete($open_id, $id)
    {
        if ($this->can_delete($open_id, $id))
        {
            $this->event_model->delete($id);
        }
    }


}