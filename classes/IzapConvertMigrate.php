<?php
/**
 * iZAP Videos plugin by iionly
 * (based on version 3.71b of the original izap_videos plugin for Elgg 1.7)
 * Contact: iionly@gmx.de
 * https://github.com/iionly
 *
 * Original developer of the iZAP Videos plugin:
 * @package Elgg videotizer, by iZAP Web Solutions
 * @license GNU Public License version 2
 * @Contact iZAP Team "<support@izap.in>"
 * @Founder Tarun Jangra "<tarun@izap.in>"
 * @link http://www.izap.in/
 *
 */

class IzapConvertMigrate extends IzapConvert {
	private $invideo;
	private $outvideo;
	private $outimage;
	private $imagepreview;
	private $values = [];

	public $format = 'mp4';

	public function __construct($in = '') {
		$this->invideo = $in;
		$extension_length = strlen(izap_get_file_extension($this->invideo));
		$outputPath = substr($this->invideo, 0, '-' . ($extension_length + 1));
		$this->outvideo =  $outputPath . '.' . $this->format;
		$this->outimage = $outputPath . '_i.png';
		$this->imagepreview = $outputPath.'_p.png';
	}

	public function izap_video_convert() {
		$videoCommand = izapGetFfmpegVideoConvertCommand_izap_videos();
		$videoCommand = str_replace('[inputVideoPath]', $this->invideo, $videoCommand);
		$videoCommand = str_replace('[outputVideoPath]', $this->outvideo, $videoCommand);

		exec($videoCommand, $arr, $ret);

		if (!$ret == 0) {
			$return = [];
			$return['error'] = 1;
			$return['message'] = end($arr);
			$return['completeMessage'] = implode(' ', $arr);

			return $return;
		}

		return end(explode('/', $this->outvideo));
	}
}
