<?php
namespace exporter\objects\db;

interface job_interface {

    public function getComment();
    public function getCommentInactive();
    public function getCommand();
    public function isActive();
    public function getGroup();
    public function getTime();
    public function setComment($comment);
    public function setCommentInactive($comment_inactive);
    public function setCommand($command);
    public function setTime($m, $h, $dom, $mon, $dow);
    public function setActive($active);
    public function setGroup(jobGroup $group);
}
