<?php

namespace App\Controller;

use App\Controller\AbstractAdminController;
use App\Query\TravelQuery;
use App\Form\TravelForm;
use App\Service\FileService;

/*
    pour les contrôleurs de l'espace d'administration, utiliser AbstractAdminController
    pour les contrôleurs de l'espace public, utiliser AbstractController
*/
class AdminTravel extends AbstractAdminController
{
    // lister le contenu de la table
    public function index(array $urlParams = []):void
    {
        // récupération du contenu de la table
        $travelQuery = new TravelQuery();
        $results = $travelQuery->getAll();
        //echo '<pre>'; var_dump($results) ; echo '</pre>';

        // récupération d'une notification stockée en session
        // par exemple la notification créée dans AbstractAdminController
        $sessionNotice = isset($_SESSION['notice']) ? $_SESSION['notice'] : null;
        $sessionNoticeError = isset($_SESSION['notice_error']) ? $_SESSION['notice_error'] : null;

        // supprimer la notification stockée en session pour un affichage unique
        unset($_SESSION['notice']);
        unset($_SESSION['notice_error']);

        // affichage de la vue
        $this->render('admin-travel/index', [
            'results' => $results,
            'sessionNotice' => $sessionNotice,
            'sessionNoticeError' => $sessionNoticeError,
        ]);
    }

    // affichage du formulaire
    public function form(array $urlParams = []):void
    {
        // formulaire
        $form = new TravelForm();

        // classe de requête
        $query = new TravelQuery();

		// si l'identifiant est dans l'URL (modification)
		// $urlParams[0] : récupération de l'identifiant dans l'URL
		// sélection du voyage selon son id dans la base de données
		$result = isset($urlParams[0]) ? $query->get($urlParams[0]) : null;
		//echo '<pre>'; var_dump($result) ; echo '</pre>';

        // si le formulaire n'a jamais été envoyé // submit est le name du bouton
        //echo '<pre>'; var_dump($urlParams); echo '</pre>'; exit;
        if(count($urlParams) > 0 && !isset($_POST['submit'])){
            // décodage des étapes stockées en JSON dans la table
            $result['steps'] = json_decode($result['steps']);
            //echo '<pre>'; var_dump($result); echo '</pre>'; exit;

            // mettre à jour les valeurs (saisie) du formulaire avec la propriété $values de TravelForm
            $form->setValues($result);
        }

        // si le formulaire est valide
        if($form->verify()){
			// récupération de la saisie du formulaire
			$formValues = $form->getValues();

            //echo '<pre>'; var_dump($formValues) ; echo '</pre>'; exit;
            // récupération de l'erreur mysql si l'insertion/modification n'a pas fonctionné
            try{
				// si une image a été sélectionnée
				if($formValues['image']['error'] === \UPLOAD_ERR_OK){
					// récupération du fichier
                    $file = $formValues['image']['tmp_name'];

                    // service de gestion des fichiers
                    $fileService = new FileService();
                    $fileService->upload($file, 'img');

                    // mise à jour de l'entrée image avant insertion dans la table
                    // récupération du nom aléatoire du fichier généré dans FileService
                    $formValues['image'] = $fileService->getFileName();

                    // suppression de l'ancienne image lors d'une modification
                    if(!empty($result['image'])){
                        // suppression de l'image
                        $fileService->delete($result['image'], 'img');
                    }
				}

				// si aucune image n'a été sélectionnée lors de la modification
				else{
					// récupération de l'image stockée dans la table
					// mise à jour de l'entrée image avant insertion dans la table
					$formValues['image'] = $result['image'];
                }
 
                // encodage des étapes en JSON avant l'insertion dans la table
                $formValues['steps'] = json_encode($formValues['steps']);
                //echo '<pre>'; var_dump($formValues) ; echo '</pre>'; exit;

                // insertion dans la table
                $query->process($formValues);

                // notification de confirmation
                $_SESSION['notice'] = count($urlParams) > 0 ? 'Voyage modifié' : 'Voyage ajouté';

            } catch (\PDOException $exception){
                //echo '<pre>'; var_dump($exception->errorInfo[2], $exception->getMessage()) ; echo '</pre>'; exit;
                $_SESSION['notice'] = $exception->errorInfo[2];

                // définir une notification d'erreur
                $_SESSION['notice_error'] = true;
            }
            
            // redirection
            header('Location: /admintravel');
        }

        // affichage de la vue
        // la saisie stockée dans TravelForm, avec la propriété values, est envoyée à la vue
        // les messages stockés dans TravelForm, avec la propriété messages, sont envoyés à la vue
        $this->render('admin-travel/form', [
            'values' => $form->getValues(),
            'messages' => $form->getMessages(),
        ]);
    }

    // suppression d'un enregistrement
    public function delete(array $urlParams = []):void{
        // requête de suppression
        try{
            // classe de requête
            $query = new TravelQuery();

            // sélection de l'enregistrement selon l'id présent dans l'URL
            $result = $query->get($urlParams[0]);

            // suppression en récupération l'id dans l'URL, stocké dans $urlParams
            $query->delete($urlParams[0]);

            // suppression de l'image
            $fileService = new FileService();
            $fileService->delete($result['image'], 'img');

            // notification de confirmation
            $_SESSION['notice'] = 'Voyage supprimé';

        } catch (\PDOException $exception){
            // notification d'erreur
            $_SESSION['notice'] = $exception->errorInfo[2];

            // définir une notification d'erreur
            $_SESSION['notice_error'] = true;
        }

        // redirection
        header('Location: /admintravel');
    }

}