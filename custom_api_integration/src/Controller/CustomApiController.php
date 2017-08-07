<?php
namespace Drupal\custom_api_integration\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Returns responses for Custom Api Integration module routes.
 */
class CustomApiController extends ControllerBase {

   public function apijson($key, $id) {
   	
   	//Getting site Api Key
   	$config = \Drupal::config('system.site');
   	$site_api = $config->get('siteapikey');
   	
   	
   	if($site_api == $key) {
      	if (!empty($id)) {
      	$node = \Drupal\node\Entity\Node::load($id);
				if(!empty($node)) {

					$type_name = $node->type->entity->label();
    					if(!empty($type_name) && $type_name =='Basic page') {
							$serializer = \Drupal::service('serializer');
							$node = Node::load($id);
							$data = $serializer->serialize($node, 'json');
							return new JsonResponse($data);
						}
						else {
							throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException();
 							return;
						}
				}
				else {
				throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException();
 				return;
				}
			}
			else {
			throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException();
 	 		return;
			}
	}
	else {
	throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException();
 	return;
}

}
}