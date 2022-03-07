<?php

namespace App\Controllers;

use App\Helpers\URL_Exclude_Lists;

class SettingsController extends BaseController
{
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->ex      = new URL_Exclude_Lists();
    }

    public function set_settings()
    {
        $timeLimit = (int)$this->request->getPost('timeLimit');
        $this->session->set('timeLimit', $timeLimit >= 1 ? $timeLimit : 1);

        $toExclude = array();
        foreach($this->ex->excludeLists as $key => $list)
        {
            if($this->request->getPost($key) != null)
            {
                $toExclude = array_merge($toExclude,$list);
            }
        }
        $this->session->set('excludeList',$toExclude);
        return redirect()->to(base_url());
    }
}