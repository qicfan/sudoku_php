<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of image_Gmagick_Driver
 *
 * @author qicfan
 */
class Image_Gmagick_Driver extends Image_Driver
{

	protected $old_gmagick = null;
	protected $new_gmagick = null;

	// Make sure that GD2 is available
	public function __construct($config = array())
	{
		if (!class_exists('Gmagick'))
		{
			throw new CException('Gmagick not required!');
		}
	}

	public function process($image, $actions, $dir, $file, $render = FALSE)
	{
		// Load the image
		$this->image = $image;
		try
		{
			$this->old_gmagick = new Gmagick($image['file']);
		}
		catch (GmagickException $e)
		{
			throw new CException($e->message);
		}
		// Create the Gmagick resource
		try
		{
			$this->new_gmagick = new Gmagick();
		}
		catch (GmagickException $e)
		{
			throw new CException($e->message);
		}
		if (($status = $this->execute($actions)) == true)
		{
			if ($render === false)
			{
				try
				{
					$status = $this->new_gmagick->write($dir . $file);
				}
				catch (GmagickException $e)
				{
					throw new CException($e->message);
				}
			}
		}
		else
		{
			// Output the image directly to the browser
			header('Content-Type: ' . $image['mime']);
		}
		$this->old_gmagick->destroy();
		$this->new_gmagick->destroy();
		return $status;
	}

	public function flip($direction)
	{

	}

	public function crop($properties)
	{
		$new_width = $properties['width'];
		$new_height = $properties['height'];
		try
		{
			$this->old_gmagick->cropthumbnailimage($new_width,$new_height);
		}
		catch (GmagickException $e)
		{
			throw new CException($e->message);
		}
		$this->new_gmagick = $this->old_gmagick;
		return true;
	}

	public function resize($prop)
	{
		$new_width = $prop['width'];
		$new_height = $prop['height'];
		//$this->new_gmagick = $this->old_gmagick;
		//$this->new_gmagick->thumbnailimage($new_width, $new_height);
		//$old_width = $this->image['width'];
		//$old_height = $this->image['height'];
		try
		{
			$this->new_gmagick->newimage($new_width, $new_height, '#FFFFFF', 'jpeg');
			$this->old_gmagick->scaleimage($new_width, $new_height, true);
			/* 取得缩图的实际大小 */
			$gw = $this->old_gmagick->getimagewidth();
			$gh = $this->old_gmagick->getimageheight();
			$x = ( $new_width - $gw) / 2;
			$y = ( $new_height - $gh ) / 2;
			$this->new_gmagick = $this->new_gmagick->compositeimage($this->old_gmagick, Gmagick::COMPOSITE_OVER, $x, $y);
		}
		catch (GmagickException $e)
		{
			throw new CException($e->message);
		}
		return true;
	}

	public function rotate($amount)
	{

	}

	public function sharpen($amount)
	{

	}

	public function quality($quality = 89)
	{
		try
		{
			$this->new_gmagick->setCompressionQuality($quality);
		}
		catch (GmagickException $e)
		{
			throw new CException($e->message);
		}
		return true;
	}

	protected function properties()
	{

	}

}

?>
