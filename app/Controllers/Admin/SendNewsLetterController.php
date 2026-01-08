<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\SessionController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SubscribersModel;
use Config\Services;

class SendNewsLetterController extends SessionController
{
    public function index()
    {
        $data = [
            'title'       => 'Contrel | Newsletter',
            'currentpage' => 'sendnewsletter'
        ];

        return view('pages/admin/sendnewsletter', $data);
    }

    public function sendMessage()
    {
        $subscribersModel = new SubscribersModel();
        $subscribers      = $subscribersModel->findAll();

        $subject = $this->request->getPost('subject');
        $content = $this->request->getPost('content');

        $email       = Services::email();
        $successCount = 0;
        $failureCount = 0;

        // Email Template Builder
        $buildTemplate = function ($subscriberName, $subject, $content) {
            return '
            <div style="max-width:650px; margin:auto; border:1px solid #ddd; border-radius:8px; overflow:hidden;
                        font-family:\'Ruda\', Arial, Helvetica, sans-serif;">
                
                <!-- Add Google Font (only works in Apple Mail, iOS Mail, some Android clients) -->
                <style>
                    @import url("https://fonts.googleapis.com/css2?family=Ruda:wght@400;700&display=swap");
                </style>

                <!-- Header -->
                <div style="background-color:#ff6600; color:#fff; padding:20px; text-align:center;
                            font-size:20px; font-weight:bold; font-family:\'Ruda\', Arial, Helvetica, sans-serif;">
                    ' . esc($subject) . '
                </div>

                <!-- Body -->
                <div style="padding:20px; background:#f9f9f9; color:#333; line-height:1.6;
                            font-family:\'Ruda\', Arial, Helvetica, sans-serif;">
                    <p style="font-size:16px; margin-bottom:15px;">Hello <strong>' . esc($subscriberName) . '</strong>,</p>
                    <p style="font-size:15px;">' . nl2br($content) . '</p>
                    
                    <p style="margin-top:20px; font-size:14px; color:#555;">
                        Thank you for being part of the <strong>Rift of Heroes</strong> community!
                    </p>
                </div>

                <!-- Footer -->
                <div style="background-color:#003366; color:#fff; text-align:center; padding:12px; font-size:14px;
                            font-family:\'Ruda\', Arial, Helvetica, sans-serif;">
                    &copy; ' . date('Y') . ' Rift of Heroes - Newsletter System
                </div>
            </div>';
        };

        // Send to all subscribers
        foreach ($subscribers as $subscriber) {
            $subscriberName = $subscriber['fullname'] ?? 'Client';

            $email->clear(true);
            $email->setTo($subscriber['emailaddress']);
            $email->setSubject($subject);
            $email->setMailType('html');
            $email->setMessage($buildTemplate($subscriberName, $subject, $content));

            if ($email->send()) {
                $successCount++;
            } else {
                $failureCount++;
            }
        }

        $response = ($successCount > 0)
            ? ['success' => true, 'message' => "Newsletter successfully emailed to {$successCount} recipients!"]
            : ['success' => false, 'message' => 'Failed to send newsletter email to all recipients.'];

        return $this->response->setJSON($response);
    }
}
