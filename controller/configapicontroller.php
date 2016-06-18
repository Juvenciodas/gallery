<?php
/**
 * ownCloud - galleryplus
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Olivier Paroz <owncloud@interfasys.ch>
 *
 * @copyright Olivier Paroz 2016
 */

namespace OCA\GalleryPlus\Controller;

use OCP\IRequest;
use OCP\ILogger;

use OCP\AppFramework\ApiController;
use OCP\AppFramework\Http;

use OCA\GalleryPlus\Service\ConfigService;

/**
 * Class ConfigApiController
 *
 * @package OCA\GalleryPlus\Controller
 */
class ConfigApiController extends ApiController {

	use Config;
	use HttpError;

	/**
	 * Constructor
	 *
	 * @param string $appName
	 * @param IRequest $request
	 * @param ConfigService $configService
	 * @param ILogger $logger
	 */
	public function __construct(
		$appName,
		IRequest $request,
		ConfigService $configService,
		ILogger $logger
	) {
		parent::__construct($appName, $request);

		$this->configService = $configService;
		$this->logger = $logger;
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 * @CORS
	 *
	 * Returns an app configuration array
	 *
	 * @param bool $extramediatypes
	 *
	 * @return array <string,null|array>
	 */
	public function get($extramediatypes = false) {
		try {
			return $this->getConfig($extramediatypes);
		} catch (\Exception $exception) {
			return $this->jsonError($exception);
		}
	}

}
