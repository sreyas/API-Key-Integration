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
							$entity_type = 'node';
							$view_mode = 'json';
							$view_builder = \Drupal::entityTypeManager()->getViewBuilder($entity_type);
							$storage = \Drupal::entityTypeManager()->getStorage($entity_type);
							$node = $storage->load($id);
							$build = $view_builder->view($node, $view_mode);
							$output = render($build);
						return new JsonResponse($build);
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