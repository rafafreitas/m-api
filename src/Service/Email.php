<?php
/**
 * Created by PhpStorm.
 * User: Rafael Freitas
 * Date: 19/02/2020
 * Time: 08:30
 */

namespace App\Service;
use App\Basics\Account;
use PHPMailer\PHPMailer\PHPMailer;

class Email
{
    private $charset = 'UTF-8';
    private $host = "smtp.hostinger.com.br";
    private $port = 587;
    private $fromName = "M_API";
    private $fromEmail = 'no-reply@servidordetestes.pe.hu';
    private $userName = 'no-reply@servidordetestes.pe.hu';
    private $password = '~]vBo4b;l0';
    private $subject;

    /**
     * SendEmail constructor.
     * @param $subject
     */
    public function __construct($subject)
    {
        $this->subject = $subject;
    }

    public function send($address, $body ){

        try {

            $mail = new PHPMailer(true);
            $mail->CharSet = $this->charset;
            $mail->IsSMTP();
            $mail->Host = $this->host;
//            $mail->SMTPSecure = 'ssl';
            $mail->SMTPAuth = true;
            $mail->Port = $this->port;
            $mail->Username = $this->userName;
            $mail->Password = $this->password;
            $mail->FromName = $this->fromName;
            $mail->From = $this->fromEmail;
            $mail->Subject  = $this->subject;

            if (is_array($address)) {
                foreach ($address as $add){
                    $mail->AddAddress($add, 'Contato');
                }
            }else{
                $mail->AddAddress($address, 'Contato');
            }

            $mail->MsgHTML($body);
            $mail->IsHTML(true);
            $mail->Send();

            if($mail){
                return array(
                    'status'    => 200,
                    'message'   => "SUCCESS",
                    'result'    => 'E-mails enviados com sucesso!',
                );
            }else{
                return array(
                    'status'    => 500,
                    'message'   => "ERROR",
                    'result'    => 'Erro na execução da instrução!',
                    'CODE'      => 'Code não informado',
                    'Exception' => 'Ex não informada'
                );
            }

        }catch (\Exception $ex){
            return array(
                'status'    => 500,
                'message'   => "ERROR",
                'result'    => 'Erro na execução da instrução!',
                'CODE'      => $ex->getCode(),
                'Exception' => $ex->getMessage()
            );
        }
    }

    public function newPass(Account $account, $pass){

        try {

            $body = file_get_contents(__DIR__ .'/../Utils/EmailsTemplates/ResetPass.html');
            $this->subject = "Nova senha gerada!";

            $body = str_replace('%NOVA_SENHA%', $pass, $body);
            return $this->send($account->getEmail(), $body);

        }catch (\Exception $ex) {
            return array(
                'status'    => 500,
                'message'   => "ERROR",
                'result'    => 'Erro na execução da instrução!',
                'CODE'      => $ex->getCode(),
                'Exception' => $ex->getMessage()
            );
        }
    }

}