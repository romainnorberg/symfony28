<?php

namespace OC\PlatformBundle\Controller;

use Symfony\Component\HttpFoundation\Response,
		Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdvertController extends Controller
{
  public function indexAction()
  {
		$url = $this->generateUrl(
			'oc_platform_view',
			array(
				'id' => 5
			)
		);

    $content = $this
			->get('templating')
			->render('OCPlatformBundle:Advert:index.html.twig', array(
				'url' => $url
			)
		);

    return new Response($content);
  }

	public function viewAction($id){
		return new Response("Affichage de l'annonce d'id : ".$id);
	}

	public function viewSlugAction($year, $slug, $_format){
		return new Response("Affichage de l'annonce slug : ".$slug);
	}
}
