<?php
class sfValidatorFileZip extends sfValidatorFile{
  protected function configure($options = array(), $messages = array()){
    if (!ini_get('file_uploads'))
    {
      throw new LogicException(sprintf('Unable to use a file validator as "file_uploads" is disabled in your php.ini file (%s)', get_cfg_var('cfg_file_path')));
    }

    $this->addOption('max_size');
    $this->addOption('mime_types');
    $this->addOption('mime_type_guessers', array(
      array($this, 'guessFromFileinfo'),
      array($this, 'guessFromMimeContentType'),
      array($this, 'guessFromFileBinary'),
    ));
    $this->addOption('mime_categories', array(
      'web_images' => array(
        'image/jpeg',
        'image/pjpeg',
        'image/png',
        'image/x-png',
        'image/gif',
    ),
      'zip_file' => array(
            'application/zip'
    )
        ));
    $this->addOption('validated_file_class', 'sfValidatedFile');
    $this->addOption('path', null);

    $this->addMessage('max_size', 'File is too large (maximum is %max_size% bytes).');
    $this->addMessage('mime_types', 'Invalid mime type (%mime_type%).');
    $this->addMessage('partial', 'The uploaded file was only partially uploaded.');
    $this->addMessage('no_tmp_dir', 'Missing a temporary folder.');
    $this->addMessage('cant_write', 'Failed to write file to disk.');
    $this->addMessage('extension', 'File upload stopped by extension.');
  }
}