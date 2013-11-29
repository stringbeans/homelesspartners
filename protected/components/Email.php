<?php
use Mailgun\Mailgun;

class Email
{
	public function send($from, $to, $subject, $text)
	{
		$mgClient = new Mailgun(Yii::app()->params['MAILGUN_API_KEY']);
        $domain = "homelesspartners.com";

        $result = $mgClient->sendMessage("$domain",
            array('from'    => $from,
                'to'      => $to,
                'subject' => $subject,
                'text'    => $text,
                //'cc'      => 'baz@example.com',
                //'bcc'     => 'bar@example.com',
                //'html'    => '<html>HTML version of the body</html>'
            )
        );

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