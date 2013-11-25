<?php
use Mailgun\Mailgun;

class Email
{
	public function send($from, $to, $subject, $text, $html = null)
	{
		$mgClient = new Mailgun(Yii::app()->params['MAILGUN_API_KEY']);
        $domain = "homelesspartners.com";

        $data = array(
            'from'    => $from,
            'to'      => $to,
            'subject' => $subject,
            'text'    => $text,
        );

        if(!empty($html))
        {
            $data['html'] = $html;
        }

        $result = $mgClient->sendMessage("$domain", $data);

        if($result->http_response_code == 200)
        {
        	return true;
        }
        else
        {
        	return false;
        }
	}
}