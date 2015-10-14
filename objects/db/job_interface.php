<?php
namespace exporter\objects\db;

interface job_interface {

    public function setComment($comment);
    public function setCommentInactive($comment_inactive);
    public function setCommand($command);
    public function setTime($time);
}
