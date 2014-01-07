return array(
        'sourcePath'=>dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..',
        'messagePath'=>dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'messages',
        'languages'=>array('da', 'de', 'eo', 'fr', 'it', 'nl', 'pl'),
        'autoMerge'=>true,
        'launchpad'=>true,
        'skipUnused'=>true,
        'fileTypes'=>array('php'),
        'exclude'=>array(
                '.svn',
                '.bzr',
                '/messages',
                '/protected/vendors/'
        ),
);
