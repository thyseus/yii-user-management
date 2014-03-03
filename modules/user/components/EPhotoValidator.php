<?php
Yii::import('application.modules.user.UserModule');
/**
 * EPhotoValidator class file.
 *
 * @author emix
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2009 emix
 * @license
 *
 * Copyright (C) 2008 by emix
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 * - Redistributions of source code must retain the above copyright notice,
 *   this list of conditions and the following disclaimer.
 * - Redistributions in binary form must reproduce the above copyright notice,
 *   this list of conditions and the following disclaimer in the documentation
 *   and/or other materials provided with the distribution.
 * - Neither the name of emix nor the names of its contributors may
 *   be used to endorse or promote products derived from this software without
 *   specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE
 * GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE,
 * EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * @author vladm
 * @version 0.2alpha_vladm revised version. date: February 14, 2010
 */

class EPhotoValidator extends CFileValidator {

	/**
	 * @var string Allowed mime type of the image, ie: image/jpeg
	 */
	public $mimeType;

	/**
	 * @var string Mime type error message
	 */
	public $mimeTypeError;
	/**
	 * @var fixed image width required.
	 */
	public $width;
	/*
	 * @var string width error message.
	 */
	public $widthError;
	/*
	 * @var fixed image height required.
	 */
	public $height;
	/*
	 * @var string height error message.
	 */
	public $heightError;
	/**
	 * @var int Minimum width of the image required.
	 */
	public $minWidth;
	/**
	 * @var string Mime type error message
	 */
	public $minWidthError;

	/**
	 * @var int Maximum width of the image allowed
	 */
	public $maxWidth;
	/**
	 * @var string Mime type error message
	 */
	public $maxWidthError;

	/**
	 * @var int Minimum height of the image required.
	 */
	public $minHeight;
	/**
	 * @var string Mime type error message
	 */
	public $minHeightError;

	/**
	 * @var int Maximum height of the image allowed.
	 */
	public $maxHeight;
	/**
	 * @var string Mime type error message
	 */
	public $maxHeightError;

	/**
	 * @var int Maximum height of the image allowed.
	 */
	public $smallSideSize;
	/**
	 * @var string Mime type error message
	 */
	public $smallSideSizeError;

	/**
	 * @var int Maximum height of the image allowed.
	 */
	public $smallSideMinSize;
	/**
	 * @var string Mime type error message
	 */
	public $smallSideMinSizeError;

	/**
	 * @var int Maximum height of the image allowed.
	 */
	public $smallSideMaxSize;
	/**
	 * @var string Mime type error message
	 */
	public $smallSideMaxSizeError;
	
	/**
	 * @var int Minimum height of the image required.
	 */
	public $bigSideSize;
	/**
	 * @var string Mime type error message
	 */
	public $bigSideSizeError;

	/**
	 * @var int Maximum height of the image allowed.
	 */
	public $bigSideMinSize;
	/**
	 * @var string Mime type error message
	 */
	public $bigSideMinSizeError;

	/**
	 * @var int Maximum height of the image allowed.
	 */
	public $bigSideMaxSize;
	/**
	 * @var string Mime type error message
	 */
	public $bigSideMaxSizeError;
	
