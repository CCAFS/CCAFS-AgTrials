<?php
class msValidatorFile extends sfValidatorFile
{
  protected function getMimeType($file, $fallback)
  {
    $arrayZips = array( "application/zip", 
                        "application/x-zip", 
						"application/octet-stream",
                        "application/x-zip-compressed");

    $officeTypes = array(
        "application/vnd.ms-word.document.macroEnabled.12",
        "application/vnd.openxmlformats-officedocument.wordprocessingml.document", 
        "application/vnd.openxmlformats-officedocument.wordprocessingml.template", 
        "application/vnd.ms-powerpoint.template.macroEnabled.12", 
        "application/vnd.openxmlformats-officedocument.presentationml.template", 
        "application/vnd.ms-powerpoint.addin.macroEnabled.12", 
        "application/vnd.ms-powerpoint.slideshow.macroEnabled.12", 
        "application/vnd.openxmlformats-officedocument.presentationml.slideshow", 
        "application/vnd.ms-powerpoint.presentation.macroEnabled.12", 
        "application/vnd.openxmlformats-officedocument.presentationml.presentation", 
        "application/vnd.ms-excel.addin.macroEnabled.12", 
        "application/vnd.ms-excel.sheet.binary.macroEnabled.12", 
        "application/vnd.ms-excel.sheet.macroEnabled.12", 
        "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", 
        "application/vnd.ms-excel.template.macroEnabled.12", 
        "application/vnd.openxmlformats-officedocument.spreadsheetml.template");

		
    foreach ($this->getOption('mime_type_guessers') as $method){

      $type = call_user_func($method, $file);
		
      if (null !== $type && $type !== false)
      {
	 
        if (in_array($type, $arrayZips) && in_array($fallback, $officeTypes))
        {
           return $fallback;
        }
        return strtolower($type);
      }
    }

    return strtolower($fallback);
  }
}