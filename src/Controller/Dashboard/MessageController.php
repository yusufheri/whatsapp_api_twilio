<?php

namespace App\Controller\Dashboard;

use App\Entity\Favorite;
use App\Entity\Message;
use App\Form\FavoriteType;
use App\Repository\FavoriteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    /**
     * @Route("/dashboard/messages", name="dashboard_message")
     */
    public function index(FavoriteRepository $favoriteRepository): Response
    {
                return $this->render('dashboard/message/index.html.twig', [
                    'favorites' => $favoriteRepository->findBy(['deletedAt' => null],['createdAt' => 'DESC'])
        ]);
    }

    /**
     * @Route("/dashboard/messages/bulk", name="dashboard_message_bulk")
     */
    public function bulk(Request $request, EntityManagerInterface $manager): Response
    {
        $whatsapp = new Favorite();
        $form = $this->createForm(FavoriteType::class, $whatsapp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($whatsapp);
            

            $phones = [];
            $errorPhonesNumbers = 0;
            $counter = 0; $error = 0;
            $hasFile = empty($whatsapp->getImage())?true:false;

            foreach($whatsapp->getGroupes() as $k => $groupes) {
                foreach($groupes->getPeople() as $l => $person) {
                    $status = "";$number_phone = $person->getPhoneMain();
                    if(!empty($number_phone)){
                        if(is_numeric($number_phone)){
                                if(strlen($number_phone) >= 12){

                                    if ($hasFile) {
                                        $status = $this->send_whatsapp_sms("",$number_phone,$whatsapp->getContent());
                                    } else {
                                        $status = $this->send_whatsapp_sms_media("",$number_phone,$whatsapp->getContent(),$whatsapp->getImage());
                                    }
                                    
                                    $message = new Message();
                                    $message->setFavorite($whatsapp);
                                    $message->setPerson($person);

                                    $statusArray = json_decode($status, true);
                                    if(isset($statusArray["sid"]) && isset($statusArray["date_created"]) && isset($statusArray["date_updated"])){
                                        $counter ++;
                                        $message->setState(true);
                                        $message->setDateCreatedSms($statusArray["date_created"])
                                                ->setDateUpdatedSms($statusArray["date_updated"])
                                                ->setSid($statusArray["sid"]);
                                    } else {
                                        $error ++;
                                        $message->setState(false);
                                    }
                                    $manager->persist($message);

                                } else {
                                    $errorPhonesNumbers ++;
                                }                            
                        } else {
                            $errorPhonesNumbers ++;
                        }
                        
                    }

                }
            }

            $manager->flush();
             
            
            //dd($phones);
            dump($counter. " messages envoyés avec succès, ".$error." numéros de téléphone incorrects");
            //die();
            return $this->redirectToRoute("dashboard_message");
        }
        return $this->render('dashboard/message/bulk.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    function send_whatsapp_sms_media(String $from = "", String $to = "", String $message ="Bienvenue dans notre service de messagerie", String $media = ""){

        $ID = $_ENV["TWILIO_ACCOUNT_ID"];
        $token = $_ENV["TWILIO_AUTH_TOKEN"];
        $url = "https://api.twilio.com/2010-04-01/Accounts/".$ID."/Messages.json";

        if (strpos($to, "+") === false) { $to ="+".$to; }
        //$media = "http://enysms.herokuapp.com/uploads/medias/".$media;
        //$media = "http://www.adiac-congo.com/sites/default/files/dsc_0596_fileminimizer.jpg";
        $media = "https://apiwhatsapp2.herokuapp.com/uploads/medias/".$media;
        //$media = "https://resize-parismatch.lanmedia.fr/rcrop/250,250/img/var/news/storage/images/paris-match/people-a-z/denis-sassou-nguesso/22703684-2-fre-FR/Denis-Sassou-Nguesso.jpg";
        
        $data = array (
            'From' => 'whatsapp:+14155238886',
            'To' => 'whatsapp:'.$to,
            'Body' => $message,
            'MediaUrl' => $media,
        );
    
        $post = http_build_query($data);
        $x = curl_init($url );
        curl_setopt($x, CURLOPT_POST, true);
        curl_setopt($x, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($x, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($x, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($x, CURLOPT_USERPWD, "$ID:$token");
        curl_setopt($x, CURLOPT_POSTFIELDS, $post);
        $y = curl_exec($x);
        curl_close($x);
        return $y;
    }
    
    function send_whatsapp_sms(String $from = "", $to, String $message ="Bienvenue dans notre service de messagerie"){
    
        $ID = $_ENV["TWILIO_ACCOUNT_ID"];
        $token = $_ENV["TWILIO_AUTH_TOKEN"];
        $url = "https://api.twilio.com/2010-04-01/Accounts/".$ID."/Messages.json";
        //dump($url);
        if (strpos($to, "+") === false) { $to ="+".$to; }
        $data = array (
            'From' => 'whatsapp:+14155238886',
            'To' => 'whatsapp:'.$to,
            'Body' => $message,
        );
    
        $post = http_build_query($data);
        $x = curl_init($url );
        curl_setopt($x, CURLOPT_POST, true);
        curl_setopt($x, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($x, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($x, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($x, CURLOPT_USERPWD, "$ID:$token");
        curl_setopt($x, CURLOPT_POSTFIELDS, $post);
        $y = curl_exec($x);
        curl_close($x);
        return $y;
    }
}
