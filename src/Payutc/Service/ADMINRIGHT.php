<?php

namespace Payutc\Service;

use \User;
use \UserRight;
use \ApplicationRight;
use \Application;

/**
 * ADMINRIGHT.services.php
 * 
 * Ce service permet de gérer les droits.
 * Seul les utilisateurs ayant le droit ADMINRIGHT peuvent venir ici.
 *
 */
 
 class ADMINRIGHT extends \ServiceBase {
	 
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Recuperer la liste des droits attribuables (les noms de service en fait)
     * Comme on ne veut pas forcément lister tout les services possibles et que l'ont veut leur donner un petit nom sympa et une description
     * ils sont hardcodé
     *
     * clef "service" => Nom des services (correspond au nom de classe du service et àa ce qu'on met dans la db)
     * clef "name" => Nom du droit
     * clef "desc" => Descriptions du droit
     * clef "user" => doit on pouvoir donner ce droit à un user
     * clef "app" => doit on pouvoir donner ce droit à une app (en soit c'est toujours le cas, mais veut on le faire apparaitre par défaut dans les menus)
     *
     * Pour les clefs user et app, ce n'est que pour l'ergonomie de l'interface utilisateur. 
     * @return array $services
     */
    public function getServices() {
        return array(
                    array(
                        "service" => "ADMINRIGHT",
                        "name"    => "Administrateur de fondation", 
                        "desc"    => "Permet la gestion des droits pour les utilisateurs de la fondations",
                        "user"    => true,
                        "app"     => false
                    ), array(
                        "service" => "POSS3",
                        "name"    => "Vente physique",
                        "desc"    => "Permet la vente par badge",
                        "user"    => true,
                        "app"     => true
                    ), array(
                        "service" => "SELFPOS",
                        "name"    => "Vente physique sans vendeur par login",
                        "desc"    => "Permet la vente par login sans vendeur",
                        "user"    => false,
                        "app"     => true
                    ), array(
                        "service" => null,
                        "name"    => "Tout les droits",
                        "desc"    => "Donne les droits à l'utilisateur ou à l'application sur tous les services",
                        "user"    => true,
                        "app"     => true
                    ), array(
                        "service" => "BLOCKED",
                        "name"    => "Blocage",
                        "desc"    => "Donne les droits à l'utilisateur ou à l'application de bloquer/débloquer un utilisateur",
                        "user"    => true,
                        "app"     => true
                    ), array(
                        "service" => "GESARTICLE",
                        "name"    => "Gestion des articles",
                        "desc"    => "Donne les droits de gérer les articles (stock, prix, images...)",
                        "user"    => true,
                        "app"     => true
                    ), array(
                        "service" => "TRESO",
                        "name"    => "Trésorerie",
                        "desc"    => "Permet le suivi par le trésorier.",
                        "user"    => true,
                        "app"     => true
                    ), array(
                        "service" => "STATS",
                        "name"    => "Statistiques",
                        "desc"    => "Permet de récupérer différentes informations statistiques sur la fundation.",
                        "user"    => true,
                        "app"     => true
                    ), array(
                        "service" => "RELOAD",
                        "name"    => "Rechargement",
                        "desc"    => "Permet le rechargement des utilisateurs",
                        "user"    => false,
                        "app"     => false
                    ), array(
                        "service" => "MYACCOUNT",
                        "name"    => "Gestion de mon compte",
                        "desc"    => "Permet de consulter un historique, et de bloquer/débloquer sa carte",
                        "user"    => false,
                        "app"     => false
                    ), array(
                        "service" => "TRANSFER",
                        "name"    => "Virer de l'argent",
                        "desc"    => "Permet de virer de l'argent vers un autre utilisateur",
                        "user"    => false,
                        "app"     => false
                    ), array(
                        "service" => "CATALOG",
                        "name"    => "Consulter le catalogue d'une fondation depuis son application",
                        "desc"    => "Permet de consluter le catalogue des produits (bières, softs, snacks) avec une connexion d'application",
                        "user"    => false,
                        "app"     => true
                    ),array(
                        "service" => "WEBSALE",
                        "name"    => "Encaisser par internet",
                        "desc"    => "Permet à une application d'encaisser de l'argent par internet",
                        "user"    => false,
                        "app"     => true
                    ), array(
                        "service" => "WEBSALECONFIRM",
                        "name"    => "Valider des paiements par internet",
                        "desc"    => "Permet de valider les paiements en ligne",
                        "user"    => false,
                        "app"     => false
                    ), array(
                        "service" => "NOTIFICATIONS",
                        "name"    => "Notifier les utilisateurs",
                        "desc"    => "Permet de notifier certains évènements à un utilisateur",
                        "user"    => false,
                        "app"     => false
                    ), array(
                        "service" => "MESSAGES",
                        "name"    => "Récupèrer et changer des messages persos",
                        "desc"    => "Permet de changer les messages persos d’une fundation ou d’un utilisateur",
                        "user"    => true,
                        "app"     => true
                    )
                    
                );
    }
     
	/**
	* Donner un droit liant un user à une fundation.
	*
	* @param string $usr_login
	* @param string $service
	* @param int $fun_id
	* @return array $result
	*/
	public function setUserRight($usr_id, $service, $fun_id){
        $this->checkRight(true, true, true, $fun_id);
        // L'utilisateur à les droits de donner ce droit :)
        return UserRight::setRight($usr_id, $service, $fun_id);
	}

	/**
	* Donner un droit liant une application à une fundation.
	*
	* @param int $app_id
	* @param string $service
	* @param int $fun_id
	* @return array $result
	*/
	public function setApplicationRight($app_id, $service, $fun_id){
        $this->checkRight(true, true, true, $fun_id);
        // L'utilisateur à les droits de donner ce droit :)
        ApplicationRight::setRight($app_id, $service, $fun_id);
	}

	/**
	* Supprimer un droit liant un user à une fundation.
	*
	* @param int $usr_id
	* @param string $service
	* @param int $fun_id
	* @return array $result
	*/
	public function removeUserRight($usr_id, $service, $fun_id){
        $this->checkRight(true, true, true, $fun_id);
        // L'utilisateur à les droits de retirer ce droit :)
        UserRight::removeRight($usr_id, $service, $fun_id);
	}

	/**
	* Supprimer un droit liant une application à une fundation.
	*
	* @param int $app_id
	* @param string $service
	* @param int $fun_id
	* @return array $result
	*/
	public function removeApplicationRight($app_id, $service, $fun_id){
        $this->checkRight(true, true, true, $fun_id);
        // L'utilisateur à les droits de retirer ce droit :)
        ApplicationRight::removeRight($app_id, $service, $fun_id);
	}

	/**
	* Obtenir les droits liant des user à une fundation.
	*
	* @param int $fun_id
	* @return array $result
	*/
	public function getUserRights($fun_id){
        $this->checkRight(true, true, true, $fun_id);
        // L'utilisateur à les droits de regarder ces droits :)
        return UserRight::getRights($fun_id);
	}

	/**
	* Obtenir les droits liant des applications à une fundation.
	*
	* @param int $fun_id
	* @return array $result
	*/
	public function getApplicationRights($fun_id){
        $this->checkRight(true, true, true, $fun_id);
        // L'utilisateur à les droits de regarder ces droits :)
        return ApplicationRight::getRights($fun_id);
	}
	
	/**
	* Obtenir les applications déclarés (pour l'interface utilisateur des droits)
	*
	* @return array $result
	*/
	public function getApplications(){
        $this->checkRight();
        // L'utilisateur à les droits de regarder la liste des applications
        return Application::getAll();
	}

 }
