<?php

namespace c\core;

class Mailer {


    /**
     * @param $to
     * @param $from
     * @param $subject
     * @param $message
     * @throws \Exception
     * @throws \phpmailerException
     * Метод обвертка для отправки email.
     */
    public function sendMail($to, $from, $subject, $message ) {
        $phpMailer = new \PHPMailer();
        $phpMailer->isMail();
        $phpMailer->setLanguage( 'ru' );
        $phpMailer->CharSet = 'UTF-8';
        $phpMailer->setFrom( $from, 'Task Manager' );
        if ( is_array( $to ) ) {
            foreach ( $to as $mail ) {
                $phpMailer->addAddress( $mail );
            }
        } else
            $phpMailer->addAddress( $to );
        $phpMailer->Subject = $subject;
        $phpMailer->Body = $message;

        $phpMailer->send();
    }
}