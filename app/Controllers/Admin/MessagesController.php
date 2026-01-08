<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\MessagesModel;

class MessagesController extends SessionController
{
    public function index()
    {
        $data = [
            'title' => 'Contrel | User Masterlist',
            'currentpage' => 'messages'
        ];
        return view('pages/admin/messages', $data);
    }
    public function getData()
    {
        return datatables('messages')->make();
    }
    public function delete($id)
    {
        $MessagesModel = new MessagesModel();
    
        // Find the users by ID
        $messages = $MessagesModel->find($id);
    
        if ($messages) {
    
            // Delete the user record from the database
            $deleted = $MessagesModel->delete($id);
    
            if ($deleted) {
                return $this->response->setJSON(['status' => 'success']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to delete the message from the database']);
            }
        }
    
        return $this->response->setJSON(['status' => 'error', 'message' => 'Message not found']);
    }
}
