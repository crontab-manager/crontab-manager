<?php
namespace exporter\objects\db;

class job /* implements job_interface */ {

    private $comment;
    private $comment_inactive;
    private $command;
    private $time;

    /**
     * @param mixed $comment
     */
    public function setComment($comment) {
        $this->comment = $comment;
        echo $this->comment . "\n";
    }

    /**
     * @param mixed $comment_inactive
     */
    public function setCommentInactive($comment_inactive) {
        $this->comment_inactive = $comment_inactive;
        echo $this->comment_inactive . "\n";
    }

    /**
     * @param mixed $command
     */
    public function setCommand($command) {
        $this->command = $command;
        echo $this->command . "\n";
    }

    /**
     * @param mixed $time
     */
    public function setTime($time) {
        $this->time = $time;
        echo $this->time . "\n";
    }



}