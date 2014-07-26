<?php

/**
 * XForm
 * @author jan.kristinus[at]redaxo[dot]org Jan Kristinus
 * @author <a href="http://www.yakamara.de">www.yakamara.de</a>
 */

class rex_xform_action_email extends rex_xform_action_abstract
{

    function execute()
    {

        $mail_from = $this->getElement(2);
        $mail_to = $this->getElement(3);
        $mail_subject = $this->getElement(4);
        $mail_body = $this->getElement(5);

        foreach ($this->params['value_pool']['email'] as $search => $replace) {
            $mail_body = str_replace('###' . $search . '###', $replace, $mail_body);
            $mail_body = str_replace('+++' . $search . '+++', urlencode($replace), $mail_body);
        }

        $mail = new rex_mailer();
        $mail->AddAddress($mail_to, $mail_to);
        $mail->WordWrap = 80;
        $mail->FromName = $mail_from;
        $mail->From = $mail_from;
        $mail->Sender = $mail_from;
        $mail->Subject = $mail_subject;
        $mail->Body = nl2br($mail_body);
        $mail->AltBody = strip_tags($mail_body);
        // $mail->IsHTML(true);
        $mail->Send();
    }

    function getDescription()
    {
        return 'action|email|from@email.de|to@email.de|Mailsubject|Mailbody###name###';
    }

}
