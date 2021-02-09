<?php

namespace App\Controller\Dashboard;

use App\Entity\Person;
use App\Form\PersonType;
use App\Repository\PersonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MemberController extends AbstractController
{
    /**
     * @Route("/dashboard/members", name="dashboard_member")
     */
    public function index(PersonRepository $personRepository): Response
    {
        return $this->render('dashboard/member/index.html.twig', [
            'people' => $personRepository->findBy([],["name" => "ASC"]),
        ]);
    }

    /**
     * @Route("/dashboard/members/create", name="dashboard_member_create")
     */
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $person = new Person();
        $form = $this->createForm(PersonType::class, $person);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $person->setPhoneMain($this->format_number_success($person->getPhoneMain()));
           
            $status = $this->send_sms($person->getPhoneMain(),"PCT","Rejoignons notre cher Parti PCT via http://wa.me/+14155238886?text=join%20slightly-grow");
            //return $this->redirectToRoute('dashboard_member');
            $statusArray = json_decode($status, true);
            if(isset($statusArray["sid"]) && isset($statusArray["date_created"]) && 
            isset($statusArray["date_updated"])){
                $person->setSid($statusArray["sid"]);
                $person->setDateCreatedSms($statusArray["date_created"]);
                $person->setDateUpdatedSms($statusArray["date_updated"]);
            } else {
                dd("Veuillez vérifier le numéro de téléphone saisi");
            }
            $manager->persist($person);
            $manager->flush();
            return $this->redirectToRoute("dashboard_member_create");
            
        }
        return $this->render('dashboard/member/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    function send_sms($to, $from, $message){
        $ID = $_ENV["TWILIO_ACCOUNT_ID"];
        $token = $_ENV["TWILIO_AUTH_TOKEN"];
        $url = "https://api.twilio.com/2010-04-01/Accounts/".$ID."/Messages.json";
    
        $from = str_replace("_"," ",$from);
        $data = array (
            'From' => $from,
            'To' => $to,
            //'MessagingServiceSid' => 'MGde55b0c91c515d9a80917784c12a5032',
            'Body' => $message,
        );
       
        //--data-urlencode 'To=+243892751408' \
        //--data-urlencode 'From=+12565983933' \
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


    public function format_number_success($phone){
        $to = str_replace(" ","",$phone);

        /*if(strlen($to)==9){ 
            $to = "243".$to;
        } else if(strlen($to)==10){
            $to = "243".substr($to,1,9);
        }*/

        return $to;
    }
}
