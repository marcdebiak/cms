<?php
namespace Craft;

/**
 *
 */
class EtService extends BaseApplicationComponent
{
	/**
	 * @return bool|EtModel
	 */
	public function ping()
	{
		$et = new Et(ElliottEndPoints::Ping);
		$response = $et->phoneHome();

		return $response;
	}

	/**
	 * @param $updateInfo
	 * @return EtModel|bool
	 */
	public function check($updateInfo)
	{
		$et = new Et(ElliottEndPoints::CheckForUpdates);
		$et->getModel()->data = $updateInfo;
		$etModel = $et->phoneHome();

		if ($etModel)
		{
			$etModel->data = UpdateModel::populateModel($etModel->data);
			return $etModel;
		}

		return null;
	}

	/**
	 * @param $downloadPath
	 * @return bool
	 */
	public function downloadUpdate($downloadPath)
	{
		$et = new Et(ElliottEndPoints::DownloadUpdate, 240);

		if (IOHelper::folderExists($downloadPath))
		{
			$downloadPath .= StringHelper::UUID().'.zip';
		}

		$et->setDestinationFileName($downloadPath);

		if (($fileName = $et->phoneHome()) !== null)
		{
			return $fileName;
		}

		return false;
	}

	/**
	 * Returns the license key status.
	 */
	public function getLicenseKeyStatus()
	{
		$status = craft()->fileCache->get('licenseKeyStatus');
		return $status;
	}

	/**
	 * Sets the license key status.
	 */
	public function setLicenseKeyStatus($status)
	{
		craft()->fileCache->set('licenseKeyStatus', $status, craft()->config->getCacheDuration());
	}

	/**
	 *
	 */
	public function decodeEtValues($values)
	{
		return EtModel::populateModel(JsonHelper::decode($values));
	}
}
