<?php

namespace exporter\objects\db;

use exporter\utils\utils;

class jobGroup {

    private $comment;
    private $active;

    /**
     * @return mixed
     */
    public function getComment() {
        return $this->comment;
    }

    /**
     * @return mixed
     */
    public function getActive() {
        return $this->active;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment) {
        $this->comment = $comment;
        utils::debug("setComment",$comment);
    }

    /**
     * @param mixed $active
     */
    public function setActive($active) {
        $this->active = $active;
        utils::debug("setActive",$active);
    }

}