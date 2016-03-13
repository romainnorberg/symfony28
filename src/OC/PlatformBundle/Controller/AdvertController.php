<?php

namespace OC\PlatformBundle\Controller;

use OC\PlatformBundle\Entity\Advert;
use OC\PlatformBundle\Entity\Image;
use OC\PlatformBundle\Entity\Application;
use OC\PlatformBundle\Entity\AdvertSkill;
use OC\PlatformBundle\Entity\AdvertRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdvertController extends Controller
{

  public function indexAction($page)
  {
    // On ne sait pas combien de pages il y a
    // Mais on sait qu'une page doit être supérieure ou égale à 1
    if ($page < 1) {
      // On déclenche une exception NotFoundHttpException, cela va afficher
      // une page d'erreur 404 (qu'on pourra personnaliser plus tard d'ailleurs)
      throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
    }

    $listAdverts = $this
      ->getDoctrine()
      ->getManager()
      ->getRepository('OCPlatformBundle:Advert')
      ->getAdvertWithApplications()
    ;

    /*
    $em = $this->getDoctrine()->getManager();
    $listAdverts = $em->getRepository('OCPlatformBundle:Advert')->myFindAll();
    */
    /*
     foreach ($listAdverts as $advert) {
      // Ne déclenche pas de requête : les candidatures sont déjà chargées !
      // Vous pourriez faire une boucle dessus pour les afficher toutes
      foreach ($advert->getApplications() as $application) {
        echo $application->getId();
      };
    }
    */


    // Mais pour l'instant, on ne fait qu'appeler le template
    return $this->render('OCPlatformBundle:Advert:index.html.twig', array(
      'listAdverts' => $listAdverts
    ));
  }

  public function menuAction($limit)
  {
    // On fixe en dur une liste ici, bien entendu par la suite
    // on la récupérera depuis la BDD !
    $listAdverts = array(
      array('id' => 2, 'title' => 'Recherche développeur Symfony2'),
      array('id' => 5, 'title' => 'Mission de webmaster'),
      array('id' => 9, 'title' => 'Offre de stage webdesigner')
    );

    return $this->render('OCPlatformBundle:Advert:menu.html.twig', array(
      // Tout l'intérêt est ici : le contrôleur passe
      // les variables nécessaires au template !
      'listAdverts' => $listAdverts
    ));
  }

  public function viewAction($id)
  {

    $em = $this->getDoctrine()->getManager();
    $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);

    $applications = $advert->getApplications();

    $skills = $em
      ->getRepository('OCPlatformBundle:AdvertSkill')
      ->findBy(array('advert' => $advert))
    ;

    return $this->render('OCPlatformBundle:Advert:view.html.twig', array(
      'advert'       => $advert,
      'applications' => $applications,
      'skills'       => $skills
    ));
  }

  public function addAction(Request $request)
  {

    // On récupère l'EntityManager
    $em = $this->getDoctrine()->getManager();
    // La gestion d'un formulaire est particulière, mais l'idée est la suivante :
//
// $em = $this->getDoctrine()->getManager();
//       $advert2 = $em->getRepository('OCPlatformBundle:Advert')->find('46b46640-d976-11e5-8bcc-080027716959');
//
//       // On modifie cette annonce, en changeant la date à la date d'aujourd'hui
//       $advert2->setDate(new \Datetime());

    // Création de l'entité Advert
    $advert = new Advert();
    $advert->setTitle('Recherche développeur Symfony2.');
    $advert->setAuthor('Alexandre');
    $advert->setContent("Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…");

    // Création de l'entité Image
    $image = new Image();
    $image->setUrl('http://sdz-upload.s3.amazonaws.com/prod/upload/job-de-reve.jpg');
    $image->setAlt('Job de rêve');

    // On lie l'image à l'annonce
    $advert->setImage($image);

    $application1 = new Application();
    $application1->setAuthor('Romain');
    $application1->setContent('Test content');

    $application2 = new Application();
    $application2->setAuthor('John');
    $application2->setContent('Test content 2');

    $application1->setAdvert($advert);
    $application2->setAdvert($advert);

    // On récupère toutes les compétences possibles
    $listSkills = $em->getRepository('OCPlatformBundle:Skill')->findAll();

    // Pour chaque compétence
    foreach ($listSkills as $skill) {
      // On crée une nouvelle « relation entre 1 annonce et 1 compétence »
      $advertSkill = new AdvertSkill();

      // On la lie à l'annonce, qui est ici toujours la même
      $advertSkill->setAdvert($advert);
      // On la lie à la compétence, qui change ici dans la boucle foreach
      $advertSkill->setSkill($skill);

      // Arbitrairement, on dit que chaque compétence est requise au niveau 'Expert'
      $advertSkill->setLevel('Expert');

      // Et bien sûr, on persiste cette entité de relation, propriétaire des deux autres relations
      $em->persist($advertSkill);
    }

    $categories = $em->getRepository('OCPlatformBundle:Category')->findAll();

    foreach($categories as $category){
      $advert->addCategory($category);
    }

    // Étape 1 : On « persiste » l'entité
    $em->persist($advert);

    // Étape 1 bis : si on n'avait pas défini le cascade={"persist"},
    // on devrait persister à la main l'entité $image
    $em->persist($application1);
    $em->persist($application2);

    // Étape 2 : On déclenche l'enregistrement
    $em->flush();


    // Si la requête est en POST, c'est que le visiteur a soumis le formulaire
    if ($request->isMethod('POST')) {
      // Ici, on s'occupera de la création et de la gestion du formulaire
    }

    $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

    // Puis on redirige vers la page de visualisation de cettte annonce
    return $this->redirectToRoute('oc_platform_view', array('id' => $advert->getId()));

  }

  public function editAction($id, Request $request)
  {

    $em = $this->getDoctrine()->getManager();

    $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);

    /*
    $categories = $em->getRepository('OCPlatformBundle:Category')->findAll();

    foreach($categories as $category){
      $advert->addCategory($category);
    }
    */
    //$advert->setTitle('test2');

    $application1 = new Application();
    $application1->setAuthor('Romain');
    $application1->setContent('Test content'.time());

    $application1->setAdvert($advert);

    $em->persist($application1);

    $em->flush();

    // Même mécanisme que pour l'ajout
    if ($request->isMethod('POST')) {
      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');

      return $this->redirectToRoute('oc_platform_view', array('id' => 5));
    }

    return $this->render('OCPlatformBundle:Advert:edit.html.twig', array(
      'advert' => $advert
    ));
  }

  public function deleteAction($id)
  {
    // Ici, on récupérera l'annonce correspondant à $id

    // Ici, on gérera la suppression de l'annonce en question

    return $this->render('OCPlatformBundle:Advert:delete.html.twig');
  }
}
