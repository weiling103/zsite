<?php
/**
 * The control file of site module of XiRangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     site
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
class site extends control
{
    /**
     * set site basic info.
     * 
     * @access public
     * @return void
     */
    public function setBasic()
    {
        if(!empty($_POST))
        {
            $result = $this->site->saveSetting((object)$_POST);
            if($result) $this->send(array('return' => 'success', 'message' => $this->lang->setSuccess));
            $this->send(array('result' => 'fail', 'message' => $this->lang->faild));
        }
        $this->display();
    }
    /**
     * set logo.
     * 
     * @access public
     * @return void
     */
    public function setLogo()
    {
        if(!empty($_FILES))
        {
            $fileModel =  $this->loadModel('file');

            /*delete old logo*/
            $oldLogos  = $fileModel->getByObject('logo');
            foreach($oldLogos as $file)
            {
                $fileModel->delete($file->id);
            }

            /*upload new log*/
            $logo     = $fileModel->saveUpload('logo');
            $fileID   = array_keys($logo);
            $file     = $fileModel->getById($fileID[0]); 
            $setting  = new stdclass();
            $setting->fileID    = $file->id;
            $setting->pathname  = $file->pathname;
            $setting->webPath   = $file->webPath;
            $setting->addedBy   = $file->addedBy;
            $setting->addedDate = $file->addedDate;


            $result = $this->loadModel('setting')->setItems('system.site.logo', $setting);
            if($result) $this->send(array('result' => 'success', 'message' => $this->lang->setSuccess, 'locate'=>inlink('setLogo')));
            $this->send(array('result'=>'fail', 'message'=>$this->lang->fail, inlink('setLogo')));
        }
        $this->display();
    }


    /**
     * Edit a site.
     * 
     * @param  string $siteID 
     * @access public
     * @return void
     */
    public function edit($siteID)
    {
        if(!empty($_POST))
        {
            $this->site->update($siteID);
            if(dao::isError()) die(js::error(dao::getError()));
            echo js::alert($this->lang->site->successSaved);
            die(js::locate($this->createLink('admin'), 'parent.parent'));
        }

        $this->view->site  = $this->site->getById($siteID);
        $this->view->sites = $this->site->getPairs();
        unset($this->view->sites[$siteID]);
        $this->display();
    }

    /**
     * Delete a site.
     * 
     * @param  string $siteID 
     * @param  string $confirm 
     * @access public
     * @return void
     */
    public function delete($siteID, $confirm = 'no')
    {
        if($confirm == 'no')
        {
            echo js::confirm($this->lang->site->confirmDelete, $this->createLink('site', 'delete', "siteID=$siteID&confirm=yes"));
            exit;
        }
        else
        {
            $this->site->delete($siteID);
            die(js::locate($this->createLink('admin', 'index'), 'top'));
        }
    }

}
