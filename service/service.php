<?php
/**
 * ownCloud - galleryplus
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Olivier Paroz <owncloud@interfasys.ch>
 *
 * @copyright Olivier Paroz 2014-2015
 */

namespace OCA\GalleryPlus\Service;

use OCP\Files\Folder;
use OCP\Files\Node;
use OCP\Files\NotFoundException;

use OCP\AppFramework\Http;

use OCA\GalleryPlus\Utility\SmarterLogger;

/**
 * Contains methods which all services will need
 *
 * @package OCA\GalleryPlus\Service
 */
abstract class Service {

	/**
	 * @type string
	 */
	protected $appName;
	/**
	 * @type SmarterLogger
	 */
	protected $logger;

	/**
	 * Constructor
	 *
	 * @param string $appName
	 * @param SmarterLogger $logger
	 */
	public function __construct($appName, SmarterLogger $logger) {
		$this->appName = $appName;
		$this->logger = $logger;
	}

	/**
	 * Returns the resource located at the given path
	 *
	 * The path starts from the user's files folder
	 * The resource is either a File or a Folder
	 *
	 * @param Folder $folder
	 * @param string $path
	 *
	 * @return Node
	 */
	protected function getResource($folder, $path) {

		$node = $this->getNode($folder, $path);
		$resourceId = $node->getId();
		$resourcesArray = $folder->getById($resourceId);

		return $resourcesArray[0];
	}

	/**
	 * Returns the Node based on the current user's files folder and a given
	 * path
	 *
	 * @param Folder $folder
	 * @param string $path
	 *
	 * @return Node
	 */
	protected function getNode($folder, $path) {
		$node = false;
		try {
			$node = $folder->get($path);
		} catch (NotFoundException $exception) {
			$message = $exception->getMessage();
			$code = Http::STATUS_NOT_FOUND;
			$this->kaBoom($message, $code);
		}

		return $node;
	}

	/**
	 * Logs the error and raises an exception
	 *
	 * @param string $message
	 * @param int $code
	 *
	 * @throws ServiceException
	 */
	protected function kaBoom($message, $code) {
		$this->logger->error($message . ' (' . $code . ')');

		throw new ServiceException(
			$message,
			$code
		);
	}
}