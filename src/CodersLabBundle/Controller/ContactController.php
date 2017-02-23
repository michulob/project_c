<?php

namespace CodersLabBundle\Controller;

use CodersLabBundle\Entity\Contact;
use CodersLabBundle\Entity\Address;
use CodersLabBundle\Entity\Email;
use CodersLabBundle\Entity\Phone;
use CodersLabBundle\Form\ContactType;
use CodersLabBundle\Form\AddressType;
use CodersLabBundle\Form\PhoneType;
use CodersLabBundle\Form\EmailType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ContactController extends Controller
{
//1. Tworzenie formularza do stworzenia nowej
//encji (GET na adres /new).
     /**
     * @Route("/new")
     * @Method("GET")
     */
    public function newAction()
    {   
        $contact = new Contact();
        $form = $this->createForm(ContactType::class,$contact);

        return $this->render('CodersLabBundle:Contact:new.html.twig', array(
            'form'=>$form->createView()
        ));
    }
    
    //2. Tworzenie nowej encji
//(POST na adres /new).
    /**
     * @Route("/new")
     * @Method("POST")
     */
    public function createAction (Request $req){
        $contact = new Contact();
        $form = $this->createForm(ContactType::class,$contact);
        
        $form->handleRequest($req);
        
        if ($form->isSubmitted() && $form->isValid())
        {
            $contact = $form->getData();
            $contact->setUser($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();
            
            return $this->redirectToRoute("coderslab_contact_show",
                    [
                        'id' => $contact->getId()
                    ]);
        }
    }
//3. Tworzenie formularza do modyfikacji encji
//(GET na adres /{id}/modify).
    /**
     * @Route("/{id}/modify")
     * @Method("GET")
     */
    public function modifyAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        // znalezienie odpowiedniego uzytkownika
        $contact = $em->getRepository('CodersLabBundle:Contact')
                      ->find($id);
        // zapisanie formularza do zmiennej form
        $form = $this->createForm(ContactType::class, $contact);
        
        // stworzenie pustego obiektu address
        $address = new Address();
        // zapisanie do zmiennej formAddress formularza adresu
        $formAddress = $this->createForm(AddressType::class, $address, array(
                                                'action'=> $this->generateUrl('coderslab_contact_addaddress',
                                                        ['id'=> $id]),
                                                'method'=> 'POST'
        ));
        // stworzenie formularza do telefonu
        $phone = new Phone();
        $formPhone = $this->createForm(PhoneType::class, $phone, array(
                                                'action'=> $this->generateUrl('coderslab_contact_addphone',
                                                        ['id'=> $id]),
                                                'method'=> 'POST'
        ));
        
        // stworzenie formularza do emaila
        $email = new Email();
        $formEmail = $this->createForm(EmailType::class, $email, array(
                                                'action'=> $this->generateUrl('coderslab_contact_addemail',
                                                        ['id'=> $id]),
                                                'method'=> 'POST'
        ));

        return $this->render('CodersLabBundle:Contact:modify.html.twig', array(
            'form' => $form->createView(),
            'formAddress' => $formAddress->createView(),
            'formPhone' => $formPhone->createView(),
            'formEmail' => $formEmail->createView()
        ));
    }
    
//4. Modyfikacja encji
//(POST na adres /{id}/modify).
    /**
     * @Route("/{id}/modify")
     * @Method("POST")
     */
    public function updateAction(Request $req, $id){
        $em = $this->getDoctrine()->getManager();
        $contact = $em->getRepository('CodersLabBundle:Contact')
                      ->find($id);
        
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($req);
        
        if($form->isSubmitted()){
            $em->flush();
        }
        return $this->redirectToRoute('coderslab_contact_show', ['id'=>$contact->getId()]);
    }
    
//5. Usunięcie podanej encji
//(GET na adres /{id}/delete).
    /**
     * @Route("/{id}/delete")
     */
    public function deleteAction(Contact $contact)
    {   
        $em = $this->getDoctrine()->getManager();
        $em->remove($contact);
        $em->flush();
        
        return $this->redirectToRoute('coderslab_contact_showall');
    }

    /**
     * @Route("/{id}/show")
     */
    public function showAction(Contact $contact)
    {   
        
        return $this->render('CodersLabBundle:Contact:show.html.twig', array(
                'contact' => $contact
        ));
    }

    /**
     * @Route("/showAll")
     */
    public function showAllAction()
    {   
        $user = $this->getUser();
//      return $this->render('CodersLabBundle:Contact:debug.html.twig', array(
//            'user' => $user
//        ));
        $contacts = $this->getDoctrine()
                         ->getRepository('CodersLabBundle:Contact')
                         ->findByUser($user->getId());
        return $this->render('CodersLabBundle:Contact:show_all.html.twig', array(
            'contacts' => $contacts
        ));
    }
    
//    1. Dodaj do widoku formularz (przypisany do
//adresu), który będzie odsyłał do strony POST
///{id}/addAddress.
    /**
     * @Route ("{id}/addAddress")
     * @Method("POST")
     */
    public function addAddressAction(Request $req, Contact $contact){
        
        $address = new Address();
        $form = $this->createForm(AddressType::class,$address);
        
        $form->handleRequest($req);
        
        if ($form->isSubmitted() && $form->isValid())
        {
            $address = $form->getData();
            $address->setContact($contact);
            $contact->addAddress($address);
            $em = $this->getDoctrine()->getManager();
            $em->persist($address);
            $em->persist($contact);
            $em->flush();
            
            return $this->redirectToRoute("coderslab_contact_show",
                    [
                        'id' => $contact->getId()
                    ]);
        }
    }
    
//    2. Dodaj do widoku formularz (przypisany do
//numeru telefonu), który będzie odsyłał do strony POST
///{id}/addPhone.
    /**
     * @Route ("{id}/addPhone")
     * @Method("POST")
     */
    public function addPhoneAction(Request $req, Contact $contact){
        
        $phone = new Phone();
        $form = $this->createForm(PhoneType::class,$phone);
        
        $form->handleRequest($req);
        
        if ($form->isSubmitted() && $form->isValid())
        {
            $phone = $form->getData();
            $phone->setContact($contact);
            $contact->addPhone($phone);
            $em = $this->getDoctrine()->getManager();
            $em->persist($phone);
            $em->persist($contact);
            $em->flush();
            
            return $this->redirectToRoute("coderslab_contact_show",
                    [
                        'id' => $contact->getId()
                    ]);
        }
    }
    
    //    3. Dodaj do widoku formularz (przypisany do
//emaila), który będzie odsyłał do strony POST
///{id}/addEmail.
    /**
     * @Route ("{id}/addEmail")
     * @Method("POST")
     */
    public function addEmailAction(Request $req, Contact $contact){
        
        $email = new Email();
        $form = $this->createForm(EmailType::class,$email);
        
        $form->handleRequest($req);
        
        if ($form->isSubmitted() && $form->isValid())
        {
            $email = $form->getData();
            $email->setContact($contact);
            $contact->addEmail($email);
            $em = $this->getDoctrine()->getManager();
            $em->persist($email);
            $em->persist($contact);
            $em->flush();
            
            return $this->redirectToRoute("coderslab_contact_show",
                    [
                        'id' => $contact->getId()
                    ]);
        }
    }
    
//4. Usunięcie adresu
//(GET na adres /{id}/deleteAddress).
    /**
     * @Route("/{id}/deleteAddress")
     */
    public function deleteAddressAction($id)
    {   
        $em = $this->getDoctrine()->getManager();
        $address = $em->getRepository('CodersLabBundle:Address')
                      ->find($id);
        $contact = $em->getRepository('CodersLabBundle:Contact')
                      ->find($address->getContact());
        $em->remove($address);
        $em->flush();
        
//        return $this->render('CodersLabBundle:Contact:debug.html.twig', array(
//            'address' => $address,
//            'id' => $id,
//            'contact' => $contact
//        ));
        return $this->redirectToRoute('coderslab_contact_show', ['id'=>$contact->getId()]);
    }
    
//5. Usunięcie telefonu
//(GET na adres /{id}/deletePhone).
    /**
     * @Route("/{id}/deletePhone")
     */
    public function deletePhoneAction($id)
    {   
        $em = $this->getDoctrine()->getManager();
        $phone = $em->getRepository('CodersLabBundle:Phone')
                      ->find($id);
        $contact = $em->getRepository('CodersLabBundle:Contact')
                      ->find($phone->getContact());
        $em->remove($phone);
        $em->flush();
        
        return $this->redirectToRoute('coderslab_contact_show', ['id'=>$contact->getId()]);
    }
    
//6. Usunięcie maila
//(GET na adres /{id}/deleteEmail).
    /**
     * @Route("/{id}/deleteEmail")
     */
    public function deleteEmailAction($id)
    {   
        $em = $this->getDoctrine()->getManager();
        $email = $em->getRepository('CodersLabBundle:Email')
                      ->find($id);
        $contact = $em->getRepository('CodersLabBundle:Contact')
                      ->find($email->getContact());
        $em->remove($email);
        $em->flush();
        
        return $this->redirectToRoute('coderslab_contact_show', ['id'=>$contact->getId()]);
    }
}
