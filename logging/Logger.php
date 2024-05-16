<?php

class Logger {
    private $directory;

    public function __construct($directory) {
        $this->directory = $directory;
    }

    private function getFileName() {
        return $this->directory.'delakilo.log';
    }

    private function log($heading, $message) {
        if (isset($_SESSION['username'])) {
            $message = '**'.get_username().'** '.$message;
        }
        file_put_contents($this->getFileName(), '['.date(DATE_FORMAT_LONG).'] '.$heading.': '.$message.' (from '.$_SERVER['SCRIPT_NAME'].')'.PHP_EOL, FILE_APPEND);
    }

    public function logInfo($message) {
        $this->log('INFO', $message);
    }

    public function logWarning($message) {
        $this->log('WARNING', $message);
    }

    public function logError($message) {
        $this->log('ERROR', $message);
    }

    public function logFatalError($message) {
        $this->log('FATAL ERROR', $message);
    }
}

?>