	protected function validateAttribute($object, $attribute)
	{
		parent::validateAttribute($object, $attribute);
	}
	/**
	 * Internally validates a file object.
	 * @param CModel the object being validated
	 * @param string the attribute being validated
	 * @param CUploadedFile uploaded file passed to check against a set of rules
	 */
	public function validateFile($object, $attribute, $file) {
		// do parent validation
		parent::validateFile($object, $attribute, $file);
		
		// prevent next validation if no file, other UPLOAD_ERR_s was checked before
		if(null===$file || ($file->getError()) == UPLOAD_ERR_NO_FILE)
			return;

		/**
		 * Index 0 and 1 contains respectively the width and the height of the 
		 * image. 
		 * Index 2 is one of the IMAGETYPE_XXX constants indicating the type of 
		 * the image. 
		 * Index 3 is a text string with the correct height="yyy" width="xxx" 
		 * string. 
		 * Key 'mime' is the correspondant MIME type of the image. 
		 * Key 'channels' will be 3 for RGB pictures and 4 for CMYK pictures. 
		 * Key 'bits' is the number of bits for each color.
		 */
		$info = @getimagesize($file->getTempName());
		
		if(!$info){
			$message = Yum::t('The file "{file}" is not an image.', array(), 'coreMessages');
			$this->addError($object, $attribute, $message, array('{file}'=>$file->getName()));
			return;
		}
		
		// remove unnecessary values from $info and make it more readable
		$info = array(
			'width' => $info[0],
			'height' => $info[1],
			'mime' => $info['mime'],
		);
		
		if ($this->width!==null){
			if($info['width'] != $this->width) {
				$message = $this->widthError ? $this->widthError : Yum::t('The image "{file}" width should be "{width}px".', array(), 'coreMessages');
				$this->addError($object, $attribute, $message, array('{file}'=>$file->getName(), '{width}'=>$this->width));
			}
		}
		if ($this->minWidth!==null) {
			if ($info['width'] < $this->minWidth) {
				$message = $this->minWidthError ? $this->minWidthError : Yum::t('The image "{file}" width should be at least "{width}px".', array(), 'coreMessages');
				$this->addError($object, $attribute, $message, array('{file}'=>$file->getName(), '{width}'=>$this->minWidth));
			}
		}
		if ($this->maxWidth!==null) {
			if ($info['width'] > $this->maxWidth) {
				$message = $this->maxWidthError ? $this->maxWidthError : Yum::t('The image "{file}" width should be at most "{width}px".', array(), 'coreMessages');
				$this->addError($object, $attribute, $message, array('{file}'=>$file->getName(), '{width}'=>$this->maxWidth));
			}
		}
		if ($this->height!==null){
			if($info['height'] != $this->height) {
				$message = $this->heightError ? $this->heightError : Yum::t('The image "{file}" height should be "{height}px".', array(), 'coreMessages');
				$this->addError($object, $attribute, $message, array('{file}'=>$file->getName(), '{height}'=>$this->height));
			}
		}
		if ($this->minHeight!==null) {
			if ($info['height'] < $this->minHeight) {
				$message = $this->minHeightError ? $this->minHeightError : Yum::t('The image "{file}" height should be at least "{height}px".', array(), 'coreMessages');
				$this->addError($object, $attribute, $message, array('{file}'=>$file->getName(), '{height}'=>$this->minHeight));
			}
		}
		if ($this->maxHeight!==null) {
			if ($info['height'] > $this->maxHeight) {
				$message = $this->maxHeightError ? $this->maxHeightError : Yum::t('The image "{file}" height should be at most "{height}px".', array(), 'coreMessages');
				$this->addError($object, $attribute, $message, array('{file}'=>$file->getName(), '{height}'=>$this->maxHeight));
			}
		}
		if ($this->smallSideSize!==null) {
			if (min($info['height'], $info['width']) == $this->smallSideSize) {
				$message = $this->smallSideSizeError ? $this->smallSideSizeError : Yum::t('The image "{file}" small side should be "{side}px".', array(), 'coreMessages');
				$this->addError($object, $attribute, $message, array('{file}'=>$file->getName(), '{side}'=>$this->smallSideSize));
			}
		}
		if ($this->smallSideMinSize!==null) {
			if (min($info['height'], $info['width']) < $this->smallSideMinSize) {
				$message = $this->smallSideMinSizeError ? $this->smallSideMinSizeError : Yum::t('The image "{file}" small side should be at least "{side}px".', array(), 'coreMessages');
				$this->addError($object, $attribute, $message, array('{file}'=>$file->getName(), '{side}'=>$this->smallSideMinSize));
			}
		}
		if ($this->smallSideMaxSize!==null) {
			if (min($info['height'], $info['width']) > $this->smallSideMaxSize) {
				$message = $this->smallSideMaxSizeError ? $this->smallSideMaxSizeError : Yum::t('The image "{file}" small side should be at most "{side}px".', array(), 'coreMessages');
				$this->addError($object, $attribute, $message, array('{file}'=>$file->getName(), '{side}'=>$this->smallSideMaxSize));
			}
		}
		if ($this->bigSideSize!==null) {
			if (max($info['height'], $info['width']) == $this->bigSideSize) {
				$message = $this->bigSideSizeError ? $this->bigSideSizeError : Yum::t('The image "{file}" big side should be "{side}px".', array(), 'coreMessages');
				$this->addError($object, $attribute, $message, array('{file}'=>$file->getName(), '{side}'=>$this->bigSideSize));
			}
		}
		if ($this->bigSideMinSize!==null) {
			if (max($info['height'], $info['width']) < $this->bigSideMinSize) {
				$message = $this->bigSideMinSizeError ? $this->bigSideMinSizeError : Yum::t('The image "{file}" big side should be at least "{side}px".', array(), 'coreMessages');
				$this->addError($object, $attribute, $message, array('{file}'=>$file->getName(), '{side}'=>$this->bigSideMinSize));
			}
		}
		if ($this->bigSideMaxSize!==null) {
			if (max($info['height'], $info['width']) > $this->bigSideMaxSize) {
				$message = $this->bigSideMaxSizeError ? $this->bigSideMaxSizeError : Yum::t('The image "{file}" big side should be at most "{side}px".', array(), 'coreMessages');
				$this->addError($object, $attribute, $message, array('{file}'=>$file->getName(), '{side}'=>$this->bigSideMaxSize));
			}
		}
		if ($this->mimeType!==null) {
			$mimeTypes = is_scalar($this->mimeType) ? array($this->mimeType) : $this->mimeType;
			if (!in_array($info['mime'], $mimeTypes)) {
				$message=$this->mimeTypeError ? $this->mimeTypeError : Yum::t('The image "{file}" mime type "{mime}" is not allowed.', array(), 'coreMessages');
				$this->addError($object, $attribute, $message, array('{file}'=>$file->getName(), '{mime}'=>$info['mime']));
			}
		}
	}
}

?>
