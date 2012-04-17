<?php

Yii::import('application.extensions.image.Image');

/**
 * Description of CImageComponent
 *
 * @author Administrator
 */
class CImageComponent extends CApplicationComponent
{
    /**
     * Drivers available:
     *  GD - The default driver, requires GD2 version >= 2.0.34 (Debian / Ubuntu users note: Some functions, eg. sharpen may not be available)
     *  ImageMagick - Windows users must specify a path to the binary. Unix versions will attempt to auto-locate.
     * @var string
     */
    public $driver = 'GD';

    /**
     * ImageMagick driver params
     * @var array
	 * 2012-2-18 18:15 qixiaopeng 增加了Gmagick驱动
     */
    public $params = array();

    public function init()
    {
        parent::init();
        if($this->driver != 'GD' && $this->driver != 'ImageMagick' && $this->driver != 'Gmagick'){
            throw new CException('driver must be GD or ImageMagick or Gmagick');
        }
    }

    public function load($image)
    {
        $config = array(
            'driver'=>$this->driver,
            'params'=>$this->params,
        );

        return new Image($image, $config);
    }
}
?>
