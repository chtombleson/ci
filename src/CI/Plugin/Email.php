<?php
namespace CI\Plugin;

use CI\Plugin;
use Omnimessage\Omnimessage;

class Email extends Plugin
{
    public function execute()
    {
        $this->build->log->info('plugin: email started');

        $to = $this->settings['to'];

        $from = isset($this->settings['from']) ?
            $this->settings['from'] : 'ci@test.test';

        $reply_to = isset($this->settings['reply_to']) ?
            $this->settings['reply_to'] : null;

        $subject = isset($this->settings['subject']) ?
            $this->settings['subject'] : 'Build complete: ' . $this->build->name;

        $email = Omnimessage::create('Email');
        $email->setTransport('mail');

        $email->setTo($to)->setFrom($from)->setSubject($subject);

        if ($reply_to) {
            $email->setReplyTo($reply_to);
        }

        $lines = [
            'Project: ' . ucfirst($this->build->name),
            'Build complete see logs below:',
            '',
        ];

        $log = file($this->build->log_path);

        $body  = implode("\r\n", $lines) . "\r\n";
        $body .= implode("\r\n", $log) . "\r\n";

        $email->setBody($body)->send();

        $this->build->log->info('plugin: email finished');
    }
}
