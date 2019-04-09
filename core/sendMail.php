<?php

class MailSender {
    public function sendMail($mensaje ){
        //Titulo
        $titulo = "PRUEBA DE TITULO";
        //cabecera
        $headers = "MIME-Version: 1.0\r\n"; 
        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
        //dirección del remitente 
        $headers .= "From:Padel Optare < padeloptare@gmail.com >\r\n";
        //Enviamos el mensaje a tu_dirección_email 
        $bool = mail("dperro37@gmail.com",$titulo,$mensaje,$headers);
    
        if($bool){
            echo "Mensaje enviado";
        }else{
            echo "Mensaje no enviado";
        }
    }
}
?>